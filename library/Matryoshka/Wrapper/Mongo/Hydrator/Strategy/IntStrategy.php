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

class IntStrategy implements StrategyInterface
{

    /**
     * Ensure the value extracted is typed as int or null
     *
     * @param mixed $value The original value.
     * @return mixed Returns the value that should be extracted.
     */
    public function extract($value)
    {
        return null === $value ? null : (int) $value;
    }

    /**
     * Ensure the value extracted is typed as int or null
     *
     * @param mixed $value The original value.
     * @return mixed Returns the value that should be hydrated.
     */
    public function hydrate($value)
    {
        return $value === null ? null : (int) $value;
    }
}