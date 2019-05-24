<?php

namespace Konsulting\FractalHelpers\Tests;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use Konsulting\FractalHelpers\Tests\Stubs\Models\Book;
use Konsulting\FractalHelpers\Tests\Stubs\Transformers\BookTransformer;
use Konsulting\FractalHelpers\Tests\Stubs\Transformers\AuthorTransformer;
use Konsulting\FractalHelpers\Tests\Stubs\Transformers\MainCharacterTransformer;

class TransformerAbstractTest extends TestCase
{
    /** @test */
    public function it_combines_item_and_collection_includes_attributes_into_available_includes()
    {
        $transformer = new BookTransformer;

        $this->assertEmpty(array_diff(['words', 'author', 'main_characters'], $transformer->getAvailableIncludes()));
    }

    /** @test */
    public function it_returns_an_item_for_an_item_relation()
    {
        $item = (new BookTransformer)->includeAuthor(new Book);

        $expectedItem = new Item((new Book)->author, new AuthorTransformer());

        $this->assertEquals($expectedItem, $item);
    }

    /** @test */
    public function it_returns_a_collection_for_a_collection_relation()
    {
        $collection = (new BookTransformer)->includeMainCharacters(new Book);

        $expectedCollection = new Collection((new Book)->main_characters, new MainCharacterTransformer);

        $this->assertEquals($expectedCollection, $collection);
    }

    /** @test */
    public function it_throws_a_bad_method_exception_if_a_nonexistent_method_is_called()
    {
        $this->expectException(\BadMethodCallException::class);

        (new BookTransformer)->badMethod();
    }

    /** @test */
    public function it_includes_an_item_resource()
    {
        $books = [new Book, new Book];

        $resource = new Collection($books, new BookTransformer);
        $output = (new Manager)
            ->parseIncludes('author,main_characters')
            ->createData($resource)
            ->toArray();

        $expected = [
            'data' => [
                [
                    'field'           => 'Transformed book',
                    'author'          => [
                        'data' => ['field' => 'Transformed author'],
                    ],
                    'main_characters' => [
                        'data' => [
                            ['field' => 'Transformed character'],
                            ['field' => 'Transformed character'],
                        ],
                    ],
                ],
                [
                    'field'           => 'Transformed book',
                    'author'          => [
                        'data' => ['field' => 'Transformed author'],
                    ],
                    'main_characters' => [
                        'data' => [
                            ['field' => 'Transformed character'],
                            ['field' => 'Transformed character'],
                        ],
                    ],
                ],
            ],
        ];

        $this->assertEquals($expected, $output);
    }
}
