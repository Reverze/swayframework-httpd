<?php

namespace Sway\Component\Httpd\Exception;

class ResponseServiceException extends \Exception
{
    /**
     * Throws an exception when passed response is empty (object is null)
     * @return \Sway\Component\Httpd\Exception\ResponseServiceException
     */
    public static function emptyResponseObject() : ResponseServiceException
    {
        return (new ResponseServiceException(sprintf("Response object passed to response service is null")));
    }
    
    /**
     * Throws an exception when passed response object is invalid (invalid instance of classs)
     * @return \Sway\Component\Httpd\Exception\ResponseServiceException
     */
    public static function invalidResponseObject() : ResponseServiceException
    {
        return (new ResponseServiceException(sprintf("Response object passed to response service is invalid")));
    }
}

?>

