<?php
if ((!empty($_SESSION["email"])) && (!empty($_SESSION["password"])) && (!empty($_SESSION["confirmation"]))){
    
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
        <div>
            <section id="loginModal" class="modal show" tabindex="-1" role="dialog" aria-hidden="true">
                <section class="modal-dialog">
                    <section class="modal-content">
                        <header class="modal-header">
                            <h1 class="text-center">S'inscrire</h1>
                        </header>
                        <section class="modal-body">
                            <form class="form col-md-12">
                            <section class="form-group">
                                <input class="form-control input-lg" placeholder="Email" type="text" name="email">
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
                            </section>
                        </footer>	
                    </section>
                </section>
            </section>
        </div>
    </body>
</html>
