<?php
/**
 * Description of Module Model - UserData:
 *
 * This model was created for module: User
 * @author MiroJi
 * Created_at: 1689059617
 */
declare (strict_types=1);

namespace App\Modules\UserModule\Model;

/**
*   Using main module Model
*/
use App\Modules\UserModule\Model\User;
use App\Core\Database\Database;

//Core
use App\Core\DI\DIContainer;

class UserData extends User
{
    protected $model_table = "users";
    protected $database;

    protected static $_instance;

    protected static $_instance_id;

    public function __construct(DIContainer $container, Database $database) //Can expand to multiple arguments, first must be DIContainer
    {
        parent::__construct($container);    //Only this one argument is needed

        $this->database = $database;
        //$this->database->table = $this->model_table;      //Uncheck this, if table is different from controller name
    }
    
    /**
     * 
     * @return object <p>Returns one row from table depends on URL key</p>
     * @see Database()->tableRowByRoute()
     */
    public function getUserData(int $url): Array
    {

        $db_query = $this->database->selectRow($this->model_table, "uid=?", [$url]);

        if(!empty($db_query))
        {        
            $this->model_data = $db_query;
        }
        else
        {
           $this->model_data = [];
        }

        return $this->model_data;
    }
    
    public function updateUserData(array $set, string $url)
    {
        // update row
        return $this->database->update($this->model_table, $set, "url=?", [$url]);
    }
} 

