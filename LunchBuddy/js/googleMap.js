/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var map;
var latUser;
var lngUser;
var markerRdv;
var markerExist;
navigator.geolocation.getCurrentPosition(function(position) {
   latUser = position.coords.latitude;
   lngUser =position.coords.longitude;
}, null, {maximumAge:60000, timeout:5000, enableHighAccuracy:true});


function initialize(map_name,listePersonnes, listeRdv)
{
   markerExist = false; 
    
    var mapProp = {
        center:new google.maps.LatLng(46.198467, 6.141160),
        zoom:13,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    
    map=new google.maps.Map(document.getElementById(map_name),mapProp);//Crée la map avec toutes les personnes disponible
    
    if(map_name=="googleMapRdv"){
       if(listeRdv !== null){
            ajoutMarqueurRdv(listeRdv);
        } 
        
        google.maps.event.addListener(map, 'click', function(event) {  
        if(markerExist)
            markerRdv.setMap(null);
        
            placeMarker(event.latLng);
        });
    }
    if(map_name=="googleMap")
        extraitMarqueur(map, listePersonnes);
}
// 
function ajaxLoad(utilisateur)
{
    $.ajax({
       url : 'ajaxLirePersonnesDispo.php',
       type : 'GET',
       dataType : 'html',
       data: "idUtilisateur=" + utilisateur,
       success : function(resultat, statut, error){ // success est toujours en place, bien sûr !
           initialize("googleMap", JSON.parse(resultat), null);          
       },

       error : function(resultat, statut, error){
           alert(error);
       }
   });
 }
 
 function ajaxLoadRdv(rdv, utilisateur)
{
    $.ajax({
       url : 'ajaxLireRendezVous.php',
       type : 'GET',
       dataType : 'html',
       data: "idRdv=" + rdv + "&idUtilisateur=" + utilisateur,
       success : function(resultat, statut, error){ 
           console.log(resultat);
           initialize("googleMapRdv", null, JSON.parse(resultat));          
       },

       error : function(resultat, statut, error){
           console.log(resultat);
           console.log(error);
           alert(error);
       }
   });
 }
 

   

function extraitMarqueur(map, listePersonne)
{
    var i = 0;
    for(i=0;i<listePersonne.length;i++)
    {
        var latlngAutre = new google.maps.LatLng(listePersonne[i].lat, listePersonne[i].lng);
        var latlngCo = new google.maps.LatLng(latUser, lngUser);
        var distance = google.maps.geometry.spherical.computeDistanceBetween(latlngCo, latlngAutre);
        if(document.getElementById("rayonConnecte").value >= distance/1000)
        {
            ajoutMarqueur(map,listePersonne[i].lat,listePersonne[i].lng, listePersonne[i],distance);
        }
        
    }
} 



function placeMarker(location) {
 
 
  markerRdv = new google.maps.Marker({
    position: location,
    map: map
  });
  var infowindow = new google.maps.InfoWindow({
    //content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()
  });
  
  //infowindow.open(map,markerRdv);
  
  
  document.getElementById("lat").value = location.lat();
  document.getElementById("lng").value = location.lng();
  
  markerExist = true;
}

function successCallback(position){
  map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
  var marker = new google.maps.Marker({
    position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude), 
    map: map
  }); 
}

function ajoutMarqueurRdv(rdv)
{
    
    var coord = new google.maps.LatLng(rdv.lat, rdv.lng);
     markerRdv=  new google.maps.Marker({
         map: map,
         position: coord,
         title: rdv.idRdv
          
     });
     
   
            

    google.maps.event.addListener(markerRdv, 'click', function() {
        infowindow.open(map,markerRdv);
    });
    
    markerExist = true;
}

var infowindows = new Array();
function ajoutMarqueur(map, lat, lng, personne, rayon)
{
      var img;
      if(personne.avatar == null)
      {
          img = "";
      }else{
          img = "<div><img src=\"./upload/" + personne.avatar + "\" height=\"50\" width=\"50\"/></div>";
      }
      var contentString = "<form action=\"CreerRendezVous.php?idUtilisateur=" + personne.idUtilisateur + "\" method=\"post\">\n\
                            <div>\n\
                                "+ img +"\n\
                                <div>" + personne.nom + ' ' + personne.prenom + "</div>\n\
                                <div>\n\
                                    <div><span><strong>Disponibilité : "+ personne.debutPause + " à " + personne.finPause +"</strong></span></div>\n\
                                    <div><input type=\"submit\" name=\"ajouter\" value=\"demande de rendez-vous\"/></div>\n\
                                </div>\n\
                            </div>\n\
                            </form>";
  
      infowindows.push({"infoId" : personne.idUtilisateur, "infowindow": new google.maps.InfoWindow({
            content: contentString
        })});
     
      var image = {
        url: 'img/user.png',
        scaledSize : new google.maps.Size(30, 36)
            // This marker is 20 pixels wide by 32 pixels tall.
        //size: new google.maps.Size(50, 62),
        // The origin for this image is 0,0.
        //origin: new google.maps.Point(0,0),
        // The anchor for this image is the base of the flagpole at 0,32.
       // anchor: new google.maps.Point(0, 0)
      };
     var coord = new google.maps.LatLng(lat, lng);
     var optionsMarker = {
         map: map,
         position: coord,
         icon: image, 
         title: personne.nom + ' ' + personne.prenom
     };
     
    var marker = new google.maps.Marker(optionsMarker);
   
            

    google.maps.event.addListener(marker, 'click', function() {
        $.each(infowindows, function(index, value) {
            if(value["infoId"] == personne.idUtilisateur) {
                value["infowindow"].open(map,marker);
            } else {
                  value["infowindow"].close();
            }
         });
//        infowindows[0].open(map,marker);
    });
 }

