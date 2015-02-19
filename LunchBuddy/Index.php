<?php
if (!isset($_SESSION)){
    session_start();
}
if ((empty($_SESSION["idPersonne"])) && (empty($_SESSION["email"]))){
    require 'Connexion.php';
}  else {
    
    require 'Accueil.php';

}
