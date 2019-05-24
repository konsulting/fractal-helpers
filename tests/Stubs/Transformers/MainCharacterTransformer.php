<?php

namespace Konsulting\FractalHelpers\Tests\Stubs\Transformers;

use Konsulting\FractalHelpers\TransformerAbstract;

class MainCharacterTransformer extends TransformerAbstract
{
    public function transform($resource)
    {
        return ['field' => 'Transformed character'];
    }
}
