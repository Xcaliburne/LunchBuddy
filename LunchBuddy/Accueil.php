<?php
require 'groupesdb.php';
require 'MenusHTML.php';
require 'Fonctions.php';
$Notifs = Notif();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>LunchBuddy - Accueil</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="css/bootstrap-theme.min.css" type="text/css" rel="stylesheet">
        <link href="css/source.css" type="text/css" rel="stylesheet">
        <script src="./js/JQuery.js" type="text/javascript"></script>
        <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAn2Y_ZpNP2Zxpn_fXb988YV3FR77qo4sA"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?libraries=geometry"></script>
        <script src="./js/googleMap.js" type="text/javascript"></script>

        <script>
            $(document).ready(function () {
                ajaxLoad(document.getElementById("idUtilisateur").value);
            });
            //google.maps.event.addDomListener(window, 'load', initialize);
        </script>
<!-- <script src="js/JQuery.js"></script> -->
<!-- <script src="js/bootstrap.min.js"></script> -->
    </head>
    <body>
        <section class="col-md-12 conteneur">
            <?php AfficheHeader(); ?>
            <!-- Fixed navbar -->
            <section class="col-md-12">    
                <h1 class="col-md-8 T_Accueil">Voici les personnes disponibles aujourd'hui :</h1>               
                <?php echo $Notifs; ?>                                 
                <div class="col-md-12" id="googleMap"></div>                                
            </section>
        </section>
        <?php AfficheFooter(); ?>
        <form>
            <input type="hidden" id="rayonConnecte" value="<?php echo $_SESSION["rayon"]; ?>"/>      
            <input type="hidden" id="idUtilisateur" value="<?php echo $_SESSION["idUtilisateur"]; ?>"/>
        </form>       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </body>
</html>
