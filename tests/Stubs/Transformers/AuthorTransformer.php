<?php

namespace Rdarcy1\FractalHelpers\Tests\Stubs\Transformers;

use Rdarcy1\FractalHelpers\TransformerAbstract;

class AuthorTransformer extends TransformerAbstract
{
    public function transform($resource)
    {
        return ['field' => 'Transformed author'];
    }
}
