<?php
declare(strict_types=1);

namespace App\Core\Interface;

interface ModelDBInterface
{
    /** CRUD METHODS **/


    /** MAGIC METHODS **/
    public function __set($field, $value);
    public function __get($field);
}