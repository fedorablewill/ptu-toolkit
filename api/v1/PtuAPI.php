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
    const JSON_FILE_EXTENSION = ".json";
    const ABILITIES_FILENAME = "abilities.json";
    const CAPABILITIES_FILENAME = "capabilities.json";
    const EDGES_FILENAME = "edges.json";
    const EXPERIENCE_FILENAME = "experience.json";
    const FEATURES_FILENAME = "features.json";
    const POKEMON_FILENAME = "ptu_pokedex_1_05.json";
    const MOVES_FILENAME = "moves.json";
    const NATURES_FILENAME = "natures.json";
    const TYPE_FILENAME = "type-effects.json";
    
    // Useful consts
    const NOT_GET_RESPONSE = "Why you telling me what to do? Just get fool";
    const DEFAULT_CHUNK_SIZE = 10;
    
    
    
    public function __construct($request, $origin)
    {
        parent::__construct($request);
        // No validation, open API
    }
    
    /*******************
     **** API Calls ****
     ******************/
    
    /** abilities
     * api/v1/abilities/
     * api/v1/abilities/name/
     * api/v1/abilities/name/?names=["Abominable","Bad Dreams"] (uri encoded)
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
    
    public function experience()
    {
        // Only handle gets
        if ($this->method != 'GET') {
            return self::NOT_GET_RESPONSE;
        }
        $experienceData = $this->getJsonFromFile(self::EXPERIENCE_FILENAME);
        return $this->getBasicNamedStructure($experienceData);
    }
    
    public function features() 
    {
        // Only handle gets
        if ($this->method != 'GET') {
            return self::NOT_GET_RESPONSE;
        }
        $featuresData = $this->getJsonFromFile(self::FEATURES_FILENAME);
        
        // Check for list
        if ($this->checkBasicRequest()) {
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
    
    /** Any Generic Json file getter
     * api/v1/getJson/filename
     */
    public function getJson()
    {
         // Only handle gets
        if ($this->method != 'GET') {
            return self::NOT_GET_RESPONSE;
        }
        return $this->getJsonFromFile($this->verb . self::JSON_FILE_EXTENSION);
    }
    
    /** moves
     * api/v1/moves/
     * api/v1/moves/name/
     * api/v1/moves/name/?names=["pound","horn drill"] (uri encoded)
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
        if ($this->checkBasicRequest()) {
            // Sort by dex id
            ksort($pokemonData);
            // Grab a chunk
            $offset = (!empty($_GET['offset'])) ? $_GET['offset'] : 0;
            $size = (!empty($_GET['size'])) ? $_GET['size'] : self::DEFAULT_CHUNK_SIZE;
            $data = array_slice($pokemonData, $offset, $size, true);
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
        if ($this->checkBasicRequest()) {
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

    /**
     * Generate random pokemon
     *
     * api/v1/generate/[parameters]
     *
     * Parameter    Default
     * type         random
     * habitat      random
     * generation   random
     * specific     random
     * legendary    true
     * min_level    0
     * max_level    100
     * nature       random
     * location     none
     * gender       random
     * stat_weights unweighted
     * //TODO: finish documentation...
     *
     * @return array|string JSON pokemon data
     */
    public function generate() {
        require_once "PtuGenerator.php";

        // Only handle gets
        if ($this->method != 'GET') {
            return self::NOT_GET_RESPONSE;
        }

        $generator = new PtuGenerator(
            array_key_exists("type", $_GET) ? $_GET['type'] : null,
            array_key_exists("habitat", $_GET) ? $_GET['habitat'] : null,
            array_key_exists("generation", $_GET) ? $_GET['generation'] : null,
            array_key_exists("specific", $_GET) ? $_GET['specific'] : null,
            array_key_exists("legendary", $_GET) ? $_GET['legendary'] : true,
            array_key_exists("min_level", $_GET) ? $_GET['min_level'] : 0,
            array_key_exists("max_level", $_GET) ? $_GET['max_level'] : 100,
            array_key_exists("nature", $_GET) ? $_GET['nature'] : "Random",
            array_key_exists("location", $_GET) ? $_GET['location'] : "",
            array_key_exists("gender", $_GET) ? $_GET['gender'] : "",
            array_key_exists("stat_weights", $_GET) ? json_decode($_GET['stat_weights'], true) :
                ["HP"=>1,"Attack"=>1,"Defense"=>1,"SpecialAttack"=>1,"SpecialDefense"=>1,"Speed"=>1],
            array_key_exists("min_tm", $_GET) ? $_GET['min_tm'] : 0,
            array_key_exists("max_tm", $_GET) ? $_GET['max_tm'] : 3,
            array_key_exists("min_em", $_GET) ? $_GET['min_em'] : 0,
            array_key_exists("max_em", $_GET) ? $_GET['max_em'] : 3,
            array_key_exists("top_percent", $_GET) ? $_GET['top_percent'] : false,
            array_key_exists("level_caught", $_GET) ? $_GET['level_caught'] : 0,
            array_key_exists("expand_horizons", $_GET) ? $_GET['expand_horizons'] : false,
            array_key_exists("guidance", $_GET) ? $_GET['guidance'] : false,
            array_key_exists("save_tp", $_GET) ? $_GET['save_tp'] : 0,
            array_key_exists("enduring_soul", $_GET) ? $_GET['enduring_soul'] : false,
            array_key_exists("stat_ace", $_GET) ? json_decode($_GET['stat_ace'], true) : [],
            array_key_exists("september", $_GET) ? $_GET['september'] : true
        );

        return $generator->start();
    }
    
    /*********************
     * Private Functions *
     ********************/
    
    /**
     * checks for an basic path
     *      ex. /api/v1/pokemon => true
     *          /api/v1/moves => true
     *          /api/v1/pokemon/bulbasaur/ => false
     *          /api/v1/moves/assurance => false
     *          /api/v1/types/water/fire => false
     *          /api/v1/types/ => true
     * @return bool
     */
    private function checkBasicRequest()
    {
        return (empty($this->verb) && empty($this->args));
    }
    
    /** namedEntityCall
     * api/v1/{Entity}/
     * api/v1/{Entity}/name/
     * api/v1/{Entity}/name/?names=["{Entityname1}","{Entity name 2}"] (uri encoded)
     */
    private function getBasicNamedStructure($data)
    {
        // Get a list
        if ($this->checkBasicRequest()) {
            // Check for ?names
            $names = (!empty($_GET['names'])) ? json_decode($_GET['names'], true)  : array();
            if (!empty($names))  {
                $returnData = array();
                foreach ($names as $name) {
                    $name = ucwords($name);
                    if (empty($returnData[$name])) {
                        $returnData[$name] = $data[$name];
                    }
                }
                return $returnData;
            }
            // No specification passed
            else {
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