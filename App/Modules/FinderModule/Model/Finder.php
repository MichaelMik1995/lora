<?php
declare (strict_types=1);

namespace App\Modules\FinderModule\Model;

use App\Core\Model;
use App\Core\Database\Database;
use App\Middleware\Auth;

class Finder extends Model
{
    public function __construct() 
    {
        $this->init();
    }
}
?>
