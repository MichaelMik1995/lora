<?php
/**
 * Description of Module Model - BlogComment:
 *
 * This model was created for module: Blog
 * @author MiroJi
 * Created_at: 1689060798
 */
declare (strict_types=1);

namespace App\Modules\BlogModule\Model;

use App\Core\DI\DIContainer;

/**
*   Using main module Model
*/
use App\Modules\BlogModule\Model\Blog;

class BlogComment extends Blog
{
    public function __construct(DIContainer $container)
    {
        parent::__construct($container);
    }


} 

