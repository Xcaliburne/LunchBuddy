<?php

//echo "test";
require './personnesdb.php';

$jour = date('N');
$idUtilisateur =$_REQUEST["idUtilisateur"];

$result = lirePersonneDisponible($jour,$idUtilisateur);
/*echo "<pre>";
var_dump($result);
echo "</pre>";*/
echo json_encode($result);
//echo json_encode($result);



