<?php
/**
 * Matryoshka Wrappers
 *
 * @link        https://github.com/ripaclub/matryoshka
 * @copyright   Copyright (c) 2014, Ripa Club
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace Matryoshka\Wrapper\Mongo\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;

/**
 * Class MongoIdStrategy
 */
class MongoIdStrategy implements StrategyInterface
{
    /**
     * Ensure the value extracted is typed as \MongoId or null
     * @param mixed $value The original value.
     * @return null|\MongoId Returns the value that should be extracted.
     */
    public function extract($value)
    {
        return null === $value ? null : new \MongoId($value);
    }

    /**
     * Ensure the value extracted is typed as string or null
     * @param mixed $value The original value.
     * @return null|string Returns the value that should be hydrated.
     */
    public function hydrate($value)
    {
        return $value === null ? null : (string)$value;
    }
}
