<?php

namespace Konsulting\FractalHelpers\Tests\Stubs\Transformers;

use Konsulting\FractalHelpers\TransformerAbstract;

class BookTransformer extends TransformerAbstract
{
    protected $itemIncludes = [
        'author'                 => AuthorTransformer::class,
        'null_item_relationship' => 'Dummy\\Namespace',
    ];

    protected $collectionIncludes = [
        'main_characters'              => MainCharacterTransformer::class,
        'null_collection_relationship' => 'Dummy\\Namespace',
    ];

    protected $availableIncludes = ['words'];

    public function transform($resource)
    {
        return ['field' => 'Transformed book'];
    }
}
