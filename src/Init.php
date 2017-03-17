<?php

namespace Sway\Component\Httpd;

use Sway\Component\Dependency\DependencyInterface;
use Sway\Component\Init\Component;

class Init extends Component
{
    /**
     * Initializes httpd's interface
     * @return Sway\Component\Httpd\HttpdInterface
     */
    public function init()
    {
        $httpdInterface = HttpdInterface::createFromGlobals();
        return $httpdInterface;
    }
    
    
}


?>

