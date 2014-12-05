/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
var map;
navigator.geolocation.getCurrentPosition(function(position) {
  var latUser = position.coords.latitude;
  var lngUser =position.coords.longitude;
});
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
 
 function distance(lat_a, lon_a, lat_b, lon_b)  
 { 
     a = Math.PI / 180; 
     lat1 = lat_a * a; 
     lat2 = lat_b * a; 
     lon1 = lon_a * a; 
     lon2 = lon_b * a;  
     t1 = Math.sin(lat1) * Math.sin(lat2); 
     t2 = Math.cos(lat1) * Math.cos(lat2); 
     t3 = Math.cos(lon1 - lon2); 
     t4 = t2 * t3; 
     t5 = t1 + t4; 
     rad_dist = Math.atan(-t5/Math.sqrt(-t5 * t5 +1)) + 2 * Math.atan(1);  
     return (rad_dist * 3437.74677 * 1.1508) * 1.6093470878864446;
 }
   

function extraitMarqueur(map, listePersonne)
{
    var i = 0;
    for(i=0;i<listePersonne.length;i++)
    {
        var distance = distance(latUser, lngUser, listePersonne[i].lat, listePersonne[i].lng)*1000;
        if(document.getElementById("rayonConnecte").value >= distance)
        {
            ajoutMarqueur(map,listePersonne[i].lat,listePersonne[i].lng);
        }
        
    }
    
}

 function ajoutMarqueur(map, lat,lng)
 {
     var coord = new google.maps.LatLng(lat, lng);
     var marker = new google.maps.Marker({map: map, position: coord });
 }
/*function GetLocation() {
    var geocoder = new google.maps.Geocoder();
    var address = document.getElementById("txtAddress").value;
    geocoder.geocode({ 'address': address }, function (results, status) {
        if (status == google.maps.GeocoderStatus.OK) {
            var latitude = results[0].geometry.location.lat();
            var longitude = results[0].geometry.location.lng();
            alert("Latitude: " + latitude + "\nLongitude: " + longitude);
        } else {
            alert("Request failed.")
        }
    });
};*/
