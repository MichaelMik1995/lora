<?php
/**
 * Description of Module Model - Admin:
 *
 * @author MiroJi
 */
declare (strict_types=1);

namespace App\Modules\AdminModule\Model;

use App\Core\Model;

class AdminHrefs extends Admin
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getHrefs()
    {
        return $this->db->select("admin-hrefs", "id!=?", [0]);
    }
}