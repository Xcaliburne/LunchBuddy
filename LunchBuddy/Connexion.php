<?php
if (!isset($_SESSION)) {
    session_start();
}
if ((empty($_SESSION["idPersonne"])) && (empty($_SESSION["email"]))) {
    $erreur = "";
    if (isset($_REQUEST['Connexion'])) {
        if ((!empty($_REQUEST['Email'])) && (!empty($_REQUEST['Password']))) {
            require 'personnesdb.php';
            $email = $_REQUEST['Email'];
            $password = sha1($_REQUEST['Password']);
            $erreur = '';
            try {
                $infosPersonnes = lirePersonneConnectee($email, $password);
                $personne = lireUnePersonneDepuisEmail($email);
                
                if (!$infosPersonnes) {
                    $erreur = 'Mot de passe ou Pseudo incorrecte';
                } else {
                    
                    
                    $_SESSION["idUtilisateur"] = $infosPersonnes["idUtilisateur"];
                    $_SESSION["rayon"] = $infosPersonnes["rayon"];
                    $_SESSION["email"] = $email;
                    $_SESSION["nom"] = $personne["nom"];
                    $_SESSION["prenom"] = $personne["prenom"];
                            
                    header('Location: index.php');
                }
            } catch (Exception $ex) {
                $erreur = $ex;
            }
        }
    }
}  else {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<head>
    <title>LunchBuddy - Connexion</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.css" type="text/css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" type="text/css" rel="stylesheet">
    <link href="css/source.css" type="text/css" rel="stylesheet">
</head>
<body>
    <section id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
        <section class="modal-dialog">
            <section class="modal-content">
                <header class="modal-header">
                    <h1 class="text-center">Se connecter</h1>
                </header>
                <section class="modal-body">
                    <form class="form col-md-12" method="post" action="index.php">
                        <section class="form-group">
                            <input name="Email" class="form-control input-lg" placeholder="Email" type="Email">
                        </section>
                        <section class="form-group">
                            <input name="Password" class="form-control input-lg" placeholder="Mot de passe" type="password">
                        </section>
                        <section class="form-group">
                            <button name="Connexion" class="btn btn-primary btn-lg btn-block">Se connecter</button>                            
                        </section>
                    </form>
                </section>
                <footer class="modal-footer">
                    <section class="col-md-12">
                        <span class="pull-left"><a href="Inscription.php">S'inscrire</a></span>
                        <span class="alert-danger pull-right"><?php echo $erreur ?></span>
                    </section>
                </footer>	
            </section>
        </section>
    </section>
</section>
</body>
