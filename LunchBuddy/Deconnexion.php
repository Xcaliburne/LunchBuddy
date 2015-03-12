<?php

if (!isset($_SESSION)) {
    session_start();
}
if ((empty($_SESSION["idUtilisateur"])) || (empty($_SESSION["nom"])) || (empty($_SESSION["prenom"])) || (empty($_SESSION["email"]))) {
    header('Location: index.php');
} else {
    unset($_SESSION["idUtilisateur"]);
    unset($_SESSION["nom"]);
    unset($_SESSION["prenom"]);
    unset($_SESSION["email"]);
    unset($_SESSION["rayon"]);
    header('Location: index.php');
}