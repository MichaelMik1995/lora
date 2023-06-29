<?php
declare (strict_types=1);

namespace App\Modules\AboutModule\Model;

use App\Core\Model;
use App\Core\Database\Database;
use App\Middleware\Auth;

class About extends Model
{
    public function __construct() 
    {
        $this->init();
    }
}
?>
