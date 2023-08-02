<?php
namespace App\Database;


/**
 * Description of Factory
 *
 * @author michaelmik
 */
class Factory 
{
    /**
     * 
     * @var string <p>Select row(s) by $route_key</p>
     */
    public $route_key = "url";
    

    /**
     * 
     * @var string <p>In default, table = model class (small chars)</p>
     */
    public $table;
    
    /**
     * 
     * @var string <p>Select table WHERE $route_key = $route_param</p>
     */
    public $route_param;
    
    /**
     * 
     * @var string <p>Ordering rows from table. Ex.: id ASC -> column, order type </p>
     */
    protected $order_by = "id ASC";
    
    //create database if not exists `test`;
    
    public function __construct() 
    {
       $this->setTableData();
       
    }
    
    /**
     * 
     * @return boolean
     */
    protected function setTableData()
    {
        $route_url = explode("/", @$_SERVER["REQUEST_URI"]);
        
        $this->table = @$route_url[1]; //controller
        //$this->action = @$route_url[2]; //action [show|edit|insert|update|delete]
        
        if(@$route_url[2] != "")
        {
            $this->route_param = @$route_url[3];
        }
        
        return true;
    }
           
}