<?php

//echo "test";
require './groupesdb.php';

$idUtilisateur =$_REQUEST["idUtilisateur"];


$result = lireRendezVousUtilisateur($idUtilisateur);

echo json_encode($result);