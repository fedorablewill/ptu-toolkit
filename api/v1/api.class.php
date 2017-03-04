<?php

abstract class API
{
    protected $method = '';
    protected $endpoint = '';
    protected $verb = '';
    protected $args = array();
    protected $file = null;
    
    public function __construct($request)
    {
        // Allow for CORS
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: *');
        header('Content-Type: application/json');
        
        // Grab args, endpoint and verb
        $this->args = explode('/', rtrim($request, '/'));
        $this->endpoint = array_shift($this->args);
        if (array_key_exists(0, $this->args) && !is_numeric($this->args[0])) {
            $this->verb = array_shift($this->args);
        }
        
        // Grab methods post->put
        $this->method = $_SERVER['REQUEST_METHOD'];
        if ($this->method == 'POST' && array_key_exists('HTTP_X_HTTP_METHOD', $_SERVER)) {
            if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'DELETE') {
                $this->method = 'DELETE';
            }
            else if ($_SERVER['HTTP_X_HTTP_METHOD'] == 'PUT') {
                $this->method = 'PUT';
            }
            else {
                throw new Excpetion("Unexpected Header");
            }
        }
        
        switch($this->method) {
            case 'DELETE':
            case 'POST':
                $this->request = $this->_cleanInputs($_POST);
                break;
            case 'GET':
                $this->request = $this->_cleanInputs($_GET);
                break;
            case 'PUT':
                $this->request = $this->_cleanInputs($_GET);
                $this->file = file_get_contents("php://input");
                break;
            default:
                $this->_response('Invalid Method', 405);
                break;
        }
    }
    
    /********************
     * Public Functions *
     *******************/
    public function processAPI()
    {
        // TODO: count api requests?
        if (method_exists($this, $this->endpoint)) {
            return $this->_response($this->{$this->endpoint}($this->args));
        }
        return $this->_response("No End Point: $this->endpoint", 404);
    }
    
    /*********************
     * Private Functions *
     ********************/
    /** Clean Inputs
     * Creates a normalized array
     * @param mixed $data
     * @return array
     */
    private function _cleanInputs($data) 
    {
        $cleanInput = array();
        if (is_array($data)) {
            foreach ($data as $key => $val) {
                $cleanInput[$key] = $this->_cleanInputs($val);
            }
        }
        else {
            $cleanInput = trim(strip_tags($data));
        }
        return $cleanInput;
    }
    
    private function _response($data, $status = 200) 
    {
        header("HTTP/1.1 " . $status . " " . $this->_requestStatus($status));
        return json_encode($data, true);
    }
    
    private function _requestStatus($code) 
    {
        $status = array(
            200 => "OK",
            404 => "Not Found",
            405 => "Method Not Allowed",
            500 => "Internal Server Error",
        );
        return ($status[$code]) ? $status[$code] : $status[500];
    }
    
}