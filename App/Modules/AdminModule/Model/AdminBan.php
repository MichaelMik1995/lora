<?php
/**
 * Description of Module Model - AdminBan:
 *
 * This model was created for module: Admin
 * @author MiroJi
 * Created_at: 1689771154
 */
declare (strict_types=1);

namespace App\Modules\AdminModule\Model;

use App\Core\DI\DIContainer;

use App\Core\Interface\ClassInterface;

/**
*   Using main module Model
*/
use App\Modules\AdminModule\Model\Admin;

class AdminBan extends Admin implements ClassInterface
{

    private string $blacklist_file = ".blacklist";

    public function __construct(DIContainer $container)
    {
        parent::__construct($container);

        $this->parseBlacklistFile();
    }


    public function getBlackList()
    {

    }

    private function parseBlacklistFile()
    {
        $lines = file($this->blacklist_file, FILE_SKIP_EMPTY_LINES|FILE_IGNORE_NEW_LINES);
        $count = 0;

        foreach($lines as $line) 
        {
            $count += 1;
            $this->model_data["pattern"][] = $line;
        }

        $this->model_data["count"] = $count;
    }
} 

