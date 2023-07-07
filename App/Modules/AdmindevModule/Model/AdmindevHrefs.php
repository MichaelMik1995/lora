<?php
/**
 * Description of Module Model - Admin:
 *
 * @author MiroJi
 */
declare (strict_types=1);

namespace App\Modules\AdmindevModule\Model;

use App\Modules\AdmindevModule\Model\Admindev;
use App\Core\DI\DIContainer;

class AdmindevHrefs extends Admindev
{
    public function __construct(DIContainer $container)
    {
        parent::__construct($container);
    }

    public function getHrefs()
    {
        return $this->database->select("admindev-hrefs", "id!=?", [0]);
    }
}