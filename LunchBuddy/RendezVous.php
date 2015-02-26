<?php
if (!isset($_SESSION)) {
    session_start();
}
require 'groupesdb.php';
require './MenusHTML.php';
if ((!empty($_SESSION["idUtilisateur"])) && (!empty($_SESSION["email"]))) {
    $idUtilisateur = $_SESSION["idUtilisateur"];
    $rdvs = lireRendezVousUtilisateur($idUtilisateur);
    foreach ($rdvs as &$rdv) {
        $idGroupe = $rdv["idGroupe"];
        $personnes = lirePersonnesRdv($idGroupe);
        $i = 0;
        foreach ($personnes as &$pers) {
            if ($pers["idUtilisateur"] == $idUtilisateur) {
                unset($personnes[$i]);
            } else {
                $pers["statutPersonne"] = lireStatutParGroupeetUtilisateur($idGroupe, $pers["idUtilisateur"]);
                $pers["statutPersonne"] = $pers["statutPersonne"]["nomStatut"];
            }
            $i++;
        }
        $rdv["personnes"] = $personnes;
    }
} else {
    header('Location: index.php'); //retour à l'accueil
}
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
<!-- <script src="js/JQuery.js"></script> -->
<!-- <script src="js/bootstrap.min.js"></script> -->
    </head>
    <body>
        <section class="col-md-12 conteneur">
            <?php AfficheHeader(); ?>
            <!-- Fixed navbar -->
            <section class="col-md-12"> 
                <h1 class="text-center">Rendez-vous</h1>
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>date</th>
                            <th>Informations</th>
                            <th>Mon Statut</th>
                            <th>Utilisateur</th>
                            <th>statut du contact</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($rdvs as $rendezvous) {
                            echo ''
                            . '<tr>'
                            . '<td>'
                            . $rendezvous["dateRdv"]
                            . '</td>'
                            . '<td>'
                            . $rendezvous["commentaire"]
                            . '</td>'
                            . '<td>'
                            . $rendezvous["nomStatut"]
                            . '</td>';
                            foreach ($rendezvous["personnes"] as $personne) {
                                echo '<td>'
                                . $personne["prenom"] . " " . $personne["nom"]
                                . '</td>'
                                . '<td>'
                                . $personne["statutPersonne"]
                                . '</td>';
                            };
                            echo ''
                            . '<td>'
                            . '<a href="editerRdv.php?idRdv=' . $rendezvous["idRdv"] . '&idGroupe=' . $rendezvous["idGroupe"] . '"><span class="glyphicon glyphicon-cog"></span></a>'
                            . '</td>'
                            . '<td>'
                            . '<a href="supprimerRdv.php?idRdv=' . $rendezvous["idRdv"] . '"><span class="glyphicon glyphicon-remove"></span></a>'
                            . '</td>'
                            . '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </section>
            <?php AfficheFooter(); ?>
        </section>       
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    </body>
</html>
