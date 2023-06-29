<?php
declare(strict_types = 1);

namespace Lora\DBaser\Core\Database;

/**
 * Working with databes
 */
trait DbaseDatabase
{
    public function createDatabase(string $database_name, string $charset = "UTF-8")
    {
        return $this;
    }
    
    public function deleteDatabase(string $database_name)
    {
        return $this;
    }
}