<?php

namespace Sway\Component\Httpd\Exception;


class GlobalException extends \Exception
{
    public function __construct(string $message = "", int $code = 0, \Throwable $previous = null) 
    {
        parent::__construct($message, $code, $previous);
    }
    
    /**
     * When PHP's global variable '$_SERVER' is not set
     * @return \Sway\Component\Httpd\Exception\GlobalException
     */
    public static function phpGlobalServerVariableException ()
    {
        $globalException = new GlobalException (sprintf("PHP's super global 'variable' is not set!"));
        return $globalException;    
    }
}


?>

