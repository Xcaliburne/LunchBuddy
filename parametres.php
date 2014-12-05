<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once './personnesdb.php';
$erreur = "";
$regex = "#([01][0-9]|2[0-3]):[0-5][0-9]#";
if ((!empty($_SESSION["idUtilisateur"])) && (!empty($_SESSION["email"]))) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["adresse"])) {
            if (!empty($_POST["numeroRue"])) {
                if (!empty($_POST["NPA"])) {
                    if ((!empty($_POST["rayon"])) && (is_numeric($_POST["rayon"]))) {
                        if (!empty($_POST["debutDispo"]) && (preg_match($regex, $_POST["debutDispo"]))) {
                            if (!empty($_POST["finDispo"]) && (preg_match($regex, $_POST["debutDispo"]))) {
                                $debutDispo = $_POST["debutDispo"] . ":00";
                                $finDispo = $_POST["finDispo"] . ":00";
                                $parsed = date_parse($debutDispo);
                                $secondsDebut = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
                                $parsed = date_parse($finDispo);
                                $secondsfin = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second'];
                                if ($secondsDebut < $secondsfin) {
                                    echo 'test';
                                    $adresse = $_POST["adresse"];
                                    $numeroRue = $_POST["numeroRue"];
                                    $NPA = $_POST["NPA"];
                                    $rayon = $_POST["rayon"];
                                }
                            }
                        }
                    }
                }
            }
        }
    }
} else {
    header('Location: index.php');
}
?>

<html>
    <head>
        <title>LunchBuddy - Accueil</title>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <link href="css/bootstrap.min.css" type="text/css" rel="stylesheet">
        <link href="css/bootstrap-theme.min.css" type="text/css" rel="stylesheet">
        <link href="css/source.css" type="text/css" rel="stylesheet">
        <script src="http://maps.googleapis.com/maps/api/js?key=AIzaSyAn2Y_ZpNP2Zxpn_fXb988YV3FR77qo4sA"></script>
        <script src="./js/googleMap.js" type="text/javascript"></script>        
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
                <article>
                    <div class="row">
                        <h1 class="text-center">Informations du compte</h1>
                        <form class="form-horizontal" method="post" action="parametres.php">
                            <section class="col-md-6">
                                <section class="form-group">
                                    <label for="adresse" class="col-md-8 control-label">Adresse*</label>
                                    <section class="col-sm-4">
                                        <input type="text" required class="form-control" name="adresse" id="adresse">
                                    </section>
                                </section>
                                <section class="form-group">
                                    <label for="numeroRue" class="col-md-8 control-label">N° de rue*</label>
                                    <section class="col-sm-4">
                                        <input type="text" required class="form-control" name="numeroRue" id="numeroRue">
                                    </section>
                                </section>
                                <section class="form-group">
                                    <label for="NPA" class="col-md-8 control-label">NPA*</label>
                                    <section class="col-sm-4">
                                        <input type="text" required class="form-control" name="NPA" id="NPA">
                                    </section>
                                </section>
                            </section>
                            <section class="col-md-6">
                                <section class="form-group">
                                    <label for="rayon" class="col-md-8 control-label">Rayon de disponibilité(en mètres)*</label>
                                    <section class="col-sm-4">
                                        <input type="number" required class="form-control" name="rayon" id="rayon">
                                    </section>
                                </section>
                                <section class="form-group">
                                    <label for="debutDispo" class="col-md-8 control-label">Début de la disponibilité*</label>
                                    <section class="col-sm-4">
                                        <input type="text" required class="form-control" name="debutDispo" id="debutDispo">
                                    </section>
                                </section>                                
                                <section class="form-group">
                                    <label for="finDispo" class="col-md-8 control-label">Fin de la disponibilité*</label>
                                    <section class="col-sm-4">
                                        <input type="text" required class="form-control" name="finDispo" id="finDispo">
                                    </section>
                                </section>
                            </section>
                            <fieldset class="col-md-12">
                                <legend>jours de disponibilité:</legend>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="lundi" value="lundi">Lundi 
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="mardi" value="mardi"> Mardi
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="mercredi" value="mercredi"> Mercredi
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="jeudi" value="jeudi"> Jeudi
                                </label>
                                <label class="checkbox-inline">
                                    <input type="checkbox" id="vendredi" value="vendredi"> Vendredi
                                </label>
                            </fieldset>
                            <section class="col-md-12">
                                <button class="btn btn-default pull-right">Envoyer</button>
                            </section>
                        </form>
                    </div>
                </article>
            </section>
            <aside class="col-md-2 col-md-offset-1 asideMenu">
                <nav>
                    <ul class="nav nav-pills nav-stacked span2">
                        <li><a href="Deconnexion.php">Déconnexion</a></li>                        
                        <li><a href="parametres.php">Compte</a></li>
                        <li><a href="Rendezvous.php">Rendez-vous</a></li>
                    </ul>
                </nav>
            </aside>



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