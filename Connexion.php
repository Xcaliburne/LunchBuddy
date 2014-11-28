<?php
if (!isset($_SESSION)){
    session_start();
}
if (isset($_REQUEST['Connexion'])) {
    if ((!empty($_REQUEST['Email'])) && (!empty($_REQUEST['Password']))) {
        include_once 'personnesdb.php';
        $email = $_REQUEST['Email'];
        $password = $_REQUEST['Password'];
        $erreur = '';
        $infosPersonnes = lirePersonneConnectee($email, $password);
        if (!$infosPersonnes) {
            $erreur = 'Mot de passe ou Pseudo incorrecte';
        } else {
            $_SESSION["idPersonne"] = $infosPersonnes["idPersonne"];
            $_SESSION["nom"] = $infosPersonnes["Nom"];
            $_SESSION["prenom"] = $infosPersonnes["Prenom"];
            $_SESSION["email"] = $email;
            header('Location: index.php');
        }
    }
}
?>
<!DOCTYPE html>
<head>
    <title>LunchBuddy</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <style>
        .modal-footer{
            border-top: 0px;
        }
    </style>
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
                    </section>
                </footer>	
            </section>
        </section>
    </section>
</section>
</body>
