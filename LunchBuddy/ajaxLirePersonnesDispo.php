<?php

//echo "test";
require_once './personnesdb.php';

$jour = date('N');

$result = lirePersonneDisponible($jour);
/*echo "<pre>";
var_dump($result);
echo "</pre>";*/
echo json_encode($result);
//echo json_encode($result);



