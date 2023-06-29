<?php
/**
 * Description of Module Model - UserDashboard:
 *
 * This model was created for module: User
 * @author MiroJi
 * Created_at: 1672260741
 */
declare (strict_types=1);

namespace App\Modules\UserModule\Model;

/**
*   Using main module Model
*/
use App\Modules\UserModule\Model\User;

class UserDashboard extends User
{
    public function __construct()
    {
        parent::__construct();
    }


} 

