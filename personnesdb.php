<?php
// Projet: LunchBuddy
// Fichier: personnesdb.php
// Description: Fonctions de gestion de la table personnes 
// Auteurs: Ludovic Gindre et Gregory Mendez


require_once './Connexiondb.php';

/**
 * retourne les données de l'enregistrement idPersonne
 * @param int $idPersonne ID de la personne dont on veut le détail
 * @return array|NULL 
 */
function lireUnePersonneDepuisId($idUtilisateur)
{
    $bdd = connexionDb();
    $sql = 'SELECT * FROM Utilisateurs WHERE idUtilisateur = :idUtilisateur';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('idUtilisateur'=>$idUtilisateur));
    return $requete->fetch();
}
/**
 * retourne les données de l'enregistrement Email
 * @param type $email Email de la personne dont on veut les informations
 * @return type
 */
function lireUnePersonneDepuisEmail($email)
{
    $bdd = connexionDb();
    $sql = 'SELECT idUtilisateur, nom, prenom FROM Utilisateurs WHERE email = :email';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('email'=>$email));
    return $requete->fetch();
}
/**
 * retourne les données d'une personne dont les informations de connexion sont validées
 * @param type $email Email de la personne se connectant
 * @param type $password Mot de passe de la personne se connectant
 * @return type
 */
function lirePersonneConnectee($email,$password)
{
    $bdd = connexionDb();
    $sql = 'SELECT idUtilisateur FROM utilisateurs WHERE password = :password and email = :email';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('email'=>$email, 'password' => $password));
    return $requete->fetch();
}

function inscrirePersonne($email,$password){
    $bdd = connexionDb();
    $sql = 'insert into utilisateurs (email, password) values (:email, :password)';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('email'=>$email, 'password' => $password));
    return $bdd->lastInsertId();
}

function estUniqueEmail($email){
    $bdd = connexionDb();
    $sql = 'select idUtilisateur from utilisateurs where email = :email';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('email'=>$email));
    return $requete->fetch();
}

function lireAdresseDepuisEmail($email)
{
    $bdd = connexionDb();
    $sql = 'SELECT nomRue, numeroRue, NPA FROM utilisateurs WHERE email = :email';
    $requete = $bdd->prepare($sql);
    $requete->execute(array('email'=>$email));
    return $requete->fetch(PDO::FETCH_ASSOC);
}

function lirePersonneDisponible($jour)
{
    $bdd = connexionDb();
    $sql = 'SELECT nom, prenom, email, NPA, nomRue, numeroRue, lat, long FROM utilisateurs AS u'
            .'NATURAL JOIN disponible AS d WHERE d.idJour = : jour';
    $requete = $bdd->prepare($sql);
    $requete-> execute(array('jour'=>$jour));
    return $requete->fetch(PDO::FETCH_ASSOC);
}