<?php

namespace Konsulting\FractalHelpers\Tests\Stubs\Models;

class Book
{
    public $author;
    public $main_characters;

    public $null_item_relationship = null;
    public $null_collection_relationship = null;

    public function __construct()
    {
        $this->author = new \stdclass;
        $this->main_characters = [1, 2];
    }
}
