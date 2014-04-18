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
     * @var string
     */
    protected $format;

    public function __construct($format = null)
    {
        $this->setFormat(DateTime::ISO8601);
        if($format !== null) {
            $this->setFormat($format);
        }
    }

    /**
     * @param mixed $value
     * @return DateTime|mixed
     */
    public function extract($value)
    {
        if ($value instanceof DateTime) {
            $value = new MongoDate($value->format('U'));
        }
        else {

            $value = null;
        }
        return $value;
    }

    /**
     * @param mixed $value
     * @return mixed|MongoDate
     */
    public function hydrate($value)
    {
        if ($value instanceof MongoDate) {

            $value = new DateTime(date($this->getFormat(), $value->sec));
        }
        else {

            $value = null;
        }
        return $value;
    }

    /**
     * @param string $format
     */
    public function setFormat($format)
    {
        $this->format = $format;
    }

    /**
     * @return string
     */
    public function getFormat()
    {
        return $this->format;
    }


} 