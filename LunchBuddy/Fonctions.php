<?php

/**
 * 
 * @param type $TabDonneeSaisies tableau de données à verifier (peut être $_POST ou $_GET)
 * @param type $aVerifier nom des valeurs à verifier
 * @return type true si il n'y a pas d'erreurs, s'il y a des errreurs, retourne le tableau d'erreurs.
 */
function ComparerHeures($h1, $h2) {
    $parsed = date_parse($h1);
    $secondsDebut = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second']; //transformation de l'heure en secondes
    $parsed = date_parse($h2);
    $secondsfin = $parsed['hour'] * 3600 + $parsed['minute'] * 60 + $parsed['second']; //transformation de l'heure en secondes
    if ($secondsDebut < $secondsfin) {
        return true;
    }
    return false;
}

/**
 * 
 * @param type $TabDonneeSaisies tableau de données à verifier (peut être $_POST ou $_GET)
 * @param type $aVerifier nom des valeurs à verifier
 * @return type true si il n'y a pas d'erreurs, s'il y a des errreurs, retourne le tableau d'erreurs.
 */
function ValiderSaisie($TabDonneeSaisies, $aVerifier) {
    $erreurs = array();
    foreach ($aVerifier as $valeur) {
        if ((isset($TabDonneeSaisies[$valeur])) && (empty($TabDonneeSaisies[$valeur]))) {
            $erreurs[] = $valeur;
        }
    }
    return $erreurs;
}

function uploadImg($files) {
    if (is_array($files)) { //contrôle si un avatar a été sélectionné
        $uploaddir = realpath('.') . '/upload/';
        $ancienAvatar = $parametres[0]["avatar"];
        $pathAncienAvatar = './upload/' . $ancienAvatar;
        if ($files['avatar']['name'] != NULL) {
            unlink($pathAncienAvatar);
            $ext = pathinfo($files['avatar']['name'], PATHINFO_EXTENSION); //récupère l'extension du fichier
            $filesize = filesize($files['avatar']['tmp_name']);
            $destination_filename = uniqid('_image_', true) . '.' . $ext;
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'gif') {
                if ($filesize < 1024 * 1024 * 1024 * 0.2) {//taille du fichier plus petit de 2MB admis
                    $copie = move_uploaded_file($files['avatar']['tmp_name'], $uploaddir . $destination_filename);
                } else
                    $avatar = NULL;
                echo $filesize;
            }
        } else
            $destination_filename = $ancienAvatar;
        $avatar = $destination_filename;
    }
}
