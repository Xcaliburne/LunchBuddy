<?php
if (!isset($_SESSION)) {
    session_start();
}
include_once './personnesdb.php';
$erreur = "";
if ((empty($_SESSION["idPersonne"])) && (empty($_SESSION["email"]))) {
    if ((!empty($_POST["email"])) && (!empty($_POST["nom"])) && (!empty($_POST["prenom"])) && (!empty($_POST["password"])) && (!empty($_POST["confirmation"]))) {
        $email = $_POST["email"];
        $password = sha1($_POST["password"]);
        $nom = $_POST["nom"];
        $prenom = $_POST["prenom"];
        $confirmation = sha1($_POST["confirmation"]);
        $erreur = "Erreur : l'Email est déjà utilisé sur LunchBuddy";
        $uniqueEmail = estUniqueEmail($email);
        if (!$uniqueEmail) {
            $erreur = "Erreur : les mot de passe ne correspondent pas";
            if ($password == $confirmation){ 
                $erreur = "";
                try {
                    $id = inscrirePersonne($email, $password, $nom, $prenom);
                    $_SESSION["idUtilisateur"] = $id;
                    $_SESSION["email"] = $email;
                    header('Location: index.php');
                } catch (Exception $ex) {
                    $erreur = $ex;
                }
            }
        }
    }
} else {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>LunchBuddy - Inscription</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">

        <link href="css/bootstrap.css" rel="stylesheet" type="text/css"/>
        <link href="css/bootstrap-theme.css" rel="stylesheet" type="text/css"/>
        <link href="css/source.css" rel="stylesheet" type="text/css"/>  
    </head>
    <body>
        <section>
            <section id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
                <section class="modal-dialog">
                    <section class="modal-content">
                        <header class="modal-header">
                            <h1 class="text-center">S'inscrire</h1>
                        </header>
                        <section class="modal-body">
                            <form class="form col-md-12" action="Inscription.php" method="post">
                                <section class="form-group">
                                    <input class="form-control input-lg" placeholder="Email" type="text" name="email">
                                </section>
                                <section class="form-group">
                                    <input class="form-control input-lg" placeholder="Nom" type="text" name="nom">
                                </section>
                                <section class="form-group">
                                    <input class="form-control input-lg" placeholder="Prenom" type="text" name="prenom">
                                </section>
                                <section class="form-group">
                                    <input class="form-control input-lg" placeholder="Mot de passe" type="password" name="password">
                                </section>
                                <section class="form-group">
                                    <input class="form-control input-lg" placeholder="Confirmation" type="password" name="confirmation">
                                </section>
                                <section class="form-group">
                                    <input class="btn btn-primary btn-lg btn-block" type="submit" name="inscrire" value="S'inscrire">                                    
                                </section>
                            </form>
                        </section>
                        <footer class="modal-footer">
                            <section class="col-md-12">
                                <span class="pull-left"><a href="connexion.php">Se connecter</a></span>
                                <span class="alert-danger pull-right"><?php echo $erreur ?></span>
                            </section>
                        </footer>	
                    </section>
                </section>
            </section>
        </section>
    </body>
</html>