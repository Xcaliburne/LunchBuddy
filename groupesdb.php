<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once './Connexiondb.php';
require_once './personnesdb.php';

function ajoutGroupe($nomGroupe) {
    $bdd = connexionDb();
    $sql = 'insert into groupes (nom) values (:nomGroupe)';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('nomGroupe' => $nomGroupe));
    return $bdd->lastInsertId();
}

function lireRendezVousUtilisateur($idUtilisateur) {
    $bdd = connexionDb();
    $sql = 'SELECT * FROM rendezvous as r
join groupes as g on r.idGroupe = g.idGroupe
join composer as c on c.idGroupe = g.idGroupe
join statuts as s on c.idStatut = s.idStatut
where c.idUtilisateur = :idUtilisateur';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idUtilisateur' => $idUtilisateur));
    return $requete->fetchAll();
}

function lireStatutParIdGroupe($id) {
    $bdd = connexionDb();
    $sql = 'SELECT idStatut FROM groupes WHERE idGroupe = :id ';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
    return $requete;
}

function lirerendezvous($idRdv) {
    $bdd = connexionDb();
    $sql = 'SELECT * FROM rendezvous WHERE idRdv = :idRdv ';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idRdv' => $idRdv));
    return $requete->fetch();
}

function ajouterUtilisateurDansGroupe($idUtilisateur, $idGroupe) {
    $bdd = connexionDb();
    $sql = 'INSERT INTO `composer`(`idUtilisateur`, `idGroupe`, `idStatut`) VALUES (:idUtilisateur,:idGroupe,3)';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idUtilisateur' => $idUtilisateur, 'idGroupe' => $idGroupe));
    return $bdd->lastInsertId();
}

function ajoutRendezvous($idGroupe, $date, $commentaire) {
    $bdd = connexionDb();
    $sql = 'insert into rendezvous (dateRdv, commentaire, idGroupe) values (:date, :commentaire, :idGroupe)';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('date' => $date, 'commentaire' => $commentaire, 'idGroupe' => $idGroupe));
    return $bdd->lastInsertId();
}

function supprimerRendezVous($idRdv){
    $bdd = connexionDb();
    $sql = 'DELETE FROM rendezvous WHERE idRdv = :idRdv';
    $requete = $bdd->prepare($sql);
    if($requete->execute(array('idRdv' => $idRdv))){
        return TRUE;
    }
    return FALSE;
}

function supprimerGroupe($idGroupe){
    $bdd = connexionDb();
    $sql = 'DELETE FROM groupes WHERE idGroupe = :idGroupe';
    $requete = $bdd->prepare($sql);
    if($requete->execute(array('idGroupe' => $idGroupe))){
        return TRUE;
    }
    return FALSE;
}

function supprimerpersonnesGroupe($idGroupe){
    $bdd = connexionDb();
    $sql = 'DELETE FROM composer WHERE idGroupe = :idGroupe';
    $requete = $bdd->prepare($sql);
    if($requete->execute(array('idGroupe' => $idGroupe))){
        return TRUE;
    }
    return FALSE;
}
