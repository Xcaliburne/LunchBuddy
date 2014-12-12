<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './Connexiondb.php';
require_once './personnesdb.php';

function ajoutGroupe($idConnecte, $idUtilisateur, $nomGroupe, $date, $comm ){
    $bdd = connexionDb();
    $sql = 'insert into groupe (email, password) values (:email, :password)';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('email'=>$email, 'password' => $password));
    return $bdd->lastInsertId();
}