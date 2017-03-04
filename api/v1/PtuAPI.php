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
    // Json path data
    const JSON_DATA_PATH = "../../data/";
    const ABILITIES_FILENAME = "abilities.json";
    const CAPABILITIES_FILENAME = "capabilities.json";
    const EDGES_FILENAME = "edges.json";
    const FEATURES_FILENAME = "features.json";
    const POKEMON_FILENAME = "ptu_pokedex_1_05.json";
    const MOVES_FILENAME = "moves.json";
    const NATURES_FILENAME = "natures.json";
    const TYPE_FILENAME = "type-effects.json";
    
    // Useful consts
    const NOT_GET_RESPONSE = "Why you telling me what to do? Just get fool";
    
    
    
    public function __construct($request, $origin)
    {
        parent::__construct($request);
        // TODO: validation, api key, user validation?
    }
    
    /*******************
     **** API Calls ****
     ******************/
    
    /** abilities
     * api/v1/abilities/
     * api/v1/abilities/name/
     * api/v1/abilities/name/?names=["Abominable","Bad Dreams"] (uri encoded)
     * api/v1/abilities/?offset=20&size=3
     */
    public function abilities()
    {
       // Only handle gets
        if ($this->method != 'GET') {
            return self::NOT_GET_RESPONSE;
        }
        $abilitiesData = $this->getJsonFromFile(self::ABILITIES_FILENAME);
        return $this->getBasicNamedStructure($abilitiesData);
    }
    
    /** capabilities
     * api/v1/capabilities/
     * api/v1/capabilities/name/
     * api/v1/capabilities/name/?names=["Abominable","Bad Dreams"] (uri encoded)
     * api/v1/capabilities/?offset=20&size=3
     */
    public function capabilities()
    {
        // Only handle gets
        if ($this->method != 'GET') {
            return self::NOT_GET_RESPONSE;
        }
        $capabilitiesData = $this->getJsonFromFile(self::CAPABILITIES_FILENAME);
        return $this->getBasicNamedStructure($capabilitiesData);
    }
    
    /** edges
     * api/v1/edges/
     * api/v1/edges/name/
     * api/v1/edges/name/?names=["Abominable","Bad Dreams"] (uri encoded)
     * api/v1/edges/?offset=20&size=3
     */
    public function edges()
    {
        // Only handle gets
        if ($this->method != 'GET') {
            return self::NOT_GET_RESPONSE;
        }
        $edgesData = $this->getJsonFromFile(self::EDGES_FILENAME);
        return $this->getBasicNamedStructure($edgesData);
    }
    
    public function features() 
    {
        // Only handle gets
        if ($this->method != 'GET') {
            return self::NOT_GET_RESPONSE;
        }
        $featuresData = $this->getJsonFromFile(self::FEATURES_FILENAME);
        
        // Check for list
        if ($this->checkEmptyRequest()) {
            // Check for ?names
            $names = (!empty($_GET['names'])) ? json_decode($_GET['names'], true)  : array();
            if (!empty($names))  {
                $returnData = array();
                foreach ($names as $name) {
                    $name = ucwords($name);
                    if (!empty($returnData[$name])) {
                        $returnData[$name] = $data[$name];
                    }
                }
                return $returnData;
            }
            // No specification passed
            else {
                // TODO: Check ?offset & ?size
                return $featuresData;
            }
        }
        // Find category by num
        if (array_key_exists(0,$this->args) && is_numeric($this->args[0])) {
            $id = $this->args[0];
            return $featuresData[$id];
        }
        
        //Find by name
        $featureName = ucwords($this->verb);
        if (!empty($featureName)) {
            foreach ($featuresData as $featureCategory) {
                if (!empty($featureCategory[$featureName])) {
                    return $featureCategory[$featureName];
                }
            }
        }
    }
    
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
            return self::NOT_GET_RESPONSE;
        }
        $movesData = $this->getJsonFromFile(self::MOVES_FILENAME);
        return $this->getBasicNamedStructure($movesData);
    }
    
    /** natures
     * api/v1/natures/
     * api/v1/natures/name/
     * api/v1/natures/name/?names=["pound","horn drill"] (uri encoded)
     * api/v1/natures/?offset=20&size=3
     */
    public function natures()
    {
        // Only handle gets
        if ($this->method != 'GET') {
            return self::NOT_GET_RESPONSE;
        }
        $naturesData = $this->getJsonFromFile(self::NATURES_FILENAME);
        return $this->getBasicNamedStructure($naturesData);
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
            return self::NOT_GET_RESPONSE;
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
            return self::NOT_GET_RESPONSE;
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
    
    // TODO refactor 'empty' to something more like 'basic'
    private function checkEmptyRequest()
    {
        return (empty($this->verb) && empty($this->args));
    }
    
    /** namedEntityCall
     * api/v1/{Entity}/
     * api/v1/{Entity}/name/
     * api/v1/{Entity}/name/?names=["{Entityname1}","{Entity name 2}"] (uri encoded)
     * api/v1/{Entity}/?offset=20&size=3
     */
    private function getBasicNamedStructure($data)
    {
        // Get a list
        if ($this->checkEmptyRequest()) {
            // Check for ?names
            $names = (!empty($_GET['names'])) ? json_decode($_GET['names'], true)  : array();
            if (!empty($names))  {
                $returnData = array();
                foreach ($names as $name) {
                    $name = ucwords($name);
                    if (!empty($returnData[$name])) {
                        $returnData[$name] = $data[$name];
                    }
                }
                return $returnData;
            }
            // No specification passed
            else {
                // TODO: Check ?offset & ?size
                return $data;
            }
        }
        // Get Item by name
        $itemName = ucwords($this->verb);
        if (!empty($itemName) && array_key_exists($itemName, $data)) {
            return $data[$itemName];
        }
        return "Not Found";
    }
    
    private function getJsonFromFile($filename)
    {
        $file = file_get_contents(self::JSON_DATA_PATH . $filename)
                or die("Could not open file: $filename");
        return json_decode($file, true);
    }
}