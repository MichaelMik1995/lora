<?php
namespace Lora\Lora\Core\Executor;
use App\Database\DatabaseFactory;

use App\Database\Tables\DatabaseCaller\DatabaseCaller;
use App\Database\Seed\SeedCaller\SeedCaller;
use App\Database\Tables\PostMigration\PostMigration;
use Lora\Compiler\Templator;
use Lora\Lora\Core\LoraOutput;
/**
 * Description of loranMigrate
 *
 * @author michaelmik
 */
trait LoraDatabase 
{
    use Templator;
    use LoraOutput;

    public static function migrate(DatabaseFactory $factory, bool $clear_database = false)
    {
        

        $database_caller = new DatabaseCaller();

        if($database_caller->database_caller_active == true)
        {
            LoraOutput::output("\n#### BEGIN MIGRATION CALLER process ... ####\n", "info");
            $database_tables = $database_caller->call();
            foreach($database_tables as $migrate_file)
            {
                //$get_table = str_replace(["App/Database/Tables/CreateTable", ".php"], "", $migrate_file);
                
                require("App/Database/Tables/CreateTable".$migrate_file.".php");

                $createClass = "Loran\Database\CreateTable".$migrate_file;
                
                $database = new $createClass();

                if($clear_database == true)
                {
                    $database->removeTable($factory);
                }

                $database->createOrUpdateTable($factory);

            }

        }
        else
        {
            LoraOutput::output("\n#### BEGIN MIGRATION process ... ####\n", "info");
            //open each file and implement as class
            foreach(glob("App/Database/Tables/*.php") as $migrate_file)
            {
                $get_table = str_replace(["App/Database/Tables/CreateTable", ".php"], "", $migrate_file);
                
                require($migrate_file);
                $createClass = "Loran\Database\CreateTable".$get_table;
                
                $database = new $createClass();

                if($database->hidden == false)
                {
                    if($clear_database == true)
                    {
                        $database->removeTable($factory);
                    }

                    $database->createOrUpdateTable($factory);
                }
                else
                {
                    LoraOutput::output("Skipping database for table ".$get_table." ...");
                }
            }
        }

        //POST MIGRATION
        $post_database = new PostMigration();
        
        if($post_database->hidden == false)
        {
            LoraOutput::output("\n\t#### BEGIN POST Migration process ####\n", "info");
            $post_database->call($factory);
            LoraOutput::output("\n\t#### END POST Migration process ####\n", "info");
        }

        LoraOutput::output("\n#### END Migration process ####\n", "info");
    }

    public static function migrateOwnCaller(DatabaseFactory $factory, string $caller_name)
    {
        $caller_name = str_replace([" ", "-", ".", ",",";"], "_", $caller_name);
        $caller_name = ucfirst($caller_name);

        $caller_file = "./App/Database/Tables/$caller_name/DatabaseCaller_$caller_name.php";

        if(file_exists($caller_file))
        {
            require_once($caller_file);
            $caller_class_name = "App\Database\Tables\\".$caller_name."\\DatabaseCaller_$caller_name";
            $caller_class = new $caller_class_name();

            //Call() method from caller -- perform CLEAR migrate
            LoraOutput::output("\n#### BEGIN DATABASE CALLER process ... ####\n", "info");
            $database_tables = $caller_class->call();

            foreach($database_tables as $migrate_file)
            {

                $database_file = "./App/Database/Tables/".$caller_name."/Table/CreateTable" . $migrate_file . ".php";

                if (file_exists($database_file)) 
                {

                    require("./App/Database/Tables/".$caller_name."/Table/CreateTable" . $migrate_file . ".php");

                    $createClass = "Loran\Database\CreateTable" . $migrate_file;

                    $database = new $createClass();

                    $database->removeTable($factory);

                    $database->createOrUpdateTable($factory);

                }
                else
                {
                    LoraOutput::output("Nothing to do, skipping ...", "warning");
                }
            }

            //Perform post database
            $database_post = $caller_class->postWritter($factory);

            //Perform migrate data

            LoraOutput::output("\n#### BEGIN DATA CALLER ####\n", "info");

            $seeds = $caller_class->callDatabaseData();

            foreach($seeds as $seed_file)
            {
                $seed_path = "App/Database/Tables/".$caller_name."/Data/CreateTable" . $seed_file . "Seed.php";

                if (file_exists($seed_path)) {
                    require("App/Database/Tables/".$caller_name."/Data/CreateTable" . $seed_file . "Seed.php");

                    $createClass = "Loran\Seed\CreateTable" . $seed_file . "Seed";

                    $seeding = new $createClass();

                    if ($seeding->truncate_before_seed == true) {
                        $seeding->truncateTable($factory);
                    }

                    $seeding->createSeeds($factory);
                }
                else
                {
                    LoraOutput::output("Nothing to do, skipping ...", "warning");
                }

            }

            LoraOutput::output("\n#### END CALLER process ####\n", "info");


        }
        else
        {
            LoraOutput::output("Migration caller $caller_name not exists!", "error");
            LoraOutput::output(">> Send command for create new one: php lora migrate:create $caller_name [--data, --caller]", "info");
        }
    }
    
    public static function createCaller(string $caller, string $folder = "")
    {
        //get template
        $template_content = file_get_contents("./plugins/lora/lora/templates/database/caller.template");
        $caller = ucfirst($caller);
        $caller_name = str_replace([" ", "-", ".", ",",";"], "_", $caller);
        $compiled_content = Templator::compile($template_content, [
            "{Caller}" => $caller_name,
            "{time}" => DATE("d.m.Y H:i:s"),
        ]);

        if($folder == "")
        {
            $caller_file = "./App/Database/Tables/$caller_name/DatabaseCaller_$caller_name.php";
        }
        else
        {
            $caller_file = "./App/Database/Tables/".ucfirst($folder)."/DatabaseCaller_$caller_name.php";
        }

        
        if(!file_exists($caller_file))
        {
            $file = fopen($caller_file, "w");
            fwrite($file, $compiled_content);
            fclose($file);
            LoraOutput::output("Migration caller $caller_name created!", "success");
        }
        else
        {
            LoraOutput::output("This caller $caller_file already exists! Skipping ...", "warning");
        }

    }
    
    public static function migrateSeed(DatabaseFactory $factory)
    {
        LoraOutput::output("\n#### BEGIN DATA insert process ####\n", "info");

        $seed_caller = new SeedCaller();

        if($seed_caller->seed_caller_active == true)
        {
            LoraOutput::output("\n#### BEGIN DATA CALLER ####\n", "info");

            $seeds = $seed_caller->call();

            foreach($seeds as $seed_file)
            {
                //$get_table = str_replace(["App/Database/Seed/CreateTable", ".php"], "", $seed_file);
                
                require("App/Database/Seed/CreateTable".$seed_file."Seed.php");

                $createClass = "Loran\Seed\CreateTable".$seed_file."Seed";
                
                $seeding = new $createClass();

                if($seeding->truncate_before_seed == true)
                {
                    $seeding->truncateTable($factory);
                }

                $seeding->createSeeds($factory);

            }

            LoraOutput::output("\n#### END CALLER process ####\n", "info");
        }

        else
        {
            //open each file and implement as class
            foreach(glob("App/Database/Seed/*.php") as $migrate_file)
            {
                $get_table = str_replace(["App/Database/Seed/CreateTable", ".php", "Seed"], "", $migrate_file);
                
                require($migrate_file);
                $createClass = "Loran\Seed\CreateTable".$get_table."Seed";
                
                $database = new $createClass();

                if($database->hidden == false)
                {
                    if($database->truncate_before_seed == true)
                    {
                        $database->truncateTable($factory);
                    }

                    $database->createSeeds($factory);
                }
                else
                {
                    LoraOutput::output("X Skipping creating seed for table ".$get_table." ...");
                }
            }
        }

        LoraOutput::output("\n#### END DATA insert process ####\n", "info");
    }
}
