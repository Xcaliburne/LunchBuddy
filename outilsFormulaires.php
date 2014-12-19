<?php

/**
 * Construit une série de cases à cocher basée sur le tableau associatif $liste,
 * cochant l'ensemble de éléments cochés signalé comme tel dans le tableaus $checked
 * et ajoute les éventuels attributs
 * @param string $name nom des champs
 * @param array $liste liste des options
 * @param array $checked liste des options sélectionnées
 * @return array tableau d'élements html input/checkbox prêts à l'emploi
 */
function creerCheckboxes($name, $liste, $checked) {
    $cbs = array();
    foreach ($liste as $id => $texte) {
        $checkthis = (in_array($id, $checked)) ? 'checked="checked"' : '';
        $cb = '<label class="checkbox-inline">' .
                '<input type="checkbox" name="' . $name . '[]" value="' . $id .
                '" id="' . $name . $id . '" ' . $checkthis . ' />' . $texte .
                '</label>';
        $cbs[] = $cb;
    }
    return $cbs;
}

/**
 * 
 * @param type $name nom de du champs
 * @param type $liste liste des options
 * @param type $selected élement selectionné
 * @return string tableau de select
 */
function creerselect($name, $liste, $selected) {
    $selects = array();
    $selects[] = "<select id=\"statut\" name=\"statut\">";
    foreach ($liste as $id => $texte) {
        if ($id == $selected) {
            $checkthis = 'selected="selected"';
        } else {
            $checkthis = '';
        }
        $select = '<option ' . $checkthis . ' value="' . $id . '">' . $texte . '</option>';
        $selects[] = $select;
    }
    $selects[] = "</select>";
    return $selects;
}
