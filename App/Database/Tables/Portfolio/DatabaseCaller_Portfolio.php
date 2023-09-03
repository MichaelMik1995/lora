<?php
declare(strict_types = 1);

namespace App\Database\Tables\Portfolio;

use App\Database\DatabaseFactory;

/**
 * 
 * Own calling method call() in database created at 19.01.2023 10:06:23
 * In call method -> sort calling databases by yourself
 */
class DatabaseCaller_Portfolio
{

    /**
     * Call own database sorting by yourself
     *
     * @return array<string>
     */
    public function call()
    {
        return [

            //Call Own databases (Example.: "Role_id => calling file CreateTableRole_id.php")
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
     * Calling post database callers?
     *
     * @param DatabaseFactory $factory
     * @return void
     */
    public function postWritter(DatabaseFactory $factory)
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
    public function callDatabaseData()
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