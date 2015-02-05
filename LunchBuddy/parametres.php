<?php
if (!isset($_SESSION)) {
    session_start();
}
if ((!empty($_SESSION["idUtilisateur"])) && (!empty($_SESSION["email"]))) {
    include_once './personnesdb.php';
    include_once './outilsFormulaires.php';
    include_once './MenusHTML.php';
    $erreur = "";
    $regex = "#([01][0-9]|2[0-3]):[0-5][0-9]#"; //expression régulière d'une heure
    $idUtilisateur = $_SESSION["idUtilisateur"];
    $parametres = lireParametresUtilisateur($idUtilisateur); //récuperation des paramètres d'un utilisateur
    $name = 'jours';
    $liste = array(1 => 'Lundi', 2 => 'Mardi', 3 => 'Mercredi', 4 => 'Jeudi', 5 => 'Vendredi');
    $checked = lireDisponibilites($idUtilisateur);
    foreach ($checked as &$element) {  //mise en forme du tableau
        $element = $element[0];
    }
    $checkboxes = creerCheckboxes($name, $liste, $checked); //création des checkboxes
    if ($_SERVER["REQUEST_METHOD"] == "POST") { //si la requete est en post
        $erreur = "veuillez entrer toutes les informations";  //initialisation de l'erreur
        if (!empty($_POST["nom"])) { //contrôle de la saisie des champs
            if (!empty($_POST["prenom"])) {
                if (!empty($_POST["email"])) {
                    if (!empty($_POST["adresse"])) { //contrôle de la saisie des champs
                        if (!empty($_POST["numeroRue"])) {
                            if (!empty($_POST["NPA"])) {
                                if ((!empty($_POST["rayon"])) && (is_numeric($_POST["rayon"]))) { //si le rayon est renseigné et numerique
                                    if (!empty($_POST["debutDispo"]) && (preg_match($regex, $_POST["debutDispo"]))) { //si l'heure correspond au format requis
                                        if (!empty($_POST["finDispo"]) && (preg_match($regex, $_POST["finDispo"]))) { //si l'heure correspond au format requis
                                            if (isset($_POST["jours"])) {
                                                $jours = $_POST["jours"];
                                            } else {
                                                $jours = "";
                                            }
                                            if (isset($_FILES) && is_array($_FILES)) { //contrôle si un avatar a été sélectionné
                                                $uploaddir = realpath('.') . '/upload/';
                                                $ancienAvatar = './upload/' . $parametres[0]["avatar"];
                                                unlink($ancienAvatar);
                                                $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION); //récupère l'extension du fichier
                                                $filesize = filesize($_FILES['avatar']['tmp_name']);
                                                $destination_filename = uniqid('_image_', true) . '.' . $ext;
                                                $avatar = $destination_filename;

                                                if ($ext == 'png' || $ext == 'jpg' || $ext == 'gif') {
                                                    if ($filesize < 1024 * 1024 * 1024 * 0.2) {//taille du fichier plus petit de 2MB admis
                                                        $copie = move_uploaded_file($_FILES['avatar']['tmp_name'], $uploaddir . $destination_filename);
                                                    } else {
                                                        $avatar = NULL;
                                                    }
                                                    echo $filesize;
                                                }
                                            }
                                            $erreur = "";
                                            $nom = trim($_POST["nom"]);
                                            $prenom = trim($_POST["prenom"]);
                                            $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
                                            $debutDispo = $_POST["debutDispo"] . ":00";
                                            $finDispo = $_POST["finDispo"] . ":00";
                                            $parsed = date_parse($debutDispo);
                                            $secondsDebut = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second']; //transformation de l'heure en secondes
                                            $parsed = date_parse($finDispo);
                                            $secondsfin = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second']; //transformation de l'heure en secondes
                                            if ($secondsDebut < $secondsfin) {//
                                                unset($parsed);
                                                unset($secondsDebut);
                                                unset($secondsfin);
                                                $adresse = $_POST["adresse"];
                                                $numeroRue = $_POST["numeroRue"];
                                                $NPA = $_POST["NPA"];
                                                $rayon = $_POST["rayon"];
                                                if (ModiferParametres($idUtilisateur, $nom, $prenom, $email, $adresse, $numeroRue, $NPA, $rayon, $debutDispo, $finDispo, $destination_filename)) {
                                                    if (ModiferParametres($idUtilisateur, $adresse, $numeroRue, $NPA, $rayon, $debutDispo, $finDispo, $avatar)) {
                                                        if (supprimerJoursDisponibiliteUtilisateur($idUtilisateur)) {
                                                            if (!empty($jours)) {
                                                                foreach ($jours as $jour) {//pour chaque jour
                                                                    if ((is_numeric($jour)) or ( $jour > 1) or ( $jour < 5)) { //si le jour correspond
                                                                        if (ajouterDisponibilite($idUtilisateur, $jour) == FALSE) {//ajout du jour dans la db
                                                                            $erreur = "ajout des disponibilités impossible";
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    } else {
                                                        $erreur = "modification interrompue";
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($erreur == "") {
            header('Location: index.php'); //retour à l'accueil
        }
    }
} else {
    header('Location: parametres.php'); //retour à l'accueil
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
            <section class="col-md-12">                
                <article>
                    <h1 class="text-center">Informations du compte</h1>
                    <form class="form-horizontal" method="post" action="parametres.php" enctype="multipart/form-data">
                        <section class="col-md-5">
                            <section class="form-group">
                                <label for="nom" class="control-label">Nom*</label>
                                <section class="">
                                    <input type="text" required class="form-control" value="<?php echo $parametres[0]["nom"] ?>" name="nom" id="nom">
                                </section>
                            </section>
                            <section class="form-group">
                                <label for="prenom" class="control-label">Prenom*</label>
                                <section class="">
                                    <input type="text" required class="form-control" value="<?php echo $parametres[0]["prenom"] ?>" name="prenom" id="prenom">
                                </section>
                            </section>
                            <section class="form-group">
                                <label for="email" class="control-label">Email*</label>
                                <section class="">
                                    <input type="text" required class="form-control" value="<?php echo $parametres[0]["email"] ?>" name="email" id="email">
                                </section>
                            </section>
                            <section class="form-group">
                                <label for="adresse" class="control-label">Adresse*</label>
                                <section class="">
                                    <input type="text" required class="form-control" value="<?php echo $parametres[0]["nomRue"] ?>" name="adresse" id="adresse">
                                </section>
                            </section>
                            <section class="form-group">
                                <label for="numeroRue" class="control-label">N° de rue*</label>
                                <section class="">
                                    <input type="text" required class="form-control" value="<?php echo $parametres[0]["numeroRue"] ?>" name="numeroRue" id="numeroRue">
                                </section>
                            </section>                            
                        </section>
                        <section class="col-md-5 col-md-offset-2">
                            <section class="form-group">
                                <label for="NPA" class="control-label">NPA*</label>
                                <section class="">
                                    <input type="text" required class="form-control" value="<?php echo $parametres[0]["NPA"] ?>" name="NPA" id="NPA">
                                </section>
                            </section>
                            <section class="form-group">
                                <label for="rayon" class="control-label">Rayon de disponibilité(en kilomètres)*</label>
                                <section class="">
                                    <input type="number" required class="form-control" value="<?php echo $parametres[0]["rayon"] ?>" name="rayon" id="rayon">
                                </section>
                            </section>
                            <section class="form-group">
                                <label for="debutDispo" class="control-label">Début de la disponibilité*</label>
                                <section class="">
                                    <input type="text" required class="form-control" value="<?php echo $parametres[0]["debutPause"] ?>" name="debutDispo" id="debutDispo">
                                </section>
                            </section>                                
                            <section class="form-group">
                                <label for="finDispo" class="control-label">Fin de la disponibilité*</label>
                                <section class="">
                                    <input type="text" required class="form-control" value="<?php echo $parametres[0]["finPause"] ?>" name="finDispo" id="finDispo">
                                </section>
                            </section>
                            <section class="form-group">
                                <label for="avatar" class="control-label">Changer d'avatar</label>
                                <section class="form-group col-md-10">                                    
                                    <input type="file" class="form-control" value=""  name="avatar" id="avatar" accept="image/*">                                    
                                </section>
                                <section class="pull-right">
                                    <img src="./upload/<?php echo $parametres[0]["avatar"] ?>" value="<?php echo $parametres[0]["avatar"] ?>" alt="<?php
            echo $_SESSION["nom"];
            echo " ";
            echo $_SESSION["prenom"]
            ?>" height="50" width="50"/>
                                </section>
                            </section>                            
                        </section>                                                 
                        <fieldset class="col-md-12">
                            <legend>jours de disponibilité:</legend>
                            <?php
                            foreach ($checkboxes as $checkboxe) {
                                echo $checkboxe;
                            }
                            ?>                                
                        </fieldset>
                        <section class="col-md-5">

                        </section>  
                        <section class="col-md-12">
                            <?php if (!empty($erreur)) { ?>
                                <div class="pull-left alert alert-danger"><?php echo $erreur; ?></div>
                            <?php } ?>

                            <button class="btn btn-default pull-right">Envoyer</button>

                        </section>
                    </form>                    
                </article>
            </section>
            <?php AfficheFooter(); ?>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
            <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        </section>
    </body>
</html>