<?php 
    include 'personnesdb.php';
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
        <script src="./js/googleMap.js" type="text/javascript"></script>

        <script>
            window.onload = ajaxLoad;
            //google.maps.event.addDomListener(window, 'load', initialize);
        </script>
<!-- <script src="js/JQuery.js"></script> -->
<!-- <script src="js/bootstrap.min.js"></script> -->
    </head>
    <body>
        <section class="col-md-12 conteneur">
            <header class="navbar-inverse">
                <header class="navbar-header">
                    <a class="navbar-brand" href="Index.php">LunchBuddy</a>
                </header>
                <section class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav navbar-right">     
                        <li><a href="">Compte</a></li>
                        <li><a href="">Rendez-vous</a></li>
                        <li><a href="Deconnexion.php"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
                    </ul>
                </section>
            </header>
            <!-- Fixed navbar -->
            <section class="col-md-8 col-md-offset-1">                
                <div class="" id="googleMap"></div>                                
            </section>
            <aside class="col-md-2 col-md-offset-1 asideMenu">
                <nav>
                    <ul class="nav nav-pills nav-stacked span2">
                        <li><a href="Deconnexion.php">Déconnexion</a></li>
                        <li><a href="Compte.php">Compte</a></li>
                        <li><a href="parametres.php">Compte</a></li>
                        <li><a href="Rendezvous.php">Rendez-vous</a></li>
                    </ul>
                </nav>
            </aside>

            </section>
        <input type="hidden" id="rayonConnecte" value="<?php echo $_SESSION["rayon"]; ?>"/>


<!--<section id="wrapper">
    <aside id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand"></li>
            <li></li>
            <li></li>
        </ul>
    </aside>
</section>-->

            <footer></footer>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        </section>
    </body>
</html>
