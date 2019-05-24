<?php

namespace Konsulting\FractalHelpers\Tests\Stubs\Transformers;

use Konsulting\FractalHelpers\TransformerAbstract;

class AuthorTransformer extends TransformerAbstract
{
    public function transform($resource)
    {
        return ['field' => 'Transformed author'];
    }
}
