<?php

namespace Rdarcy1\FractalHelpers\Tests\Stubs\Models;

class Book
{
    public $author;
    public $main_characters;

    public function __construct()
    {
        $this->author = new \stdclass;
        $this->main_characters = [1, 2];
    }
}
