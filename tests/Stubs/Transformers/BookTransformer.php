<?php

namespace Rdarcy1\FractalHelpers\Tests\Stubs\Transformers;

use Rdarcy1\FractalHelpers\TransformerAbstract;

class BookTransformer extends TransformerAbstract
{
    protected $itemIncludes = ['author' => AuthorTransformer::class];

    protected $collectionIncludes = ['main_characters' => MainCharacterTransformer::class];

    protected $availableIncludes = ['words'];

    public function transform($resource)
    {
        return ['field' => 'Transformed book'];
    }
}
