<?php

namespace Propel\PtuToolkit;

use PDO;
use Propel\PtuToolkit\Base\Characters as BaseCharacters;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Exception\RuntimeException;
use Propel\Runtime\Propel;

/**
 * Skeleton subclass for representing a row from the 'characters' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 */
class Characters extends BaseCharacters
{
    public function getLearnableMovesJSON() {
        $sql = "
SELECT moves.name   AS \"Name\",
  moves.move_id     AS \"MoveId\",
  moves.type        AS \"Type\",
  pm.level_learned  AS \"LevelLearned\",
  pm.tm_id          AS \"TechnicalMachineId\",
  pm.is_natural     AS \"Natural\",
  pm.is_egg_move    AS \"EggMove\"
FROM moves
  LEFT OUTER JOIN (SELECT * FROM pokedex_moves WHERE pokedex_moves.pokedex_no = :p1 AND pokedex_moves.pokedex_id = :p2) pm
    ON pm.move_id = moves.move_id
ORDER BY CASE
      WHEN pm.level_learned IS NULL THEN moves.name
      WHEN pm.level_learned < 10 THEN CONCAT('0', pm.level_learned)
      ELSE pm.level_learned
    END ASC";

        $conn = Propel::getConnection();
        $st = $conn->prepare($sql);
        $st->bindParam('p1', $this->getPokedexNo());
        $st->bindParam('p2', $this->getPokedexId());
        $st->execute();

        $moves = $st->fetchAll(PDO::FETCH_ASSOC);

        return $moves;
    }

    public function addOrUpdateBuff($stat, $value, $isCS = true, $doInc = false) {
        $sql = "
SELECT be.battle_entry_id AS \"EntryId\", be.battle_id AS \"BattleId\" FROM battle_entries be
  LEFT OUTER JOIN battles b ON b.battle_id = be.battle_id
WHERE b.is_active > 0 AND be.character_id=:charId
LIMIT 1";

        $conn = Propel::getConnection();
        $st = $conn->prepare($sql);
        $st->bindParam('charId', $this->getCharacterId());
        $st->execute();

        $entry = $st->fetch(PDO::FETCH_ASSOC);

        if ($entry == false) {
            throw new RuntimeException("No active battle found for character");
        } else {
            $buff = CharacterBuffsQuery::create()
                ->filterByBattleId($entry["BattleId"])
                ->filterByCharacterId($this->getCharacterId())
                ->filterByTargetStat($stat)
                ->filterByType($isCS ? "CS" : "ADD")
                ->filterByPrereq(null)
                ->findOne();

            if (is_null($buff)) {
                $buff = new CharacterBuffs();
                $buff->setBattleId($entry["BattleId"]);
                $buff->setCharacterId($this->getCharacterId());
                $buff->setType($isCS ? "CS" : "ADD");
                $buff->setTargetStat($stat);
                $buff->setValue($value);
            }
            else {
                $buff->setValue($doInc ? $buff->getValue() + $value : $value);
            }

            if ($buff->getValue() > 6)
                $buff->setValue(6);
            else if ($buff->getValue() < -6)
                $buff->setValue(-6);

            try {
                $buff->save();
            } catch (PropelException $e) {
                throw new RuntimeException($e);
            }

            return $buff->getValue();
        }
    }

    public function addAffliction($affliction) {
        $afflictionList = empty($this->getAfflictions()) ? array() : json_decode($this->getAfflictions());
        if (!in_array($affliction, $afflictionList)){
            array_push($afflictionList, $affliction);
            $afflictionList = json_encode($afflictionList);
            $this->setAfflictions($afflictionList);
        }
    }

    public function removeAffliction($affliction) {
        $afflictionList = empty($this->getAfflictions()) ? array() : json_decode($this->getAfflictions());
        if (($key = array_search($affliction, $afflictionList)) !== false) {
            unset($afflictionList[$key]);
            $afflictionList = json_encode($afflictionList);
            $this->setAfflictions($afflictionList);
        }
    }
}
