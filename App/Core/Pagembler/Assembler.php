<?php
declare(strict_types=1);

namespace App\Core\Pagembler;

class Assembler
{
    /**
     * @var array
     */

    private array $page_data;

    public function __construct()
    {
        $this->page_data = [];  //NULL on initialization
    }

    /**
     * 
     */
    public static function preparePage(string $page_url)
    {
        echo "report $page_url";

        //Prepare data from database > $this->assemblePage()
    }

    /**
     * 
     */
    public function assemblePage()
    {
        /*$this->setTitle($data['title']);
        $this->setSlug($data['slug']);
        $this->setDescription($data['description']);
        $this->setContent($data['content']);
        $this->setAuthor($data['author']);
        $this->setCreatedAt($data['created_at']);
        $this->setUpdatedAt($data['updated_at']);
        $this->setPublished($data['published']);
        $this->setPublishedAt($data['published_at']);
        $this->setPublishedBy($data['published_by']);
        $this->setTags($data['tags']);*/
    }

    /**
     * 
     */
    private function catchError($error)
    {

    }
}