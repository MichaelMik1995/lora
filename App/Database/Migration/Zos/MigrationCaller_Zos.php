<?php
declare(strict_types = 1);

namespace App\Database\Migration\Zos;

use App\Database\MigrationFactory;

/**
 * 
 * Own calling method call() in migration created at 17.12.2022 08:59:30
 * In call method -> sort calling migrations by yourself
 */
class MigrationCaller_Zos
{

    /**
     * Call own migration sorting by yourself
     *
     * @return array<string>
     */
    public function call()
    {
        return [

            //Call Own migrations (Example.: "Role_id => calling file CreateTableRole_id.php")
            "Zos_services",
            "Zos_news",
            "Zos_station_statuses",
            "Zos_station_animals",
            "Zos_about_pages",
            "Zos_gallery_collections",
            "Zos_gallery",
        ];
    }

    /**
     * Calling post migration callers?
     *
     * @param MigrationFactory $factory
     * @return void
     */
    public function postMigration(MigrationFactory $factory)
    {
        // *  Example of addin foreign keys  * //
        /*$factory->table = "zos-news";
        $factory->addIndex("author");
        $factory->foreignKey("author", "users", "uid");*/

        //$factory->table = "zos-station-statuses";
        //$factory->addIndex("slug");

        //$factory->table = "zos-station-animals";
        //$factory->addIndex("url");
        //$factory->foreignKey("url", "zos-station-statuses", "slug");
        //$factory->foreignKey("author", "users", "uid");

        $factory->table = "zos-gallery";
        $factory->foreignKey("collection", "zos-gallery-collections", "url");
    }

    /**
     * Calling migrated specially for this caller
     * 
     * @return array<string>
     */
    public function callMigrateData()
    {
        return [
            "Zos_services",
            "Zos_news",
            "Zos_station_statuses",
            "Zos_station_animals",
            "Zos_about_pages",
            "Zos_gallery_collections",
            "Zos_gallery"
        ];
    }
}