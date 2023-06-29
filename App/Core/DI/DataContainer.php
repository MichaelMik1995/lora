<?php
declare(strict_types=1);

namespace App\Core\DI;

use App\Core\Database\Database;

class DataContainer
{
    public string $session_key;

    private Database $database;

    private string $session_algo_key;

    public function __construct(Database $database = null)
    {
        $this->connectDatabase($database);
    }

    private function connectDatabase(Database $database)
    {
        if($database == null)
        {
            //$this->database = new Database();
        }
        else
        {
            $this->database = $database;
        }
    }

    private function generateSessionID()
    {

    }

    private function prepareToSave()
    {

    }

    private function save()
    {

    }

    private function getData()
    {

    }

    private function prepareToRead()
    {
        
    }
}

/*
// serializujeme objekt
$serialized = serialize($user);

// šifrujeme serializovaný objekt
$encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $serialized, MCRYPT_MODE_CBC);

//UN
// načteme obsah souboru do proměnné
$encrypted = file_get_contents("user.dat");

// dešifrujeme šifrovaný řetězec
$serialized = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $encrypted, MCRYPT_MODE_CBC);

// deserializujeme řetězec zpět na objekt
$user = unserialize($serialized);

// můžeme použít objekt jako obvykle
echo $user->name; // výstup: "John Doe"

*/