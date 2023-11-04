<?php
/**
 * Description of Module Model - UserPassword:
 *
 * This model was created for module: User
 * @author MiroJi
 * Created_at: 1689666644
 */
declare (strict_types=1);

namespace App\Modules\UserModule\Model;

/**
*   Using main module Model
*/
use App\Modules\UserModule\Model\User;
use App\Core\Database\Database;
use App\Model\AuthManager;
use App\Exception\LoraException;

//Interface
use App\Core\Interface\ModelDBInterface;

//Core
use App\Core\DI\DIContainer;

class UserPassword extends User implements ModelDBInterface
{
    protected $model_table = "UserPassword";
    protected $database;

    public function __construct(DIContainer $container, Database $database) //Can expand to multiple arguments, first must be DIContainer
    {
        parent::__construct($container);    //Only this one argument is needed

        $this->database = $database;
        //$this->database->table = $this->model_table;      //Uncheck this, if table is different from controller name
    }

    
    public function updateUserPassword(array $post, int $uid, AuthManager $auth_manager)
    {
        //hash current password 
        //$hashed_current = $auth_manager->password_hash($post["current_password"]);
        //check, if current password is correct
        $user_db = $this->database->selectRow("users", "uid=?", [$uid]);
        //compare new password with again password
        if(password_verify($post["current-password"], $user_db["password"]))
        {
            if($post["new-password"] == $post["again-password"])
            {
                $hashed_new_password = $auth_manager->password_hash($post["new-password"]);
                $db_query = $this->database->update("users", ["password" => $hashed_new_password], "uid=?", [$uid]);
                return true;
            }
            else
            {
                throw new LoraException("Nové heslo musí být stejné jako ");
            }
        }
        else
        {
            throw new LoraException("Aktuální heslo není správné!");
        }
        //hash new password and update database table


        // update row
        //return $this->database->update($this->model_table, $set, "url=?", [$url]);
    }
    
    /** MAGICAL METHODS **/
    public function __set($name, $value) {
        $this->model_data[$name] = $value;
    }

    public function __get($name) {
        if (isset($this->model_data[$name])) {
            return $this->model_data[$name];
        }
        return null;
    }
} 

