<?php
declare(strict_types = 1);

namespace App\Database\Migration\Portfolio;

use App\Database\MigrationFactory;

/**
 * 
 * Own calling method call() in migration created at 19.01.2023 10:06:23
 * In call method -> sort calling migrations by yourself
 */
class MigrationCaller_Portfolio
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
            "PortfolioTypes",
            "PortfolioCategories",
            //"Portfolio_subcategories",
            "Portfolio",
            "PortfolioComments",
            "Portfolio_comment_answers",
            "PortfolioReviews",
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
        /* $factory->table = "role-id";
        $factory->foreignKey("this-id", "table-from", "id-from-table"); */


        //Categories -> to TYPES
        $factory->table = "portfolio-categories";
        $factory->foreignKey("portfolio_type", "portfolio-types", "url");

        //Potfolio to CATEGORIES
        $factory->table = "portfolio";
        $factory->foreignKey("category_url", "portfolio-categories", "url");

        //Comments to PORTFOLIO
        $factory->table = "portfolio-comments";
        $factory->foreignKey("portfolio_url", "portfolio", "url");

        $factory->table = "portfolio-reviews";
        $factory->foreignKey("portfolio_url_key", "portfolio", "url");

        $factory->table = "portfolio-comment-answers";
        $factory->foreignKey("comment_url", "portfolio-comments", "url");

    }

    /**
     * Calling migrated data specially for this caller
     * 
     * @return array<string>
     */
    public function callMigrateData()
    {
        return [
            "PortfolioTypes",
            "PortfolioCategories",
            //"Portfolio_subcategories",
            "Portfolio",
            //"PortfolioComments",
            //"PortfolioReviews",
        ];
    }
}