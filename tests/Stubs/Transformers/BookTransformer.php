<?php

namespace Rdarcy1\FractalHelpers\Tests\Stubs\Transformers;

use Rdarcy1\FractalHelpers\TransformerAbstract;

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
