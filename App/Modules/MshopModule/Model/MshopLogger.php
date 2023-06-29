<?php
declare(strict_types=1);

namespace App\Modules\MshopModule\Model;
use App\Core\Lib\Logger;

/**
 * Description of MshopLogger
 *
 * @author michaelmik
 */
class MshopLogger extends Logger
{
    protected $path = "./log/";
    
    public function __construct() 
    {
        $this->log_path = $this->path;
    }
}
