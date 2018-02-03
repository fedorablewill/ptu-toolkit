<?php
/**
 * Created by PhpStorm.
 * User: absor
 * Date: 10/22/2017
 * Time: 6:24 PM
 */

namespace Propel\PtuToolkit;

use PDO;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Propel;

class PtuApp
{
    public static $PersistentAfflictions = array("BURNED", "FROZEN", "PARALYSIS", "POISONED", "BADLY POISONED");
    public static $VolatileAfflictions = array("BAD SLEEP", "CONFUSED", "CURSED", "DISABLED", "RAGE", "FLINCH",
        "INFATUATION", "SLEEP", "SUPPRESSED", "TEMPORARY HIT POINTS");
    public static $OtherAfflictions = array("FAINTED", "BLINDNESS", "TOTAL BLINDNESS", "SLOWED", "STUCK", "TRAPPED",
        "TRIPPED", "VULNERABLE");

    public function __construct()
    {
        if (file_exists($file = __DIR__.'/../../../vendor/autoload.php')) {
            $loader = require $file;

            $loader->register();
        }

        Propel::init(__DIR__ . '/../../../config.php');
    }

    public function convertLegacyGMData($json_str) {
        $gm_data = json_decode($json_str, true);

        foreach ($gm_data['pokemon'] as $id=>$data) {
            $types = split(" / ", $data["type"]);

            $character = new Characters();
            $character->setName($data['name']);
            $character->setPokedexId($data['dex']);
            $character->setCampaignId(34);
            $character->setType(is_null($data['dex']) || $data['dex'] == "" ? "TRAINER" : "POKEMON");
            $character->setSex($data['gender']);
            $character->setType1($types[0]);
            if (sizeof($types) > 1) $character->setType2($types[1]);
            $character->setLevel($data['level']);
            $character->setExp($data['EXP']);

            if ($character->getType() == "POKEMON" && array_key_exists('dex', $data)) {
                $dex_entry = DataPokedexEntryQuery::create()->filterByPokedexId(1)->findByPokedexNo($data['dex'])[0];
                $dex_data = json_decode(stream_get_contents($dex_entry->getData(), -1, 0), true);

                if (!is_null($dex_data)) {
                    $character->setBaseHp($dex_data["BaseStats"]["HP"]);
                    $character->setBaseAtk($dex_data["BaseStats"]["Attack"]);
                    $character->setBaseDef($dex_data["BaseStats"]["Defense"]);
                    $character->setBaseSatk($dex_data["BaseStats"]["SpecialAttack"]);
                    $character->setBaseSdef($dex_data["BaseStats"]["SpecialDefense"]);
                    $character->setBaseSpd($dex_data["BaseStats"]["Speed"]);
                }
            }

            if (is_null($character->getBaseHp())) {
                $character->setBaseHp(10);
                $character->setBaseAtk(5);
                $character->setBaseDef(5);
                $character->setBaseSatk(5);
                $character->setBaseSdef(5);
                $character->setBaseSpd(5);
            }

            $character->setAddHp($data["hp"] - $character->getBaseHp());
            $character->setAddAtk($data["atk"] - $character->getBaseAtk());
            $character->setAddDef($data["def"] - $character->getBaseDef());
            $character->setAddSatk($data["spatk"] - $character->getBaseSatk());
            $character->setAddSdef($data["spdef"] - $character->getBaseSdef());
            $character->setAddSpd($data["speed"] - $character->getBaseSpd());

            $character->setNature($data["nature"]);
            if ($character->getType() == "POKEMON")
                $character->setNotes("Discovered at ".$data["discovery"]);

            foreach ($data['moves'] as $move) {
                if ($move != "")
                    $character->addCharacterMoves((new CharacterMoves())->setMoveName($move));
            }

            foreach ($data['abilities'] as $ability) {
                if ($ability != "")
                    $character->addCharacterAbilities((new CharacterAbilities())->setAbilityName($ability));
            }

            $character->save();
        }
    }

    /**
     * @param $campaignId
     * @return Campaigns
     */
    public function getCampaignById($campaignId) {
        return CampaignsQuery::create()->findOneByCampaignId($campaignId);
    }

    /**
     * @param $characterId
     * @return array
     */
    public function getCharacterById($characterId, $fetchBuffs = false) {
        $char = CharactersQuery::create()->findOneByCharacterId($characterId)->toArray();

        $char["Hp"] = $char["BaseHp"] + $char["LvlUpHp"] + $char["AddHp"];
        $char["Atk"] = $char["BaseAtk"] + $char["LvlUpAtk"] + $char["AddAtk"];
        $char["Def"] = $char["BaseDef"] + $char["LvlUpDef"] + $char["AddDef"];
        $char["Satk"] = $char["BaseSatk"] + $char["LvlUpSatk"] + $char["AddSatk"];
        $char["Sdef"] = $char["BaseSdef"] + $char["LvlUpSdef"] + $char["AddSdef"];
        $char["Spd"] = $char["BaseSpd"] + $char["LvlUpSpd"] + $char["AddSpd"];

        if ($fetchBuffs) {
            $char["Buffs"] = $this->getCharacterBuffs($characterId);
        }

        return $char;
    }

    public function getCharacterBuffs($characterId) {
        $sql = "SELECT cb.prereq, cb.type, cb.value, cb.target_stat FROM character_buffs cb
INNER JOIN battles b ON cb.battle_id = b.battle_id
WHERE b.is_active > 0 AND cb.character_id=:cId";

        $conn = Propel::getConnection();
        $st = $conn->prepare($sql);
        $st->bindParam('cId', $characterId);
        $st->execute();

        return $st->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCharacterMoves($characterId) {
        $charMoves = CharactersQuery::create()->findOneByCharacterId($characterId)->getCharacterMovessJoinMoves();
        $moves = array();

        foreach ($charMoves as $charMove) {
            $move = $charMove->getMoves();

            $moves[$move->getName()] = array(
                "Type" => $move->getType(),
                "Freq" => $move->getFreq(),
                "Class" => $move->getClass(),
                "Range" => $move->getRange(),
                "Effect" => $move->getEffect(),
                "Contest Type" => $move->getContestType(),
                "Contest Effect" => $move->getContestEffect(),
                "Triggers" => json_decode($move->getTriggers(), true)
            );
        }

        return $moves;
    }

    public function saveCharacterData($characterId, $data) {
        $character = CharactersQuery::create()->findOneByCharacterId($characterId);
        $character->fromArray($data, TableMap::TYPE_PHPNAME);
        return $character->save();
    }

    public function getCharacterList($campaignId) {
        $characters = CharactersQuery::create()
            ->filterByCampaignId($campaignId)
            ->filterByOwner(null)
            ->find();

        $output = array();

        foreach ($characters as $character) {
            $char = array(
                "id" => $character->getCharacterId(),
                "type" => $character->getType(),
                "dex" => $character->getPokedexNo(),
                "type1" => $character->getType1(),
                "type2" => $character->getType2(),
                "name" => $character->getName(),
                "owned" => array()
            );

            $ownedChars = CharactersQuery::create()
                ->findByOwner($character->getCharacterId());

            foreach ($ownedChars as $ownedChar) {
                array_push($char['owned'], array(
                    "id" => $ownedChar->getCharacterId(),
                    "type" => $ownedChar->getType(),
                    "dex" => $ownedChar->getPokedexNo(),
                    "type1" => $ownedChar->getType1(),
                    "type2" => $ownedChar->getType2(),
                    "name" => $ownedChar->getName()
                ));
            }

            array_push($output, $char);
        }

        return json_encode($output);
    }

    public function setCharacterCS($characterId, $stat, $value, $doInc = false) {
        $stat = strtoupper($stat);
        $isCs = !($stat == "ACC" || $stat == "EVD");

        return CharactersQuery::create()->findOneByCharacterId($characterId)->addOrUpdateBuff($stat, $value, $isCs, $doInc);
    }

    public function addAffliction($characterId, $affliction) {
        $character = CharactersQuery::create()->findOneByCharacterId($characterId);
        $character->addAffliction($affliction);
        return $character->save();
    }

    public function removeAffliction($characterId, $affliction) {
        $character = CharactersQuery::create()->findOneByCharacterId($characterId);
        $character->removeAffliction($affliction);
        return $character->save();
    }

    public function joinBattle($characterId) {
        // Check if already in battle
        $sql = "
SELECT b.battle_id AS \"BattleId\", 
  (SELECT be.battle_entry_id FROM battle_entries be 
  WHERE be.battle_id= b.battle_id AND be.character_id=:charId) AS \"EntryId\"
FROM battles b
WHERE b.is_active > 0 AND b.campaign_id=(SELECT campaign_id FROM characters WHERE character_id=:charId)
LIMIT 1";

        $conn = Propel::getConnection();
        $st = $conn->prepare($sql);
        $st->bindParam('charId', $characterId);
        $st->execute();

        $entry = $st->fetch(PDO::FETCH_ASSOC);

        // No active battle
        if (!$entry) {
            $battle = new Battles();
            $battleEntry = new BattleEntries();
            $campaignId = CharactersQuery::create()->select(array('campaign_id'))->findByCharacterId($characterId)->getData()[0];

            $battle->setCampaignId($campaignId);
            $battle->save();

            $battleEntry->setCharacterId($characterId);
            $battleEntry->setBattles($battle);
            $battleEntry->save();

            return true;
        }
        elseif (is_null($entry["EntryId"])) {
            $battleEntry = new BattleEntries();
            $battleEntry->setBattleId($entry["BattleId"]);
            $battleEntry->setCharacterId($characterId);
            $battleEntry->save();

            return true;
        }

        // Character is already in active battle
        return false;
    }

    public function getCharactersInActiveBattle($campaignId) {
        $characters = CharactersQuery::create()->joinBattleEntries()->join("BattleEntries.Battles")->where("Battles.IsActive")->find()->toArray();

        for ($i=0; $i < sizeof($characters); $i++) {
            $characters[$i]["Hp"] = $characters[$i]["BaseHp"] + $characters[$i]["LvlUpHp"] + $characters[$i]["AddHp"];
            $characters[$i]["Atk"] = $characters[$i]["BaseAtk"] + $characters[$i]["LvlUpAtk"] + $characters[$i]["AddAtk"];
            $characters[$i]["Def"] = $characters[$i]["BaseDef"] + $characters[$i]["LvlUpDef"] + $characters[$i]["AddDef"];
            $characters[$i]["Satk"] = $characters[$i]["BaseSatk"] + $characters[$i]["LvlUpSatk"] + $characters[$i]["AddSatk"];
            $characters[$i]["Sdef"] = $characters[$i]["BaseSdef"] + $characters[$i]["LvlUpSdef"] + $characters[$i]["AddSdef"];
            $characters[$i]["Spd"] = $characters[$i]["BaseSpd"] + $characters[$i]["LvlUpSpd"] + $characters[$i]["AddSpd"];
            
        }

        return $characters;
    }
}