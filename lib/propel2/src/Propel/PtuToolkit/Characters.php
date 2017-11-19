<?php

namespace Propel\PtuToolkit;

use PDO;
use Propel\PtuToolkit\Base\Characters as BaseCharacters;
use Propel\Runtime\ActiveQuery\Criteria;
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
}
