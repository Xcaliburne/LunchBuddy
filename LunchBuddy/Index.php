<?php
if (!isset($_SESSION)){
    session_start();
}
if ((empty($_SESSION["idPersonne"])) && (empty($_SESSION["email"]))){
    include_once 'Connexion.php';
}  else {
    
    include_once 'Accueil.php';

}
