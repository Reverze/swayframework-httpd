<?php

namespace Sway\Component\Httpd;

use Sway\Component\Httpd\Exception;
use Sway\Component\Dependency\DependencyInterface;
use Sway\Component\Text\Stringify;
use Sway\Component\Http\Response;

class HttpdInterface extends DependencyInterface
{
    /**
     * HTTPD parameters
     * @var arary
     */
    protected $parameters = array();
    
    /**
     * Accepted http's method
     * @var array
     */
    private $httpMethods = [
        'GET', 'POST', 'PUT', "DELETE",
        'HEAD'
    ];
    
    
    
    public function __construct(array $httpdParameters = array())
    {
        if (!empty($httpdParameters)){
            $this->parameters = $httpdParameters;
        }
        
        if (empty($this->parameters)){
            $this->parameters = $_SERVER;
        }
    }
    
    protected function dependencyController() 
    {
        
    }


    /**
     * 
     * @return \Sway\Component\Httpd\HttpdInterface
     * @throws \Sway\Component\Httpd\HttpdInterface
     */
    public static function createFromGlobals() : HttpdInterface
    {
        if (isset($_SERVER)){
            $interface = new HttpdInterface($_SERVER);
            return $interface;
        }
        else{
            throw Exception\GlobalException::phpGlobalServerVariableException();
        }
    }
    
    /**
     * Gets route's path 
     * @return string
     */
    public function getRoutePath() : string
    {
        if (isset($this->parameters['PATH_INFO'])){
            $length = strlen($this->parameters['PATH_INFO']);
            
            if ($this->parameters['PATH_INFO'][$length - 1] === '/' && $length > 1){
                $this->parameters['PATH_INFO'] = Stringify::removeAt(
                        $this->parameters['PATH_INFO'],
                        $length - 1);
            }
            
            /* Update lenght */
            $length = strlen($this->parameters['PATH_INFO']);
            
            $occurence = Stringify::findChar($this->parameters['PATH_INFO'], '&');
            
            if ($occurence){
                $this->parameters['PATH_INFO'] = Stringify::removeFrom(
                        $this->parameters['PATH_INFO'],
                        $occurence);
                
            }
            
            return $this->parameters['PATH_INFO'];
        }
        else{
            $explodedScriptPath = explode('/', $this->parameters['SCRIPT_FILENAME']);
            $explodedRequestUri = explode('/', $this->parameters['REQUEST_URI']);
            
            if ($explodedScriptPath[sizeof($explodedScriptPath) - 1] === $explodedRequestUri[sizeof($explodedRequestUri) - 1]){
                return '/';
            }

            return $this->parameters['REQUEST_URI'];
        }
    }
    
    /**
     * Gets http's hostname
     * @return string
     */
    public function getHost() : string
    {
        return $this->parameters['HTTP_HOST'] ?? null;
    }
    
    /**
     * Gets user's agent
     * @return string
     */
    public function getUserAgent() : string
    {
        return $this->parameters['HTTP_USER_AGENT'] ?? null;
    }
    
    /**
     * Gets accepted encoding by client
     * @return string
     */
    public function getAcceptEncoding() : string
    {
        return $this->parameters['HTTP_ACCEPT_ENCODING'] ?? null;
    }
    
    /**
     * Gets type of http connection
     * @return string
     */
    public function getConnectionType() : string
    {
        return $this->parameters['HTTP_CONNECTION'] ?? null;
    }
    
    /**
     * Gets server's signature
     * @return string
     */
    public function getSignature() : string
    {
        return $this->parameters['SERVER_SIGNATURE'] ?? null;
    }
    
    /**
     * Gets server's software
     * @return string
     */
    public function getSoftware() : string
    {
        return $this->parameters['SERVER_SOFTWARE'] ?? null;
    }
    
    /**
     * Gets server's name
     * @return string
     */
    public function getServerName() : string
    {
        return $this->parameters['SERVER_NAME'] ?? null;
    }
    
    /**
     * Gets server's address
     * @return strinng
     */
    public function getAddress() : string
    {
        return $this->parameters['SERVER_ADDR'] ?? null;
    }
    
    /**
     * Gets server's port
     * @return integer
     */
    public function getPort() : int
    {
        return (integer) $this->parameters['SERVER_PORT'] ?? 0;
    }
    
    /**
     * Gets client's ip address
     * @return string
     */
    public function getRemoteAddress() : string
    {
        return $this->parameters['REMOTE_ADDR'] ?? null;
    }
    
    /**
     * Gets client's port
     */
    public function getRemotePort() : int
    {
        return (integer) $this->parameters['REMOTE_PORT'] ?? 0;
    }
    
    /**
     * Gets document root path
     * @return string
     */
    public function getDocumentRoot() : string
    {
        return $this->parameters['DOCUMENT_ROOT'] ?? null;
    }
    
    /**
     * Gets request's scheme
     * @return string
     */
    public function getRequestScheme() : string
    {
        return $this->parameters['REQUEST_SCHEME'] ?? null;
    }
    
    /**
     * Gets script's name
     * @return string
     */
    public function getScriptName() : string
    {
        return $this->parameters['SCRIPT_FILENAME'] ?? null;
    }
    
    /**
     * Gets gateway's interface
     * @return string
     */
    public function getGatewayInterface() : string
    {
        return $this->parameters['GATEWAY_INTERFACE'] ?? null;
    }
    
    /**
     * Gets server's protocol
     * @return string
     */
    public function getServerProtocol() : string
    {
        return $this->parameters['SERVER_PROTOCOL'] ?? null;
    }
    
    /**
     * Gets request's method
     * @return string
     */
    public function getMethod() : string
    {
        return $this->parameters['REQUEST_METHOD'] ?? null;
    }
    
    /**
     * Gets query's string
     * @return string
     */
    public function getQuery() : string
    {
        return $this->parameters['QUERY_STRING'] ?? null;
    }
    
    /**
     * Gets request's uri
     * @return string
     */
    public function getUri() : string
    {
        return $this->parameters['REQUEST_URI'] ?? null;
    }
    
    /**
     * Gets request's timestamp
     * @return int
     */
    public function getTime() : int
    {
        return (int) $this->parameters['REQUEST_TIME'] ?? time();
    }
    
    /**
     * Gets value of custom parameter
     * @param string $parameter
     * @return mixed
     */
    public function get(string $parameter)
    {
        return $this->parameters[$parameter];
    }
    
    /**
     * Checks if custom parameter is defined
     * @param string $parameter
     * @return boolean
     */
    public function has(string $parameter) : bool
    {
        return isset($this->parameters[$parameter]);
    }
    
    /**
     * Checks if http method is defined
     * @param string $httpMethod
     * @return bool
     */
    public function isMethodDefined(string $httpMethod) : bool
    {
        return (in_array(strtoupper($httpMethod), $this->httpMethods));
    }
    
    public function serviceResponse(Response $response)
    {
        /**
         * Creates response service which parse controller's response
         * and output to client
         */
        $responseService = new ResponseService($response);
        $responseService->service();
            
    }
    
}

?>

