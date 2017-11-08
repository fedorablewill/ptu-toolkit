<?php
/**
 * Created by PhpStorm.
 * User: absor
 * Date: 9/10/2017
 * Time: 7:07 PM
 */
eval(file_get_contents("../../../../sql/ptu/db.php"));

class PtuCharacter
{
    public $character_id, $type, $name, $owner, $age, $weight, $height, $sex,
        $level, $exp, $health,
        $base_hp, $base_atk, $base_def, $base_satk, $base_sdef, $base_spd,
        $skill_acrobatics, $skill_athletics, $skill_charm, $skill_combat, $skill_command,
        $skill_general_ed, $skill_medicine_ed, $skill_pokemon_ed, $skill_technology_ed,
        $skill_focus, $skill_guile, $skill_intimidate, $skill_intuition,
        $skill_perception, $skill_stealth, $skill_survival,
        $ap_spent, $ap_bound, $ap_drained,
        $injuries, $money;

    public static function getAllUnowned($campaign_id) {
        $stmt = $db->prepare(
            "SELECT character_id, type, name, owner, age, weight, height, sex,
                level, exp, health,
                base_hp, base_atk, base_def, base_satk, base_sdef, base_spd,
                skill_acrobatics, skill_athletics, skill_charm, skill_combat, skill_command,
                skill_general_ed, skill_medicine_ed, skill_pokemon_ed, skill_technology_ed,
                skill_focus, skill_guile, skill_intimidate, skill_intuition,
                skill_perception, skill_stealth, skill_survival,
                ap_spent, ap_bound, ap_drained,
                injuries, money FROM characters 
              WHERE campaign_id=:cid AND owner IS NULL"
        );

        $stmt->execute(array("cid" => $campaign_id));

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'PtuCharacter');
    }

    public function getOwned() {
        $stmt = $db->prepare(
            "SELECT character_id, type, name, owner, age, weight, height, sex,
                level, exp, health,
                base_hp, base_atk, base_def, base_satk, base_sdef, base_spd,
                skill_acrobatics, skill_athletics, skill_charm, skill_combat, skill_command,
                skill_general_ed, skill_medicine_ed, skill_pokemon_ed, skill_technology_ed,
                skill_focus, skill_guile, skill_intimidate, skill_intuition,
                skill_perception, skill_stealth, skill_survival,
                ap_spent, ap_bound, ap_drained,
                injuries, money FROM characters 
              WHERE owner=:owner"
        );

        $stmt->execute(array("cid" => $_SERVER['PHP_AUTH_USER'], "owner" => $this->character_id));

        return $stmt->fetchAll(PDO::FETCH_CLASS, 'PtuCharacter');
    }
}