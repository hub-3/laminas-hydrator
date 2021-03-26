<?php

/**
 * @see       https://github.com/laminas/laminas-hydrator for the canonical source repository
 * @copyright https://github.com/laminas/laminas-hydrator/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-hydrator/blob/master/LICENSE.md New BSD License
 */

namespace Laminas\Hydrator\NamingStrategy;

use Laminas\Hydrator\Exception\InvalidArgumentException;

class MapNamingStrategy implements NamingStrategyInterface
{
    /**
     * Map for hydrate name conversion.
     *
     * @var array
     */
    protected $mapping = [];

    /**
     * Reversed map for extract name conversion.
     *
     * @var array
     */
    protected $reverse = [];

    /**
     * Initialize.
     *
     * @param array $mapping Map for name conversion on hydration
     * @param array $reverse Reverse map for name conversion on extraction
     */
    public function __construct(array $mapping, array $reverse = null)
    {
        $this->mapping = $mapping;
        $this->reverse = $reverse ?: $this->flipMapping($mapping);
    }

    /**
     * Safelly flip mapping array.
     *
     * @param  array                    $array Array to flip
     * @return array                    Flipped array
     * @throws InvalidArgumentException
     */
    protected function flipMapping(array $array)
    {
        array_walk($array, function ($value) {
            if (!is_string($value) && !is_int($value)) {
                throw new InvalidArgumentException('Mapping array can\'t be flipped because of invalid value');
            }
        });

        return array_flip($array);
    }

    /**
     * {@inheritDoc}
     */
    public function extract($name) : string
    {
        return $this->extractionMap[$name] ?? $name;
    }

    /**
     * {@inheritDoc}
     */
    public function hydrate($name) : string
    {
        return $this->hydrationMap[$name] ?? $name;
    }
}
