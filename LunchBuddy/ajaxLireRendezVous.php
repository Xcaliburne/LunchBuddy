<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require './groupesdb.php';

$idUtilisateur =$_REQUEST["idUtilisateur"];
$idRdv = $_REQUEST["idRdv"];

$result = lireRendezVous($idRdv, $idUtilisateur);
/*echo "<pre>";
var_dump($result);
echo "</pre>";*/
echo json_encode($result);
