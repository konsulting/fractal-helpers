<?php

namespace Rdarcy1\FractalHelpers\Tests;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Rdarcy1\FractalHelpers\Tests\Stubs\Models\Book;
use Rdarcy1\FractalHelpers\Tests\Stubs\Transformers\BookTransformer;

class NullRelationshipTest extends TestCase
{
    /** @test */
    public function it_returns_an_empty_resource_if_the_relationship_value_is_null()
    {
        $resource = new Item(new Book, new BookTransformer);
        $result = (new Manager)
            ->parseIncludes('null_item_relationship,null_collection_relationship')
            ->createData($resource)
            ->toArray();

        $this->assertArraySubset([
            'data' => [
                'null_item_relationship'       => ['data' => []],
                'null_collection_relationship' => ['data' => []],
            ],
        ], $result);
    }
}
