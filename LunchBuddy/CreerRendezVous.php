<?php
if (!isset($_SESSION)) {
    session_start();
}
$erreur = "";
if ((!empty($_SESSION["idUtilisateur"])) && (!empty($_SESSION["email"]))) {
    require './MenusHTML.php';
    if (!empty($_GET["idUtilisateur"])) {
        $idUtilisateurInvite = $_GET["idUtilisateur"];
    } else {
        header('Location: index.php');
    }
    if (isset($_POST["submit"])) {
        if (!empty($_POST["commentaire"])) {
            if(!empty($_POST["lat"]) && !empty($_POST["lng"])){
                $idUtilisateurInvite = $_GET["idUtilisateur"];
                $idUtilisateur = $_SESSION["idUtilisateur"];
                $commentaire = $_POST["commentaire"];
                $lat = $_POST["lat"];
                $lng = $_POST["lng"];
                require 'groupesdb.php';
                $idGroupe = ajoutGroupe($_SESSION["email"]);
                $statut = 1;
                $statutInvite = 3;
            ajouterUtilisateurDansGroupe($idUtilisateurInvite, $idGroupe, $statutInvite);
            ajouterUtilisateurDansGroupe($idUtilisateur, $idGroupe, $statut);
                $date = getdate();
                $date = $date["year"] . "-" . $date["mon"] . "-" . $date["mday"];
            $email = $_SESSION["email"];
            try {
                $idGroupe = ajoutGroupe($email, TRUE, FALSE);
                ajouterUtilisateurDansGroupe(150, $idGroupe, $statutInvite);
                ajouterUtilisateurDansGroupe($idUtilisateur, $idGroupe, $statut);
                ajoutRendezvous($idGroupe, $date, $commentaire, FALSE, TRUE);
            } catch (Exception $ex) {
                transactionFail();
                echo $ex;
            }
            header('Location: index.php');
            }else{
                $erreur = "Veuillez choisir l'emplacement du rendez-vous en cliquant sur la carte";
            }
        } else {
            $erreur = "veuillez entrer les informations du rendez-vous";
        }
    }
} else {
    header('Location: index.php');
}
?>

<html>
    <head>
        <title>LunchBuddy - paramètres</title>
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
            <?php AfficheHeader(); ?>
            <!-- Fixed navbar -->
            <section class="col-md-8 col-md-offset-1">                
                <article>
                    <div class="row">
                        <h1 class="text-center">Créer un rendez-vous</h1>
                        <form class="form-horizontal" method="post" action="creerRendezVous.php?idUtilisateur=<?php echo $idUtilisateurInvite ?>">
                            <section class="col-md-6 col-md-offset-3">
                                <section class="form-group">
                                    <label for="commentaire" class="col-md-9 control-label">Entrez les informations du rendez-vous</label>
                                    <section class="col-md-12">
                                        <textarea name="commentaire" rows="5"></textarea>
                                    </section>
                                   <section class="col-md-12">                
                                        <div class="" id="googleMapRdv"></div>                                
                                    </section>
                                </section>                                 
                                <section class="col-md-12">
                                    <input type="hidden" id="lat" name="lat" value=""/>
                                    <input type="hidden" id="lng" name="lng" value=""/>
                                    <span class="pull-left alert-info"><?php echo $erreur ?></span>
                                    <button name="submit" class="btn btn-default pull-right" >Envoyer</button>
                                </section>
                        </form>
                    </div>
                </article>
            </section>
            <?php AfficheFooter(); ?>
            
            <script>
                window.onload = initialize("googleMapRdv", null);
                //google.maps.event.addDomListener(window, 'load', initialize);
            </script>
            
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        </section>
    </body>
</html>