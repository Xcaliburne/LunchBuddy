<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require './personnesdb.php';

function ajoutGroupe($nomGroupe, $startTransaction = FALSE, $stopTransaction = FALSE) {
    $bdd = connexionDb();
    if ($startTransaction) {
        $bdd->beginTransaction();
    }
    $sql = 'insert into groupes (nom) values (:nomGroupe)';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('nomGroupe' => $nomGroupe));
    if ($stopTransaction) {
        $bdd->commit();
    }
    return $bdd->lastInsertId();
}

function lireGroupeParidRdv($id, $startTransaction = FALSE, $stopTransaction = FALSE) {
    $bdd = connexionDb();
    if ($startTransaction) {
        $bdd->beginTransaction();
    }
    $sql = 'SELECT idGroupe FROM rendezvous WHERE idRdv = :id';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
    if ($stopTransaction) {
        $bdd->commit();
    }
    return $requete->fetchAll();
}

function lireRendezVousUtilisateur($idUtilisateur, $startTransaction = FALSE, $stopTransaction = FALSE) {
    $bdd = connexionDb();
    if ($startTransaction) {
        $bdd->beginTransaction();
    }
    $sql = 'SELECT r.idRdv, r.dateRdv, r.commentaire, r.idGroupe, s.nomStatut, r.lat, r.lng, c.Envoye FROM rendezvous as r
    join groupes as g on r.idGroupe = g.idGroupe
    join composer as c on c.idGroupe = g.idGroupe
    join statuts as s on c.idStatut = s.idStatut
    where c.idUtilisateur = :idUtilisateur';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idUtilisateur' => $idUtilisateur));
    if ($stopTransaction) {
        $bdd->commit();
    }
    return $requete->fetchAll();
}

function lireRendezVous($idRdv, $idUtilisateur, $startTransaction = FALSE, $stopTransaction = FALSE) {
    $bdd = connexionDb();
    if ($startTransaction) {
        $bdd->beginTransaction();
    }
    $sql = 'SELECT r.commentaire, s.idStatut, s.nomStatut, r.lat, r.lng FROM rendezvous as r
    join groupes as g on r.idGroupe = g.idGroupe
    join composer as c on c.idGroupe = g.idGroupe
    join statuts as s on c.idStatut = s.idStatut
    where c.idUtilisateur = :idUtilisateur
    and r.idRdv = :idRdv';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idRdv' => $idRdv, 'idUtilisateur' => $idUtilisateur));
    if ($stopTransaction){
        $bdd->commit();
    }    
    return $requete->fetch();
}

function lireStatutParGroupeetUtilisateur($idGroupe, $idUtilisateur, $startTransaction = FALSE, $stopTransaction = FALSE) {
    $bdd = connexionDb();
    if ($startTransaction){
        $bdd->beginTransaction();
    }
    $sql = 'SELECT s.nomStatut FROM statuts as s
    join composer as c on c.idStatut = s.idStatut
    WHERE c.idGroupe = :idGroupe
    and c.idutilisateur = :idUtilisateur';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idGroupe' => $idGroupe, 'idUtilisateur' => $idUtilisateur));
    if ($stopTransaction){
        $bdd->commit();
    }
    return $requete->fetch();
}

function ajouterUtilisateurDansGroupe($idUtilisateur, $idGroupe, $idStatut, $Envoye,  $startTransaction = FALSE, $stopTransaction = FALSE) {
    $bdd = connexionDb();
    if ($startTransaction){
        $bdd->beginTransaction();
    }
    $sql = 'INSERT INTO `composer`(`idUtilisateur`, `idGroupe`, `idStatut`, `Envoye`) VALUES (:idUtilisateur, :idGroupe, :idStatut, :Envoye)';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idUtilisateur' => $idUtilisateur, 'idGroupe' => $idGroupe, 'idStatut' => $idStatut, 'Envoye' => $Envoye));
    if ($stopTransaction){
        $bdd->commit();
    }
    return $bdd->lastInsertId();
}

function modifierComposer($idUtilisateur, $idGroupe, $idStatut, $startTransaction = FALSE, $stopTransaction = FALSE) {
    $bdd = connexionDb();
    if ($startTransaction){
        $bdd->beginTransaction();
    }
    $sql = 'UPDATE composer SET idStatut = :statut WHERE idUtilisateur = :idUtilisateur and idGroupe = :idGroupe';
    $requete = $bdd->prepare($sql);
    $result = $requete->execute(array('statut' => $idStatut, 'idUtilisateur' => $idUtilisateur, 'idGroupe' => $idGroupe));
    if ($stopTransaction){
        $bdd->commit();
    }
    return $result;
}

function modifierRendezVous($idRdv, $commentaire,$lat, $lng, $startTransaction = FALSE, $stopTransaction = FALSE) {
    $bdd = connexionDb();
    if ($startTransaction){
    
        $bdd->beginTransaction();
    }
    $sql = 'UPDATE `rendezvous` SET commentaire = :commentaire, lat = :lat, lng = :lng 
    WHERE idRdv = :idRdv;';
    $requete = $bdd->prepare($sql);
    $result = $requete->execute(array('idRdv' => $idRdv, 'commentaire' => $commentaire, 'lat' => $lat, 'lng' => $lng));
    if ($stopTransaction){
        $bdd->commit();
    }
    return $result;
}

function ajoutRendezvous($idGroupe, $date, $commentaire, $lat, $lng, $startTransaction = FALSE, $stopTransaction = FALSE) {
    $bdd = connexionDb();
    if ($startTransaction){
        $bdd->beginTransaction();
    }
    $sql = 'insert into rendezvous (dateRdv, commentaire, lat, lng, idGroupe) values (:date, :commentaire, :lat, :lng, :idGroupe)';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('date' => $date, 'commentaire' => $commentaire, 'lat'=>$lat, 'lng'=>$lng, 'idGroupe' => $idGroupe));
    if ($stopTransaction){
        $bdd->commit();
    }
    return $bdd->lastInsertId();
}

function supprimerRendezVous($idRdv, $startTransaction = FALSE, $stopTransaction = FALSE) {
    $bdd = connexionDb();
    if ($startTransaction){
        $bdd->beginTransaction();
    }
    $sql = 'DELETE FROM rendezvous WHERE idRdv = :idRdv';
    $requete = $bdd->prepare($sql);
    if ($requete->execute(array('idRdv' => $idRdv))) {
        return TRUE;
    }
    if ($stopTransaction){
        $bdd->commit();
    }
    return FALSE;
}

function supprimerComposer($idUtilisateur, $idGroupe, $startTransaction = FALSE, $stopTransaction = FALSE) {
    $bdd = connexionDb();
    if ($startTransaction){
        $bdd->beginTransaction();
    }
    $sql = 'DELETE FROM composer WHERE idUtilisateur = :idUtilisateur AND idGroupe = :idGroupe';
    $requete = $bdd->prepare($sql);
    if ($requete->execute(array('idUtilisateur' => $idUtilisateur, 'idGroupe' => $idGroupe))) {
        return TRUE;
    }
    if ($stopTransaction){
        $bdd->commit();
    }
    return FALSE;
}

function supprimerGroupe($idGroupe, $startTransaction = FALSE, $stopTransaction = FALSE) {
    $bdd = connexionDb();
    if ($startTransaction){
        $bdd->beginTransaction();
    }
    $sql = 'DELETE FROM groupes WHERE idGroupe = :idGroupe';
    $requete = $bdd->prepare($sql);
    if ($requete->execute(array('idGroupe' => $idGroupe))) {
        return TRUE;
    }
    if ($stopTransaction){
        $bdd->commit();
    }
    return FALSE;
}

function supprimerpersonnesGroupe($idGroupe, $startTransaction = FALSE, $stopTransaction = FALSE) {
    $bdd = connexionDb();
    if ($startTransaction){
        $bdd->beginTransaction();
    }
    $sql = 'DELETE FROM composer WHERE idGroupe = :idGroupe';
    $requete = $bdd->prepare($sql);
    if ($requete->execute(array('idGroupe' => $idGroupe))) {
        return TRUE;
    }
    if ($stopTransaction){
        $bdd->commit();
    }
    return FALSE;
}

function lirePersonnesRdv($idGroupe, $startTransaction = FALSE, $stopTransaction = FALSE) {
    $bdd = connexionDb();
    if ($startTransaction){
        $bdd->beginTransaction();
    }
    $sql = 'select u.idUtilisateur, u.nom, u.prenom, u.email from composer as c
    join utilisateurs as u on c.idUtilisateur = u.idUtilisateur
    where c.idGroupe = :idGroupe';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idGroupe' => $idGroupe));
    if ($stopTransaction){
        $bdd->commit();
    }
    return $requete->fetchAll();
}

function transactionFail(){
    $bdd = connexionDb();
    $bdd->rollBack();
}

function transaction($email, $idUtilisateur, $idUtilisateurInvite, $statut, $statutInvite, $date, $commentaire) {
    $bdd = connexionDb();
    try {        
        $bdd->beginTransaction();
        $idGroupe = ajoutGroupe($email);
        ajouterUtilisateurDansGroupe($idUtilisateurInvite, $idGroupe, $statutInvite);
        ajouterUtilisateurDansGroupe($idUtilisateur, $idGroupe, $statut);
        ajoutRendezvous($idGroupe, $date, $commentaire);
        $bdd->commit();
    } catch (Exception $exc) {
        $bdd->rollBack();
        echo $exc->getTraceAsString();
    }
}
