<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once 'personnesdb.php';
include_once 'groupesdb.php';
if ((!empty($_SESSION["idUtilisateur"])) && (!empty($_SESSION["email"]))) {
    $idUtilisateur = $_SESSION["idUtilisateur"];
    $rdvs = lireRendezVousUtilisateur($idUtilisateur);
    foreach ($rdvs as &$rdv) {
        $idGroupe = $rdv["idRdv"];
        $personnes = lirePersonnesRdv($idGroupe);
        $i = 0;
        foreach ($personnes as &$personne) {            
            if ($personne["idUtilisateur"] == $idUtilisateur) {
                unset($personnes[$i]);
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
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>date</th>
                            <th>Informations</th>
                            <th>Utilisateur</th>
                            <th>statut</th>
                            <th>Modifier</th>
                            <th>Supprimer</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($rdvs as $rdv) {
                            echo ''
                            . '<tr>'
                            . '<td>'
                            . $rdv["dateRdv"]
                            . '</td>'
                            . '<td>'
                            . $rdv["commentaire"]
                            . '</td>'
                            . '<td>';
                            foreach ($rdv["personnes"] as $personne) {
                                echo $personne["prenom"] . " " .$personne["nom"];
                            };
                            echo ''
                            . '</td>'
                            . '<td>'
                            . $rdv["nomStatut"]
                            . '</td>'
                            . '<td>'
                            . '<a href="editerRdv.php?idRdv=' . $rdv["idRdv"] . '"><span class="glyphicon glyphicon-cog"></span></a>'
                            . '</td>'
                            . '<td>'
                            . '<a href="supprimerRdv.php?idRdv=' . $rdv["idRdv"] . '"><span class="glyphicon glyphicon-remove"></span></a>'
                            . '</td>'
                            . '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
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
