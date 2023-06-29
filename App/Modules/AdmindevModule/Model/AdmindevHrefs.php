<?php
/**
 * Description of Module Model - Admin:
 *
 * @author MiroJi
 */
declare (strict_types=1);

namespace App\Modules\AdmindevModule\Model;

use App\Core\Model;
use App\Modules\AdmindevModule\Model\Admindev;

class AdmindevHrefs extends Admindev
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getHrefs()
    {
        return $this->db->select("admindev-hrefs", "id!=?", [0]);
    }
}