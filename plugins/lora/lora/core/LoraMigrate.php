<?php
namespace Lora\Lora\Core;
use App\Database\MigrationFactory;

use App\Database\Migration\MigrationCaller\MigrationCaller;
use App\Database\Seed\SeedCaller\SeedCaller;
use App\Database\Migration\PostMigration\PostMigration;
use Lora\Compiler\Templator;
/**
 * Description of loranMigrate
 *
 * @author michaelmik
 */
trait LoraMigrate 
{
    use Templator;

    public static function migrate(MigrationFactory $factory, bool $clear_migration = false)
    {
        

        $migration_caller = new MigrationCaller();

        if($migration_caller->migration_caller_active == true)
        {
            LoraOutput::output("\n#### BEGIN MIGRATION CALLER process ... ####\n", "info");
            $migration_tables = $migration_caller->call();
            foreach($migration_tables as $migrate_file)
            {
                //$get_table = str_replace(["App/Database/Migration/CreateTable", ".php"], "", $migrate_file);
                
                require("App/Database/Migration/CreateTable".$migrate_file.".php");

                $createClass = "Loran\Migration\CreateTable".$migrate_file;
                
                $migration = new $createClass();

                if($clear_migration == true)
                {
                    $migration->removeTable($factory);
                }

                $migration->createOrUpdateTable($factory);

            }

        }
        else
        {
            LoraOutput::output("\n#### BEGIN MIGRATION process ... ####\n", "info");
            //open each file and implement as class
            foreach(glob("App/Database/Migration/*.php") as $migrate_file)
            {
                $get_table = str_replace(["App/Database/Migration/CreateTable", ".php"], "", $migrate_file);
                
                require($migrate_file);
                $createClass = "Loran\Migration\CreateTable".$get_table;
                
                $migration = new $createClass();

                if($migration->hidden == false)
                {
                    if($clear_migration == true)
                    {
                        $migration->removeTable($factory);
                    }

                    $migration->createOrUpdateTable($factory);
                }
                else
                {
                    LoraOutput::output("Skipping migration for table ".$get_table." ...");
                }
            }
        }

        //POST MIGRATION
        $post_migration = new PostMigration();
        
        if($post_migration->hidden == false)
        {
            LoraOutput::output("\n\t#### BEGIN POST Migration process ####\n", "info");
            $post_migration->call($factory);
            LoraOutput::output("\n\t#### END POST Migration process ####\n", "info");
        }

        LoraOutput::output("\n#### END Migration process ####\n", "info");
    }

    public static function migrateOwnCaller(MigrationFactory $factory, string $caller_name)
    {
        $caller_name = str_replace([" ", "-", ".", ",",";"], "_", $caller_name);
        $caller_name = ucfirst($caller_name);

        $caller_file = "./App/Database/Migration/$caller_name/MigrationCaller_$caller_name.php";

        if(file_exists($caller_file))
        {
            require_once($caller_file);
            $caller_class_name = "App\Database\Migration\\".$caller_name."\\MigrationCaller_$caller_name";
            $caller_class = new $caller_class_name();

            //Call() method from caller -- perform CLEAR migrate
            LoraOutput::output("\n#### BEGIN MIGRATION CALLER process ... ####\n", "info");
            $migration_tables = $caller_class->call();

            foreach($migration_tables as $migrate_file)
            {

                $migration_file = "./App/Database/Migration/".$caller_name."/Table/CreateTable" . $migrate_file . ".php";

                if (file_exists($migration_file)) 
                {

                    require("./App/Database/Migration/".$caller_name."/Table/CreateTable" . $migrate_file . ".php");

                    $createClass = "Loran\Migration\CreateTable" . $migrate_file;

                    $migration = new $createClass();

                    $migration->removeTable($factory);

                    $migration->createOrUpdateTable($factory);

                }
                else
                {
                    LoraOutput::output("Nothing to do, skipping ...", "warning");
                }
            }

            //Perform post migration
            $migration_post = $caller_class->postMigration($factory);

            //Perform migrate data

            LoraOutput::output("\n#### BEGIN DATA CALLER ####\n", "info");

            $seeds = $caller_class->callMigrateData();

            foreach($seeds as $seed_file)
            {
                $seed_path = "App/Database/Migration/".$caller_name."/Data/CreateTable" . $seed_file . "Seed.php";

                if (file_exists($seed_path)) {
                    require("App/Database/Migration/".$caller_name."/Data/CreateTable" . $seed_file . "Seed.php");

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
        $template_content = file_get_contents("./plugins/lora/lora/templates/migration/caller.template");
        $caller = ucfirst($caller);
        $caller_name = str_replace([" ", "-", ".", ",",";"], "_", $caller);
        $compiled_content = Templator::compile($template_content, [
            "{Caller}" => $caller_name,
            "{time}" => DATE("d.m.Y H:i:s"),
        ]);

        if($folder == "")
        {
            $caller_file = "./App/Database/Migration/$caller_name/MigrationCaller_$caller_name.php";
        }
        else
        {
            $caller_file = "./App/Database/Migration/".ucfirst($folder)."/MigrationCaller_$caller_name.php";
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
    
    public static function migrateSeed(MigrationFactory $factory)
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
                
                $migration = new $createClass();

                if($migration->hidden == false)
                {
                    if($migration->truncate_before_seed == true)
                    {
                        $migration->truncateTable($factory);
                    }

                    $migration->createSeeds($factory);
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
