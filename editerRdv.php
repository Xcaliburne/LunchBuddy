<?php
if (!isset($_SESSION)) {
    session_start();
}
$erreur = "";
include_once 'groupesdb.php';
if ((!empty($_SESSION["idUtilisateur"])) && (!empty($_SESSION["email"]))) {
    $idUtilisateur = $_SESSION["idUtilisateur"];
    if (!empty($_GET["idRdv"])) {
        $idRdv = $_GET["idRdv"];
    } else {
        header('Location: index.php');
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST["commentaire"])) {
            if (!empty($_POST["statut"]) && (is_numeric($_POST["statut"]))) {                
                $commentaire = $_POST["commentaire"];
                $statut = $_POST['statut'];                
                modifierRendezVous($idRdv, $commentaire);
                modifierComposer($idUtilisateur, $statut);
                header('Location: RendezVous.php');
            }
        } else {
            $erreur = "veuillez entrer les informations du rendez-vous";
        }
    }else{
        $infosRdv = lireRendezVous($idRdv, $idUtilisateur);
        $liste = array("1" => "Accepter", "2" => "Refuser", "3" => "Attendre");
        include_once './outilsFormulaires.php';
        $name = "statut";
        $selects = creerselect($name, $liste, $infosRdv["idStatut"]);
    }
} else {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title>LunchBuddy - Editer rendez-vous</title>
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
                        <li><a href="parametres.php">Paramètres</a></li>
                        <li><a href="Rendezvous.php">Rendez-vous</a></li> 
                        <li><a href="Deconnexion.php"><span class="glyphicon glyphicon-log-out"></span> Déconnexion</a></li>
                    </ul>
                </section>
            </header>
            <!-- Fixed navbar -->
            <section class="col-md-8 col-md-offset-1">                
                <article>
                    <div class="row">
                        <h1 class="text-center">Editer un rendez-vous</h1>
                        <form class="form-horizontal" method="post" action="editerRdv.php?idRdv=<?php echo $idRdv ?>">
                            <section class="col-md-6 col-md-offset-3">
                                <section class="form-group">
                                    <label for="commentaire" class="col-md-8 control-label">Entrez les informations du rendez-vous</label>
                                    <section class="col-md-12">
                                        <div><textarea name="commentaire" rows="5"><?php echo $infosRdv["commentaire"] ?></textarea></div>
                                        <div>
                                            <label for="statut">Statut : </label>
                                            <?php
                                            foreach ($selects as $select) {
                                                echo $select;
                                            }
                                            ?>
                                        </div>
                                    </section>
                                </section>                                 
                                <section class="col-md-12">
                                    <span class="pull-left alert-info"><?php echo $erreur ?></span>
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
                        <li><a href="parametres.php">Paramètres</a></li>
                        <li><a href="Rendezvous.php">Rendez-vous</a></li>                        
                    </ul>
                </nav>
            </aside>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        </section>
    </body>
</html>
