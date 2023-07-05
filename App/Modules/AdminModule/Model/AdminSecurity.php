<?php
/**
 * Description of Module Model - AdminSecurity:
 *
 * This model was created for module: Admin
 * @author MiroJi
 * Created_at: 1688127184
 */
declare (strict_types=1);

namespace App\Modules\AdminModule\Model;
use App\Core\DI\DIContainer;

/**
*   Using main module Model
*/
use App\Modules\AdminModule\Model\Admin;

class AdminSecurity extends Admin
{
    public function __construct(DIContainer $container)
    {
        parent::__construct($container);
    }


} 

