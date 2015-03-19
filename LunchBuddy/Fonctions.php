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
 * @param type $aVerifier tableau associatif avec nom des valeurs à verifier pointant sur le nom à afficher
 * @return type true si il n'y a pas d'erreurs, s'il y a des errreurs, retourne le tableau d'erreurs.
 */
function ValiderSaisie($TabDonneeSaisies, $aVerifier) {
    $erreurs = array();
    foreach ($aVerifier as $key => $value) {
        if ((isset($TabDonneeSaisies[$key])) && (empty($TabDonneeSaisies[$key]))) {
            $erreurs[] = $value;
        }
    }
    return $erreurs;
}

function uploadImg($files, $ancienAvatar) {
    if (isset($files) && (is_array($files))) { //contrôle si un avatar a été sélectionné
        $uploaddir = realpath('.') . '/upload/';
        $pathAncienAvatar = './upload/' . $ancienAvatar;
        if ($files['avatar']['name'] != NULL) {
            $test = file_exists($pathAncienAvatar);
            if (is_file($pathAncienAvatar) == true) {
                unlink($pathAncienAvatar);
            }
            $ext = pathinfo($files['avatar']['name'], PATHINFO_EXTENSION); //récupère l'extension du fichier
            $filesize = filesize($files['avatar']['tmp_name']);
            $destination_filename = uniqid('_image_', true) . '.' . $ext;
            if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' || $ext == 'gif') {
                if ($filesize < 1024 * 1024 * 1024 * 0.2) {//taille du fichier plus petit de 2MB admis
                    $copie = move_uploaded_file($files['avatar']['tmp_name'], $uploaddir . $destination_filename);
                } else
                    $avatar = NULL;
            }
        } else
            $destination_filename = $ancienAvatar;
        $avatar = $destination_filename;
        return $destination_filename;
    }
}

function Notif() {   
    $rdvsEnAttente = lireRendezVousUtilisateur($_SESSION["idUtilisateur"], 'EnAttente');
    if (!empty($rdvsEnAttente)) {
        unset($rdvsEnAttente);
        $notif = NotifEnAttente();
        return $notif;
    }
    return '';
}

function NotifEnAttente() {
    return $Notif = ''
            . '<div class = "col-md-4  AlerteInfo alert alert-info alert-dismissable">'
            . '<button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">'
            . '&times;'
            . '</button>'
            . '<a href = "RendezVous.php?statut=EnAttente" class = "alert-link">Vous avez des demandes en attente</a>'
            . '</div>';
}
