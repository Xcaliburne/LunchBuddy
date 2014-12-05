<?php

//echo "test";
require_once './personnesdb.php';

$jour = date(D);

$result = lirePersonneDisponible($jour);

echo json_encode($result);
//echo json_encode($result);



