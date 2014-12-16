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
        $cb = '<label class="checkbox-inline">'.
                '<input type="checkbox" name="' . $name . '[]" value="' . $id .
                '" id="' . $name . $id . '" ' . $checkthis . ' />' . $texte .
                '</label>';
        $cbs[] = $cb;
    }
    return $cbs;
}
