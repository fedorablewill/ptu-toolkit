describe("Battle", function () {
    it("should distribute damage", function (done) {
        waitFor("ActionImpl && typeEffects && typeEffects['electric']", function() {
            expect(ActionImpl.damageCharacter("1", "Normal", false, 20)).toBe(14);
            expect(ActionImpl.damageCharacter("1", "Flying", false, 20)).toBe(7);
            expect(ActionImpl.damageCharacter("1", "Ground", true, 20)).toBe(24);
            done();
        });
    });

    it("performs move scenario 1", function (done) {
        waitFor("ActionImpl && typeEffects && typeEffects['electric']", function() {
            ActionImpl.performMove("Struggle", 1, 2, {"dmg_bonus": 0, "acc_bonus": 0});

            expect(CurrentAction.acc).toBeGreaterThan(0);
            expect(CurrentAction.acc).toBeLessThanOrEqual(20);

            if (CurrentAction.acc > 5) { //TODO: determine what the ACC is regarding target's evade
                expect(CurrentAction.hit).toBeTruthy();

                if (CurrentAction.acc >= 20) {
                    expect(CurrentAction.is_crit).toBeTruthy();
                    expect(CurrentAction.dmg_rolled).toBeGreaterThanOrEqual(0); //TODO determine value
                    expect(CurrentAction.dmg_rolled).toBeLessThanOrEqual(50); //TODO determine value
                    expect(CurrentAction.dmg_dealt).toBeGreaterThanOrEqual(0); //TODO determine value
                    expect(CurrentAction.dmg_dealt).toBeLessThanOrEqual(50); //TODO determine value
                    expect(CurrentAction.dmg_final).toBeGreaterThanOrEqual(0); //TODO determine value
                    expect(CurrentAction.dmg_final).toBeLessThanOrEqual(50); //TODO determine value
                } else {
                    expect(CurrentAction.is_crit).toBeFalsy();
                    expect(CurrentAction.dmg_rolled).toBeGreaterThanOrEqual(0); //TODO determine value
                    expect(CurrentAction.dmg_rolled).toBeLessThanOrEqual(50); //TODO determine value
                    expect(CurrentAction.dmg_dealt).toBeGreaterThanOrEqual(0); //TODO determine value
                    expect(CurrentAction.dmg_dealt).toBeLessThanOrEqual(50); //TODO determine value
                    expect(CurrentAction.dmg_final).toBeGreaterThanOrEqual(0); //TODO determine value
                    expect(CurrentAction.dmg_final).toBeLessThanOrEqual(50); //TODO determine value
                }
            } else {
                expect(CurrentAction.hit).toBeFalsy();
            }

            done();
        });
    });
});

// CurrentAction Reference
var CurrentActionExample = {
    "dealer": {
        "CharacterId": 2,
        "CampaignId": 34,
        "Type": "POKEMON",
        "PokedexNo": "374",
        "PokedexId": 1,
        "Name": "Siri",
        "Owner": 13,
        "Age": null,
        "Weight": null,
        "Height": null,
        "Sex": "Genderless",
        "Type1": "Steel",
        "Type2": "Psychic",
        "Level": 9,
        "Exp": 87,
        "BaseHp": 4,
        "BaseAtk": 6,
        "BaseDef": 8,
        "BaseSatk": 4,
        "BaseSdef": 6,
        "BaseSpd": 3,
        "LvlUpHp": 1,
        "LvlUpAtk": 5,
        "LvlUpDef": 0,
        "LvlUpSatk": 3,
        "LvlUpSdef": 7,
        "LvlUpSpd": 1,
        "AddHp": 0,
        "AddAtk": 1,
        "AddDef": 0,
        "AddSatk": -1,
        "AddSdef": 0,
        "AddSpd": 0,
        "Health": 34,
        "Injuries": 0,
        "Money": 0,
        "SkillAcrobatics": 2,
        "SkillAthletics": 2,
        "SkillCharm": 2,
        "SkillCombat": 2,
        "SkillCommand": 2,
        "SkillGeneralEd": 2,
        "SkillMedicineEd": 2,
        "SkillOccultEd": 2,
        "SkillPokemonEd": 2,
        "SkillTechnologyEd": 2,
        "SkillFocus": 2,
        "SkillGuile": 2,
        "SkillIntimidate": 2,
        "SkillIntuition": 2,
        "SkillPerception": 2,
        "SkillStealth": 2,
        "SkillSurvival": 2,
        "ApSpent": 0,
        "ApBound": 0,
        "ApDrained": 0,
        "BackgroundName": null,
        "BackgroundAdept": null,
        "BackgroundNovice": null,
        "BackgroundPthc1": null,
        "BackgroundPthc2": null,
        "BackgroundPthc3": null,
        "Afflictions": null,
        "Notes": "Discovered at Starter",
        "Nature": "Adamant",
        "SheetType": null,
        "Hp": 5,
        "Atk": 12,
        "Def": 8,
        "Satk": 6,
        "Sdef": 13,
        "Spd": 4
    },
    "target": {
        "CharacterId": 1,
        "CampaignId": 34,
        "Type": "POKEMON",
        "PokedexNo": "179",
        "PokedexId": 1,
        "Name": "Phoebe",
        "Owner": 9,
        "Age": null,
        "Weight": null,
        "Height": null,
        "Sex": "Female",
        "Type1": "Electric",
        "Type2": null,
        "Level": 6,
        "Exp": 60,
        "BaseHp": 6,
        "BaseAtk": 4,
        "BaseDef": 4,
        "BaseSatk": 7,
        "BaseSdef": 5,
        "BaseSpd": 4,
        "LvlUpHp": 5,
        "LvlUpAtk": 2,
        "LvlUpDef": 2,
        "LvlUpSatk": 3,
        "LvlUpSdef": 2,
        "LvlUpSpd": 0,
        "AddHp": 0,
        "AddAtk": 0,
        "AddDef": 0,
        "AddSatk": 0,
        "AddSdef": 1,
        "AddSpd": -1,
        "Health": 36,
        "Injuries": 0,
        "Money": 0,
        "SkillAcrobatics": 2,
        "SkillAthletics": 2,
        "SkillCharm": 2,
        "SkillCombat": 2,
        "SkillCommand": 2,
        "SkillGeneralEd": 2,
        "SkillMedicineEd": 2,
        "SkillOccultEd": 2,
        "SkillPokemonEd": 2,
        "SkillTechnologyEd": 2,
        "SkillFocus": 2,
        "SkillGuile": 2,
        "SkillIntimidate": 2,
        "SkillIntuition": 2,
        "SkillPerception": 2,
        "SkillStealth": 2,
        "SkillSurvival": 2,
        "ApSpent": 0,
        "ApBound": 0,
        "ApDrained": 0,
        "BackgroundName": null,
        "BackgroundAdept": null,
        "BackgroundNovice": null,
        "BackgroundPthc1": null,
        "BackgroundPthc2": null,
        "BackgroundPthc3": null,
        "Afflictions": null,
        "Notes": "Discovered at Starter",
        "Nature": "Sassy",
        "SheetType": null,
        "Hp": 11,
        "Atk": 6,
        "Def": 6,
        "Satk": 10,
        "Sdef": 8,
        "Spd": 3
    },
    "move": {
        "Type": "Normal",
        "Freq": "At-Will",
        "AC": "4",
        "DB": "4",
        "Class": "Physical",
        "Range": "Melee, 1 Target",
        "Crits On": 20
    },
    "acc": 15,          // Rolled Accuracy Check
    "hit": true,        // If move hit
    "is_crit": false,   // If is a critical hit
    "dmg_rolled": 7,    // Rolled damage based on DB and INCLUDES CRITICAL HIT BONUS
    "dmg_dealt": 19,    // Damage heading towards target
    "dmg_final": 13     // Final total damage dealt
};