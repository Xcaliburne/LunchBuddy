/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var map;
var latUser;
var lngUser;
navigator.geolocation.getCurrentPosition(function(position) {
   latUser = position.coords.latitude;
   lngUser =position.coords.longitude;
}, null, {maximumAge:60000, timeout:5000, enableHighAccuracy:true});
function initialize(listePersonnes)
{
    var mapProp = {
        center:new google.maps.LatLng(46.198467, 6.141160),
        zoom:13,
        mapTypeId:google.maps.MapTypeId.ROADMAP
    };
    map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
    extraitMarqueur(map, listePersonnes);
}
 
 
function ajaxLoad()
{
    $.ajax({
       url : 'ajaxLirePersonnesDispo.php',
       type : 'GET',
       dataType : 'html',
       success : function(resultat, statut, error){ // success est toujours en place, bien sûr !
           initialize(JSON.parse(resultat));          
       },

       error : function(resultat, statut, error){
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

function successCallback(position){
  map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
  var marker = new google.maps.Marker({
    position: new google.maps.LatLng(position.coords.latitude, position.coords.longitude), 
    map: map
  }); 
}

function ajoutMarqueur(map, lat, lng, personne, rayon)
{
      var contentString = "<form action=\"CreerRendezVous.php?idUtilisateur=" + personne.idUtilisateur + "\" method=\"post\">\n\
                            <div>\n\
                                <div>" + personne.nom + ' ' + personne.prenom + "</div>\n\
                                <div>\n\
                                    <div><span>Disponibilité : "+ personne.debutPause + " à " + personne.finPause +"</span></div>\n\
                                    <div><input type=\"submit\" name=\"ajouter\" value=\"demande de rendez-vous\"/></div>\n\
                                </div>\n\
                            </div>\n\
                            </form>";
      
      var infowindow = new google.maps.InfoWindow({
            content: contentString
        });
        
     var coord = new google.maps.LatLng(lat, lng);
     var optionsMarker = {
         map: map,
         position: coord,
         title: personne.nom + ' ' + personne.prenom
     };
     
    var marker = new google.maps.Marker(optionsMarker);
   
            

    google.maps.event.addListener(marker, 'click', function() {
        infowindow.open(map,marker);
    });
 }

