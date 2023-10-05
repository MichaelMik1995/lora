<?php
/**
 * Description of Module Model - UserSettings:
 *
 * This model was created for module: User
 * @author MiroJi
 * Created_at: 1695759986
 */
declare (strict_types=1);

namespace App\Modules\UserModule\Model;

use App\Core\DI\DIContainer;

/**
*   Using main module Model
*/
use App\Modules\UserModule\Model\User;

class UserSettings extends User
{
    public function __construct(DIContainer $container)
    {
        parent::__construct($container);
    }


} 

