<?php
/**
 * Call for getting Pokedex entries
 */

if (array_key_exists("dex", $_GET)) {
    // TODO: return single entry
}
else {
    echo file_get_contents("../../data/ptu_pokedex_1_05.json");
}