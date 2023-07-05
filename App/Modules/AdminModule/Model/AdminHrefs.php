<?php
/**
 * Description of Module Model - Admin:
 *
 * @author MiroJi
 */
declare (strict_types=1);

namespace App\Modules\AdminModule\Model;

use App\Core\Model;
use App\Core\DI\DIContainer;

class AdminHrefs extends Admin
{
    public function __construct(DIContainer $container)
    {
        parent::__construct($container);
    }

    public function getHrefs()
    {
        return $this->database->select("admin-hrefs", "id!=?", [0]);
    }
}