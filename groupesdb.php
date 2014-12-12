<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './Connexiondb.php';
require_once './personnesdb.php';

function ajoutGroupe($id, $nomGroupe){
    $bdd = connexionDb();
    $sql = 'insert into groupes (nom, idStatut) values (:nomGroupe, 3)';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('nomGroupe'=>$nomGroupe));
    return $bdd->lastInsertId();
}

function lireStatutParIdGroupe($id)
{
    $bdd = connexionDb();
    $sql = 'SELECT idStatut FROM groupes WHERE idGroupe = :id ';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id'=>$id));
    return $requete;
    
}

function ajoutRendezvous($idGroupe, $date, $comm, $idUtilisateur, $idstatut){
    $bdd = connexionDb();
    $sql = 'insert into rendezvous (dateRdv, commentaire, accepte, idGroupe, idUtilisateur) values (:date, :comm, :statut, :idGroupe, :idUtilisateur)';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('date'=>$date, 'comm' => $comm, 'statut' => $idstatut, 'idGroupe' => $idGroupe, 'idUtilisateur' => $idUtilisateur));
    return $bdd->lastInsertId();
}