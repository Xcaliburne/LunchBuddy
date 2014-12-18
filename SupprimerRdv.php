<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once 'personnesdb.php';
include_once 'groupesdb.php';
if ((!empty($_SESSION["idUtilisateur"])) && (!empty($_SESSION["email"]))) {
    if (!empty($_GET["idRdv"])) {
        $idRdv = $_GET["idRdv"];
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST["non"])) {
                header('Location: RendezVous.php');
            }
            if (isset($_POST["oui"])) {
                $rdv = lirerendezvous($idRdv);
                if (supprimerpersonnesGroupe($rdv["idGroupe"])) {
                    if (supprimerGroupe($rdv["idGroupe"])) {
                        if (supprimerRendezVous($idRdv)) {
                            header('Location: RendezVous.php');
                        }
                    }
                }
            } else {
                header('Location: RendezVous.php');
            }
        }
    } else {
        header('Location: index.php'); //retour à l'accueil
    }
} else {
    header('Location: index.php'); //retour à l'accueil
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>LunchBuddy - Suppression</title>
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
                <section class="navbar-header">
                    <a class="navbar-brand" href="Index.php">LunchBuddy</a>
                </section>
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
                        <h1 class="text-center">Suppression</h1>             
                        <form class="form-horizontal" method="post" action="supprimerRdv.php?idRdv=<?php echo $idRdv ?>">
                            <section class="col-md-12">
                                <section class="form-group">
                                    <label for="adresse" class="col-md-6 control-label">Êtes vous sûr de vouloir supprimer le rendez-vous ?</label>
                                    <section class="col-sm-4">
                                        <button name="non" class="btn btn-default pull-right">Non</button><button name="oui" class="btn btn-default pull-right">Oui</button>
                                    </section>
                                </section>
                            </section>
                        </form>
                    </div>
                </article>              
            </section> 
            <aside class="col-md-2 col-md-offset-1 asideMenu">
                <nav>
                    <ul class="nav nav-pills nav-stacked span2">
                        <li>bienvenue <?php echo $_SESSION["email"] ?></li>
                        <li><a href="Deconnexion.php">Déconnexion</a></li>                        
                        <li><a href="compte.php">Compte</a></li>
                        <li><a href="parametres.php">Paramètres</a></li>
                        <li><a href="Rendezvous.php">Rendez-vous</a></li>
                        <li><a href="CreerRendezVous.php?idUtilisateur=1">Creer RDV</a></li>
                    </ul>
                </nav>
            </aside>
        </section>
        <input type="hidden" id="rayonConnecte" value="<?php echo $_SESSION["rayon"]; ?>"/>
        <footer></footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </body>
</html>
