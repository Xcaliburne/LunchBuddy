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
        zoom:10,
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
 

 
 function calcDistance(LatB, LngB){
   rad = function(x) {return x*Math.PI/180;}


  var R     = 6371;                          //Rayon de la Terre en km
  var dLat  = rad( LatB - latUser );
  var dLong = rad( LngB - lngUser );

  var a = Math.sin(dLat/2) * Math.sin(dLat/2) + Math.cos(rad(latUser)) * Math.cos(rad(LatB)) * Math.sin(dLong/2) * Math.sin(dLong/2);
  var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
  var d = R * c;

  return d.toFixed(3);                      //Retour 3 décimales
}

   

function extraitMarqueur(map, listePersonne)
{
    var i = 0;
    for(i=0;i<listePersonne.length;i++)
    {
        var distance = calcDistance(listePersonne[i].lat, listePersonne[i].lng);
        if(document.getElementById("rayonConnecte").value >= distance)
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
      var contentString = personne.nom + ' ' + personne.prenom;
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

