<?php

namespace Konsulting\FractalHelpers\Tests;

use Konsulting\FractalHelpers\Tests\Stubs\Models\Book;
use Konsulting\FractalHelpers\Tests\Stubs\Transformers\AuthorTransformer;
use Konsulting\FractalHelpers\Tests\Stubs\Transformers\BookTransformer;
use Konsulting\FractalHelpers\TransformerAbstract;
use League\Fractal\Resource\Item;
use stdClass;

class OverrideTest extends TestCase
{
    /** @test */
    public function it_allows_an_override_on_the_transformer_instantiation_method()
    {
        $item = (new OverrideBookTransformer)->includeAuthor(new Book);

        $expectedItem = new Item(new stdClass, new OverrideAuthorTransformer);

        $this->assertEquals($expectedItem, $item);
    }
}

class OverrideBookTransformer extends BookTransformer
{
    protected function makeTransformer(string $class)
    {
        return new OverrideAuthorTransformer;
    }


    public function transform($resource)
    {

    }
}

class OverrideAuthorTransformer extends TransformerAbstract
{
    public function transform($resource)
    {
        return ['override' => true];
    }
}
