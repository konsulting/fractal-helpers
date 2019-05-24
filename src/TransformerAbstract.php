<?php

namespace Rdarcy1\FractalHelpers;

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

        if (array_key_exists($relation, $this->itemIncludes)) {
            $relatedResource = $baseResource->{$relation};
            if ($relatedResource === null) {
                return $this->null();
            }

            return $this->item($relatedResource, new $this->itemIncludes[$relation]);
        }

        if (array_key_exists($relation, $this->collectionIncludes)) {
            $relatedResource = $baseResource->{$relation};
            if ($relatedResource === null) {
                return $this->null();
            }

            return $this->collection(
                $baseResource->{$relation}, new $this->collectionIncludes[$relation]);
        }

        throw new \BadMethodCallException('Unknown method "' . $method . '" called on ' . static::class . '.');
    }
}
