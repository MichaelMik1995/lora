<?php
/**
 * Description of Module Model - Admin:
 *
 * @author MiroJi
 */
declare (strict_types=1);

namespace App\Modules\AdminModule\Model;

use App\Core\Model;

class AdminSettings extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function flushCache()
    {
        
    }
}