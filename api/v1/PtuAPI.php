<?php
require_once 'api.class.php';

/**
 * PTU Toolkit Public Api
 *   Api tool at _siteroot_/api.html
 *   To access go to _siteroot_/api/v1/
 *   Append public function from this class and any identifing data
 *   _siteroot_/api/v1/pokemon/bulbasaur
 * 
 * To add a new api call just create a new public function
 */
class PtuAPI extends API
{
    const JSON_DATA_PATH = "../../data/";
    const POKEMON_FILENAME = "ptu_pokedex_1_05.json";
    const TYPE_FILENAME = "type-effects.json";
    const MOVES_FILENAME = "moves.json";
    
    public function __construct($request, $origin)
    {
        parent::__construct($request);
        // TODO: validation, api key, user validation?
    }
    
    /*******************
     **** API Calls ****
     ******************/
    
    /** moves
     * api/v1/moves/
     * api/v1/moves/name/
     * api/v1/moves/name/?names=["pound","horn drill"] (uri encoded)
     * api/v1/moves/?offset=20&size=3
     */
    public function moves()
    {
        // Only handle gets
        if ($this->method != 'GET') {
            return "Why you telling me what to do? Just get fool";
        }
        
        $movesData = $this->getJsonFromFile(self::MOVES_FILENAME);
        
        // Get List of Moves
        if ($this->checkEmptyRequest()) {
            // Check for ?names
            $names = (!empty($_GET['names'])) ? json_decode($_GET['names'], true)  : array();
            if (!empty($names))  {
                $movesArr = array();
                foreach ($names as $name) {
                    if (!empty($movesData[$name])) {
                        $movesArr[$name] = $movesData[$name];
                    }
                }
                return $movesArr;
            }
            // No specification passed
            else {
                return "TODO: get 20 with offset";
            }
        }

        // Get Move by name
        $moveName = ucwords($this->verb);
        if (!empty($moveName) && array_key_exists($moveName, $movesData)) {
            return $movesData[$moveName];
        }
        return "Not Found";
    }
    
    /** pokemon
     * api/v1/pokemon/
     * api/v1/pokemon/id
     * api/v1/pokemon/name/
     * api/v1/pokemon/?offset=20&size=3
     */
    public function pokemon()
    {
        // Only handle gets
        if ($this->method != 'GET') {
            return "Why you telling me what to do? Just get fool";
        }
        
        // Get Pokemon Data
        $pokemonData = $this->getJsonFromFile(self::POKEMON_FILENAME);
        
        // Get List of Pokemon
        if ($this->checkEmptyRequest()) {
            // TODO was late and seeing bugs, i must just be tired, debug this
            $offset = (!empty($_GET['offset'])) ? $_GET['offset'] : 0;
            $size = (!empty($_GET['size'])) ? $_GET['size'] : 10;
            $data = array_slice($pokemonData, $offset, $size);
            return $data;
        }
        
        // Get Pokemon by Dex id (/1,/53,/421)
        if (array_key_exists(0,$this->args) && is_numeric($this->args[0])) {
            $dexId = str_pad($this->args[0], 3, "0", STR_PAD_LEFT);
            if (array_key_exists($dexId, $pokemonData)) {
                return $pokemonData[$dexId];
            }
            return "Not Found";
        }
        
        // Get Pokemon by name
        if (!empty($this->verb)) {
            $pokemonName = strtolower($this->verb);
            foreach ($pokemonData as $id => $pokemon) {
                if (strtolower($pokemon["Species"]) == $pokemonName) {
                    return $pokemonData[$id];
                }
            }
            return "Not Found";
        }
    }
    
    /** types
     * api/v1/types/
     * api/v1/types/attackType
     * api/v1/types/attackType/defendType
     */
    public function types()
    {
        // Only handle gets
        if ($this->method != 'GET') {
            return "Why you telling me what to do? Just get fool";
        }
        
        $typesData = $this->getJsonFromFile(self::TYPE_FILENAME);
        
        // Get All
        if ($this->checkEmptyRequest()) {
            return $typesData;
        }
        // Get Type
        $type = strtolower($this->verb);
        if (!empty($type) && array_key_exists($type, $typesData)) {
            if (!empty($this->args[0]) && array_key_exists($this->args[0], $typesData[$type])) {
                return $typesData[$type][$this->args[0]];
            }
            return $typesData[$type];
        }
        // Get Specific type effectiveness
        
        return "Not Found";
        
    }
    
    /*********************
     * Private Functions *
     ********************/
    private function checkEmptyRequest()
    {
        return (empty($this->verb) && empty($this->args));
    }
    private function getJsonFromFile($filename)
    {
        $file = file_get_contents(self::JSON_DATA_PATH . $filename)
                or die("Could not open file: $filename");
        return json_decode($file, true);
    }
}