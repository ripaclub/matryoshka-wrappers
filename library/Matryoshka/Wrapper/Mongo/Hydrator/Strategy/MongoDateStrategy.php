<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 18/04/14
 * Time: 11.23
 */

namespace Matryoshka\Wrapper\Mongo\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\StrategyInterface;
use MongoDate;

class MongoDateStrategy implements StrategyInterface
{
    /**
     * @param mixed $value
     * @return DateTime|mixed
     */
    public function extract($value)
    {
        if ($value instanceof MongoDate) {

            var_dump($value->__toString());
            die();
            $value = new DateTime($value);
        }

        return $value;
    }

    /**
     * @param mixed $value
     * @return mixed|MongoDate
     */
    public function hydrate($value)
    {
        if ($value instanceof DateTime) {

            $value = new MongoDate($value->format('U'));
        }
        return $value;
    }

} 