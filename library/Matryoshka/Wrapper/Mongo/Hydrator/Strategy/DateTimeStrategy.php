<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 18/04/14
 * Time: 11.55
 */

namespace Matryoshka\Wrapper\Mongo\Hydrator\Strategy;

use Zend\Stdlib\Hydrator\Strategy\DefaultStrategy;
use DateTime;

class DateTimeStrategy extends DefaultStrategy
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
     * {@inheritdoc}
     *
     * Convert a string value into a DateTime object
     */
    public function hydrate($value)
    {
        if (is_string($value)) {

            $value = new DateTime($value);
        }

        return $value;
    }

    public function extract($value)
    {
        if ($value instanceof DateTime) {

            $value = $value->format($this->getFormat());
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
