<?php

namespace Konsulting\FractalHelpers;

use IlluminateAgnostic\Str\Support\Str;
use League\Fractal\Resource\ResourceAbstract;
use League\Fractal\TransformerAbstract as FractalTransformer;

abstract class TransformerAbstract extends FractalTransformer
{
    /**
     * @var array
     */
    protected $itemIncludes = [
        // 'foo' => FooTransformer::class
    ];

    /**
     * @var array
     */
    protected $collectionIncludes = [
        // 'bar' => BarTransformer::class
    ];

    /**
     * TransformerAbstract constructor.
     */
    public function __construct()
    {
        $this->availableIncludes = array_merge($this->availableIncludes,
            array_keys($this->itemIncludes),
            array_keys($this->collectionIncludes));
    }

    /**
     * Simulate 'include{$resource}()' methods.
     *
     * @param string $method
     * @param array  $arguments
     * @return ResourceAbstract
     */
    public function __call($method, $arguments)
    {
        $baseResource = $arguments[0] ?? null;
        $relation = Str::snake(preg_replace('/^include/', '', $method));

        foreach (['item', 'collection'] as $type) {
            if (array_key_exists($relation, $this->{$type . 'Includes'})) {
                return $this->getFractalResource($type, $relation, $baseResource);
            }
        }

        throw new \BadMethodCallException('Unknown method "' . $method . '" called on ' . static::class . '.');
    }

    /**
     * Get the correct Fractal resource object for the related resource. Return a null resource object if the
     * relationship is null.
     *
     * @param string $type
     * @param string $relation
     * @param mixed  $baseResource
     * @return ResourceAbstract
     */
    private function getFractalResource(string $type, string $relation, $baseResource)
    {
        $relatedResource = $this->getRelatedResource($relation, $baseResource);

        if ($relatedResource === null) {
            return $this->null();
        }

        $transformer = $this->makeTransformer($this->{$type . 'Includes'}[$relation]);

        return $this->$type($relatedResource, $transformer);
    }

    /**
     * Instantiate the transformer for the relation. This method may be overridden.
     *
     * @param string $class
     * @return \League\Fractal\TransformerAbstract
     */
    protected function makeTransformer(string $class)
    {
        return new $class;
    }

    /**
     * If a method is defined on the transformer with the same name as the relationship, try to get the builder from
     * the base resource and pass it to that method. If not, get the related resource as a public property of the base
     * resource.
     *
     * @param string $relation
     * @param mixed  $baseResource
     * @return mixed
     */
    private function getRelatedResource(string $relation, $baseResource)
    {
        if (! method_exists($this, $relation)) {
            return $baseResource->$relation;
        }

        $builder = $baseResource->$relation();

        return $this->$relation($builder);
    }
}
