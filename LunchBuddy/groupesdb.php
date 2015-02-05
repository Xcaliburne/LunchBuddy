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

function lireGroupeParidRdv($id) {
    $bdd = connexionDb();
    $sql = 'SELECT idGroupe FROM rendezvous WHERE idRdv = :id';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('id' => $id));
    return $requete->fetchAll();
}

function lireRendezVousUtilisateur($idUtilisateur) {
    $bdd = connexionDb();
    $sql = 'SELECT r.idRdv, r.dateRdv, r.commentaire, r.idGroupe, s.nomStatut, r.lat, r.lng FROM rendezvous as r
join groupes as g on r.idGroupe = g.idGroupe
join composer as c on c.idGroupe = g.idGroupe
join statuts as s on c.idStatut = s.idStatut
where c.idUtilisateur = :idUtilisateur';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idUtilisateur' => $idUtilisateur));
    return $requete->fetchAll();
}

function lireRendezVous($idRdv, $idUtilisateur) {
    $bdd = connexionDb();
    $sql = 'SELECT r.commentaire, s.idStatut, s.nomStatut, r.lat, r.lng FROM rendezvous as r
join groupes as g on r.idGroupe = g.idGroupe
join composer as c on c.idGroupe = g.idGroupe
join statuts as s on c.idStatut = s.idStatut
where c.idUtilisateur = :idUtilisateur
and r.idRdv = :idRdv';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idRdv' => $idRdv, 'idUtilisateur' => $idUtilisateur));
    return $requete->fetch();
}

function lireStatutParGroupeetUtilisateur($idGroupe, $idUtilisateur) {
    $bdd = connexionDb();
    $sql = 'SELECT s.nomStatut FROM statuts as s
join composer as c on c.idStatut = s.idStatut
WHERE c.idGroupe = :idGroupe
and c.idutilisateur = :idUtilisateur';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idGroupe' => $idGroupe, 'idUtilisateur' => $idUtilisateur));
    return $requete->fetch();
}

function ajouterUtilisateurDansGroupe($idUtilisateur, $idGroupe, $idStatut) {
    $bdd = connexionDb();
    $sql = 'INSERT INTO `composer`(`idUtilisateur`, `idGroupe`, `idStatut`) VALUES (:idUtilisateur, :idGroupe, :idStatut)';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idUtilisateur' => $idUtilisateur, 'idGroupe' => $idGroupe, 'idStatut' => $idStatut));
    return $bdd->lastInsertId();
}

function modifierComposer($idUtilisateur, $idGroupe, $idStatut) {
    $bdd = connexionDb();
    $sql = 'UPDATE composer SET idStatut = :statut WHERE idUtilisateur = :idUtilisateur and idGroupe = :idGroupe';
    $requete = $bdd->prepare($sql);
    $result = $requete->execute(array('statut' => $idStatut, 'idUtilisateur' => $idUtilisateur, 'idGroupe' => $idGroupe));
    return $result;
}

function modifierRendezVous($idRdv, $commentaire) {
    $bdd = connexionDb();
    $sql = 'UPDATE `rendezvous` SET commentaire = :commentaire 
    WHERE idRdv = :idRdv;';
    $requete = $bdd->prepare($sql);
    $result = $requete->execute(array('idRdv' => $idRdv, 'commentaire' => $commentaire));
    return $result;
}

function ajoutRendezvous($idGroupe, $date, $commentaire, $lat, $lng) {
    $bdd = connexionDb();
    $sql = 'insert into rendezvous (dateRdv, commentaire, lat, lng, idGroupe) values (:date, :commentaire, :lat, :lng, :idGroupe)';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('date' => $date, 'commentaire' => $commentaire, 'lat'=>$lat, 'lng'=>$lng, 'idGroupe' => $idGroupe));
    return $bdd->lastInsertId();
}

function supprimerRendezVous($idRdv) {
    $bdd = connexionDb();
    $sql = 'DELETE FROM rendezvous WHERE idRdv = :idRdv';
    $requete = $bdd->prepare($sql);
    if ($requete->execute(array('idRdv' => $idRdv))) {
        return TRUE;
    }
    return FALSE;
}

function supprimerComposer($idUtilisateur, $idGroupe) {
    $bdd = connexionDb();
    $sql = 'DELETE FROM composer WHERE idUtilisateur= :idUtilisateur AND idGroupe = :idGroupe';
    $requete = $bdd->prepare($sql);
    if ($requete->execute(array('idUtilisateur' => $idUtilisateur, 'idGroupe' => $idGroupe))) {
        return TRUE;
    }
    return FALSE;
}

function supprimerGroupe($idGroupe) {
    $bdd = connexionDb();
    $sql = 'DELETE FROM groupes WHERE idGroupe = :idGroupe';
    $requete = $bdd->prepare($sql);
    if ($requete->execute(array('idGroupe' => $idGroupe))) {
        return TRUE;
    }
    return FALSE;
}

function supprimerpersonnesGroupe($idGroupe) {
    $bdd = connexionDb();
    $sql = 'DELETE FROM composer WHERE idGroupe = :idGroupe';
    $requete = $bdd->prepare($sql);
    if ($requete->execute(array('idGroupe' => $idGroupe))) {
        return TRUE;
    }
    return FALSE;
}

function lirePersonnesRdv($idGroupe) {
    $bdd = connexionDb();
    $sql = 'select u.idUtilisateur, u.nom, u.prenom, u.email from composer as c 
join utilisateurs as u on c.idUtilisateur = u.idUtilisateur
where c.idGroupe = :idGroupe';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idGroupe' => $idGroupe));
    return $requete->fetchAll();
}
