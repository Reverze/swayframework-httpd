<?php

namespace Sway\Component\Httpd;

use Sway\Component\Dependency\DependencyInterface;
use Sway\Component\Http\Response;


class ResponseService extends DependencyInterface
{
    /**
     * Response to service
     * @var \Sway\Component\Httpd\Response
     */
    private $response = null;
    
    /**
     * Creates a new response service
     * @param Response $response
     * @throws \Sway\Component\Httpd\Exception\ResponseServiceException
     */
    public function __construct(Response $response)
    {
        /**
         * Response object cannot be null
         */
        if (empty($response)){
            throw Exception\ResponseServiceException::emptyResponseObject();
        }
        
        /**
         * Invalid class instance
         */
        if (!$response instanceof Response){
            throw Exception\ResponseServiceException::invalidResponseObject();
        }
        
        /** Stores response */
        $this->response = $response;       
    }
    
    /**
     * Services response
     */
    public function service()
    {
        /**
         * Response's content
         */
        $responseContent = $this->response->getContext();
        
        /**
         * Http's response code
         */
        $responseCode = (int) $this->response->getCode();
        
        /**
         * Sets http's response code
         */
        http_response_code($responseCode);
        
        /**
         * Sets location (if defined)
         */
        if (!empty($this->response->getLocation()))
        {
            header(sprintf("Location: %s", $this->response->getLocation()));
        }
        
        /**
         * Outputs response's content
         */
        echo $responseContent;
    }
    
    
    
}


?>

