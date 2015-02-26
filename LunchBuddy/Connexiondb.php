<?php
/*
 * Fichier : connexiondb.php
 * Description : contient les fonctions de connexion à la base de données
 * Auteur : Ludovic Gindre et Gregory Mendez
 */


/**
 * effectue la connexion à la base de données 
 * @return PDO objet de connexion à la base de données
 */
function connexionDb()
{
    $serveur = '127.0.0.1';
    $pseudo = 'root';
    $pwd = '';
    $db = 'lunchbuddy';
    
    static $bdd = null;
    
    if ($bdd === null)
    {
        $pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $bdd = new PDO("mysql:host=$serveur;dbname=$db", $pseudo, $pwd, $pdo_options);
        $bdd->exec('SET CHARACTER SET utf8');
    }
    return $bdd;
    
}