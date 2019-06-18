<?php

namespace Konsulting\FractalHelpers\Tests;

use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use Konsulting\FractalHelpers\TransformerAbstract;

class MethodTest extends TestCase
{
    /** @test */
    public function it_runs_the_method_on_the_transformer_if_it_has_the_same_name_as_the_relation()
    {
        $employeeBuilder = \Mockery::mock();
        $employeeBuilder->shouldReceive('currentlyEmployed')->once()->andReturnSelf();
        $employeeBuilder->shouldReceive('get')->once()->andReturn([['type' => 'employee']]);

        $owner = new Owner($employeeBuilder);

        $resource = new Item($owner, new OwnerTransformer);
        $output = (new Manager)
            ->parseIncludes('employees')
            ->createData($resource)
            ->toArray();

        $expected = [
            'data' => [
                'type'      => 'owner',
                'employees' => [
                    'data' => [
                        ['type' => 'employee'],
                    ],
                ],
            ],
        ];

        $this->assertSame($expected, $output);
    }
}

class Owner
{
    private $employeesBuilder;

    public function __construct($employeesBuilder)
    {
        $this->employeesBuilder = $employeesBuilder;
    }

    public function employees()
    {
        return $this->employeesBuilder;
    }
}


class OwnerTransformer extends TransformerAbstract
{
    protected $collectionIncludes = ['employees' => IdentityTransformer::class];

    /**
     * Mimic the Eloquent query builder syntax.
     *
     * @param $builder
     * @return mixed
     */
    public function employees($builder)
    {
        return $builder->currentlyEmployed()->get();
    }

    public function transform()
    {
        return [
            'type' => 'owner',
        ];
    }
}

class IdentityTransformer extends TransformerAbstract
{
    public function transform($resource)
    {
        return $resource;
    }
}
