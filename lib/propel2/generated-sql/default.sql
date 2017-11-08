
# This is a fix for InnoDB in MySQL >= 4.1.x
# It "suspends judgement" for fkey relationships until are tables are set.
SET FOREIGN_KEY_CHECKS = 0;

-- ---------------------------------------------------------------------
-- battle_entries
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `battle_entries`;

CREATE TABLE `battle_entries`
(
    `battle_entry_id` INTEGER NOT NULL AUTO_INCREMENT,
    `battle_id` INTEGER NOT NULL,
    `character_id` INTEGER NOT NULL,
    PRIMARY KEY (`battle_entry_id`),
    UNIQUE INDEX `battle_entries_battle_entry_id_uindex` (`battle_entry_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- battles
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `battles`;

CREATE TABLE `battles`
(
    `battle_id` INTEGER NOT NULL AUTO_INCREMENT,
    `campaign_id` INTEGER NOT NULL,
    `is_active` TINYINT(1),
    PRIMARY KEY (`battle_id`),
    UNIQUE INDEX `battles_id_uindex` (`battle_id`),
    INDEX `battles_campaigns_campaign_id_fk` (`campaign_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- campaigns
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `campaigns`;

CREATE TABLE `campaigns`
(
    `campaign_id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_firebase_id` VARCHAR(32) NOT NULL,
    `campaign_name` VARCHAR(25) NOT NULL,
    `campaign_data` LONGBLOB,
    PRIMARY KEY (`campaign_id`,`user_firebase_id`),
    UNIQUE INDEX `Campaign_id` (`campaign_id`),
    INDEX `fi_rs_Campaigns_FK1` (`user_firebase_id`),
    CONSTRAINT `Users_Campaigns_FK1`
        FOREIGN KEY (`user_firebase_id`)
        REFERENCES `users` (`firebase_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- character_abilities
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `character_abilities`;

CREATE TABLE `character_abilities`
(
    `character_ability_id` INTEGER NOT NULL AUTO_INCREMENT,
    `character_id` INTEGER NOT NULL,
    `ability_id` INTEGER,
    `ability_name` VARCHAR(64),
    PRIMARY KEY (`character_ability_id`),
    UNIQUE INDEX `character_abilities_character_ability_id_uindex` (`character_ability_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- character_buffs
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `character_buffs`;

CREATE TABLE `character_buffs`
(
    `character_buff_id` INTEGER NOT NULL AUTO_INCREMENT,
    `character_id` INTEGER NOT NULL,
    `battle_id` INTEGER,
    `value` INTEGER DEFAULT 0 NOT NULL,
    `type` enum('CS','ADD') DEFAULT 'ADD',
    `prereq` VARCHAR(128),
    `target_stat` VARCHAR(8) NOT NULL,
    PRIMARY KEY (`character_buff_id`),
    UNIQUE INDEX `character_buffs_id_uindex` (`character_buff_id`),
    INDEX `character_buffs_characters_character_id_fk` (`character_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- character_moves
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `character_moves`;

CREATE TABLE `character_moves`
(
    `character_move_id` INTEGER NOT NULL AUTO_INCREMENT,
    `character_id` INTEGER NOT NULL,
    `move_id` INTEGER,
    `move_name` VARCHAR(64),
    PRIMARY KEY (`character_move_id`),
    UNIQUE INDEX `character_moves_character_move_id_uindex` (`character_move_id`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- characters
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `characters`;

CREATE TABLE `characters`
(
    `character_id` INTEGER NOT NULL AUTO_INCREMENT,
    `campaign_id` INTEGER NOT NULL,
    `type` enum('TRAINER','POKEMON') NOT NULL,
    `pokedex_id` VARCHAR(8),
    `name` VARCHAR(80) NOT NULL,
    `owner` INTEGER,
    `age` VARCHAR(12),
    `weight` VARCHAR(12),
    `height` VARCHAR(12),
    `sex` VARCHAR(12),
    `base_type1` VARCHAR(16),
    `base_type2` VARCHAR(16),
    `level` INTEGER,
    `exp` INTEGER,
    `base_hp` INTEGER NOT NULL,
    `base_atk` INTEGER NOT NULL,
    `base_def` INTEGER NOT NULL,
    `base_satk` INTEGER NOT NULL,
    `base_sdef` INTEGER NOT NULL,
    `base_spd` INTEGER NOT NULL,
    `add_hp` INTEGER DEFAULT 0,
    `add_atk` INTEGER DEFAULT 0,
    `add_def` INTEGER DEFAULT 0,
    `add_satk` INTEGER DEFAULT 0,
    `add_sdef` INTEGER DEFAULT 0,
    `add_spd` INTEGER DEFAULT 0,
    `health` INTEGER,
    `injuries` INTEGER DEFAULT 0,
    `money` INTEGER DEFAULT 0,
    `skill_acrobatics` INTEGER DEFAULT 2,
    `skill_athletics` INTEGER DEFAULT 2,
    `skill_charm` INTEGER DEFAULT 2,
    `skill_combat` INTEGER DEFAULT 2,
    `skill_command` INTEGER DEFAULT 2,
    `skill_general_ed` INTEGER DEFAULT 2,
    `skill_medicine_ed` INTEGER DEFAULT 2,
    `skill_occult_ed` INTEGER DEFAULT 2,
    `skill_pokemon_ed` INTEGER DEFAULT 2,
    `skill_technology_ed` INTEGER DEFAULT 2,
    `skill_focus` INTEGER DEFAULT 2,
    `skill_guile` INTEGER DEFAULT 2,
    `skill_intimidate` INTEGER DEFAULT 2,
    `skill_intuition` INTEGER DEFAULT 2,
    `skill_perception` INTEGER DEFAULT 2,
    `skill_stealth` INTEGER DEFAULT 2,
    `skill_survival` INTEGER DEFAULT 2,
    `ap_spent` INTEGER DEFAULT 0,
    `ap_bound` INTEGER DEFAULT 0,
    `ap_drained` INTEGER DEFAULT 0,
    `background_name` VARCHAR(80),
    `background_adept` VARCHAR(80),
    `background_novice` VARCHAR(80),
    `background_pthc1` VARCHAR(80),
    `background_pthc2` VARCHAR(80),
    `background_pthc3` VARCHAR(80),
    `notes` TEXT,
    `nature` VARCHAR(16),
    PRIMARY KEY (`character_id`),
    INDEX `characters_characters_character_id_fk` (`owner`)
) ENGINE=MyISAM;

-- ---------------------------------------------------------------------
-- sessions
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions`
(
    `session_id` INTEGER NOT NULL AUTO_INCREMENT,
    `user_firebase_id` VARCHAR(16) NOT NULL,
    `firebase_token` TEXT NOT NULL,
    `ip_address` VARCHAR(16) NOT NULL,
    `agent` VARCHAR(64) NOT NULL,
    `timestamp` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`session_id`),
    INDEX `Users_Sessions_FK1` (`user_firebase_id`),
    CONSTRAINT `Users_Sessions_FK1`
        FOREIGN KEY (`user_firebase_id`)
        REFERENCES `users` (`firebase_id`)
) ENGINE=InnoDB;

-- ---------------------------------------------------------------------
-- users
-- ---------------------------------------------------------------------

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users`
(
    `firebase_id` VARCHAR(32) NOT NULL,
    `username` VARCHAR(20) NOT NULL,
    `peer_id` VARCHAR(32) NOT NULL,
    `settings` LONGBLOB,
    PRIMARY KEY (`firebase_id`),
    UNIQUE INDEX `Users_AK1` (`username`)
) ENGINE=InnoDB;

# This restores the fkey checks, after having unset them earlier
SET FOREIGN_KEY_CHECKS = 1;
