<?php

// Projet: LunchBuddy
// Fichier: personnesdb.php
// Description: Fonctions de gestion de la table personnes 
// Auteurs: Ludovic Gindre et Gregory Mendez

require './Connexiondb.php';

/**
 * retourne les données de l'enregistrement idPersonne
 * @param int $idPersonne ID de la personne dont on veut le détail
 * @return array|NULL 
 */
function lireUnePersonneDepuisId($idUtilisateur) {
    $bdd = connexionDb();
    $sql = 'SELECT * FROM Utilisateurs WHERE idUtilisateur = :idUtilisateur';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idUtilisateur' => $idUtilisateur));
    return $requete->fetch();
}

/**
 * retourne les données de l'enregistrement Email
 * @param type $email Email de la personne dont on veut les informations
 * @return type
 */
function lireUnePersonneDepuisEmail($email) {
    $bdd = connexionDb();
    $sql = 'SELECT idUtilisateur, nom, prenom FROM Utilisateurs WHERE email = :email';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('email' => $email));
    return $requete->fetch();
}

/**
 * retourne les données d'une personne dont les informations de connexion sont validées
 * @param type $email Email de la personne se connectant
 * @param type $password Mot de passe de la personne se connectant
 * @return type
 */
function lirePersonneConnectee($email, $password) {
    $bdd = connexionDb();
    $sql = 'SELECT idUtilisateur, rayon FROM utilisateurs WHERE password = :password and email = :email';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('email' => $email, 'password' => $password));
    return $requete->fetch();
}

function inscrirePersonne($email, $password, $nom, $prenom) {
    $bdd = connexionDb();
    $sql = 'insert into utilisateurs (email, password, nom, prenom) values (:email, :password, :nom, :prenom)';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('email' => $email, 'password' => $password, 'nom' => $nom, 'prenom' => $prenom));
    return $bdd->lastInsertId();
}

function lireParametresUtilisateur($idUtilisateur) {
    $bdd = connexionDb();
    $sql = 'SELECT nom, prenom, email, nomRue, numeroRue, NPA, rayon, debutPause, finPause, avatar FROM utilisateurs WHERE idUtilisateur = :idUtilisateur';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idUtilisateur' => $idUtilisateur));
    return $requete->fetchAll();
}

function ModiferParametres($idUtilisateur, $nom, $prenom, $email, $adresse, $numeroRue, $NPA, $rayon, $debutDispo, $finDispo, $avatar) {
    $bdd = connexionDb();
    $sql = 'update utilisateurs set nom = :nom, prenom = :prenom, email = :email, nomRue = :adresse, numeroRue = :numeroRue, NPA = :NPA, rayon = :rayon, debutPause = :debutDispo, finPause = :finDispo';
    $paramArray = array('idUtilisateur' => $idUtilisateur, 'nom' => $nom, 'prenom'=>$prenom,'email'=>$email, 'adresse' => $adresse, 'numeroRue' => $numeroRue, 'NPA' => $NPA, 'rayon' => $rayon, 'debutDispo' => $debutDispo, 'finDispo' => $finDispo);
    //$avatarParamArray;
    if($avatar != NULL){
        $sql .= ", avatar = :avatar";
        $avatarParamArray = array( 'avatar'=> $avatar);
        $paramArray = array_merge($paramArray, $avatarParamArray);
    }else{
        $sql .= ", avatar = NULL";
    }
    $sql .= ' where idUtilisateur = :idUtilisateur;';
    $requete = $bdd->prepare($sql);
    if ($requete->execute($paramArray)) {
        return true;
    }
    return false;
}

function estUniqueEmail($email) {
    $bdd = connexionDb();
    $sql = 'select idUtilisateur from utilisateurs where email = :email';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('email' => $email));
    return $requete->fetch();
}

function supprimerJoursDisponibiliteUtilisateur($idUtilisateur) {
    $bdd = connexionDb();
    $sql = 'DELETE FROM disponible WHERE idUtilisateur = :idUtilisateur;';
    $requete = $bdd->prepare($sql);
    if ($requete->execute(array('idUtilisateur' => $idUtilisateur))) {
        return true;
    }
    return FALSE;
}

function ajouterDisponibilite($idUtilisateur, $jour) {
    $bdd = connexionDb();
    $sql = 'INSERT INTO `disponible`(`idUtilisateur`, `idJour`) VALUES (:idUtilisateur,:idJour);';
    $requete = $bdd->prepare($sql);
    if ($requete->execute(array('idUtilisateur' => $idUtilisateur, 'idJour' => $jour))) {
        return TRUE;
    } else {
        return FALSE;
    }
}

function lireDisponibilites($idUtilisateur){
    $bdd = connexionDb();
    $sql = 'SELECT idJour FROM disponible WHERE idUtilisateur = :idUtilisateur';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idUtilisateur' => $idUtilisateur));
    return $requete->fetchAll();
}

    

function lireCoordoneesPersonne($id)
{
    $bdd = connexionDb();
    $sql = 'SELECT lat, long, rayon FROM utilisateurs WHERE idUtilisateur = :id';
    $requete = $bdd->prepare($sql);
    $requete-> execute(array('id'=>$id));
    return $requete->fetch(PDO::FETCH_ASSOC);    
    
}

function lirePersonneDisponible($jour)
{
    $bdd = connexionDb();
    $sql = 'SELECT idUtilisateur, nom, prenom, email, NPA, nomRue, numeroRue, lat, lng, debutPause, finPause, avatar FROM utilisateurs AS u '
            .'NATURAL JOIN disponible AS d WHERE d.idJour = :jour';
    $requete = $bdd->prepare($sql);
    $requete-> execute(array('jour'=>$jour));
    return $requete->fetchAll(PDO::FETCH_ASSOC); 
}
