<?php
if (!isset($_SESSION)){
    session_start();
}
if ((empty($_SESSION["idUtilisateur"])) || (empty($_SESSION["email"]))) {
    require 'Connexion.php';
}  else {    
    require 'Accueil.php';

}
