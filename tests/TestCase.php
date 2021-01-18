<?php

namespace Konsulting\FractalHelpers\Tests;

use DMS\PHPUnitExtensions\ArraySubset\ArraySubsetAsserts;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;

abstract class TestCase extends \PHPUnit\Framework\TestCase
{
    use ArraySubsetAsserts, MockeryPHPUnitIntegration;
}
