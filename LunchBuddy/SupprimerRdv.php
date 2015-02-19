<?php
if (!isset($_SESSION)) {
    session_start();
}
require 'personnesdb.php';
require 'groupesdb.php';
require './MenusHTML.php';
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
<!-- <script src="js/JQuery.js"></script> -->
<!-- <script src="js/bootstrap.min.js"></script> -->
    </head>
    <body>
        <section class="col-md-12 conteneur">
            <?php AfficheHeader(); ?>
            <!-- Fixed navbar -->
            <section class="col-md-12">                
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
            <?php Affichefooter(); ?>
        </section>        
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </body>
</html>
