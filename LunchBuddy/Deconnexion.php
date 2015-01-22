<?php
if (!isset($_SESSION)){
    session_start();
}
if ((empty($_SESSION["idPersonne"])) && (empty($_SESSION["nom"])) && (empty($_SESSION["prenom"])) && (empty($_SESSION["email"]))){
    header('Location: index.php');
}  else {
    $_SESSION["idPersonne"] = "";
    $_SESSION["nom"] = "";
    $_SESSION["prenom"] = "";
    $_SESSION["email"] = "";
    header('Location: index.php');
}