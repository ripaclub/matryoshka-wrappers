<?php
/**
 * Matryoshka Wrappers
 *
 * @link        https://github.com/ripaclub/matryoshka
 * @copyright   Copyright (c) 2014, Ripa Club
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace Matryoshka\Wrapper\Mongo\Object;

use Zend\InputFilter\InputFilterAwareInterface;
use Zend\Stdlib\Hydrator\HydratorAwareInterface;
use Matryoshka\Model\Object\IdentityAwareInterface;
use Matryoshka\Model\Object\ObjectGatewayInterface;
use Zend\Stdlib\Hydrator\HydratorAwareTrait;
use Zend\InputFilter\InputFilterAwareTrait;
use Matryoshka\Model\DataGatewayAwareTrait;
use Matryoshka\Model\DataGatewayAwareInterface;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\InputFilter\InputFilter;
use Matryoshka\Wrapper\Mongo\Hydrator\MongoIdStrategy;
use Zend\Stdlib\Hydrator\AbstractHydrator;



/**
 * Class AbstractMongoObject
 */
abstract class AbstractMongoObject implements
    HydratorAwareInterface,
    InputFilterAwareInterface,
    IdentityAwareInterface,
    DataGatewayAwareInterface,
    ObjectGatewayInterface
{

    use HydratorAwareTrait;
    use InputFilterAwareTrait;
    use DataGatewayAwareTrait;

    /**
     * @var string
     */
    public $_id;

    /**
     * {@inheritDoc}
     */
    public function getHydrator()
    {
        if (!$this->hydrator) {
            $this->hydrator = new ObjectProperty();
            $this->hydrator->addStrategy('_id', new MongoIdStrategy());
        }

        return $this->hydrator;
    }

    /**
     * {@inheritDoc}
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->inputFilter = new InputFilter();
        }

        return $this->inputFilter;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    /**
     * @return boolean
     */
    public function objectExistsInDatabase()
    {
        return empty($this->_id) ? false : true;
    }

    /**
     * @return void
     */
    public function save()
    {
        $set = $this->getHydrator()->extract($this);

        if (array_key_exists('_id', $set) && $set['_id'] === null) {
            unset($set['_id']);
        }

        $this->getDataGateway()->save($set);

        $this->getHydrator()->hydrate($set, $this);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function delete()
    {
        if (!$this->objectExistsInDatabase()) {
            throw new \Exception("The asset must exists in database to be deleted");
        }

        if (!$this->getHydrator() instanceof AbstractHydrator) {
            throw new \Exception("The hydrator must be set and must be an instance of Zend\Stdlib\Hydrator\AbstractHydrator in order to work with delete()");
        }

        $id = $this->getHydrator()->extractValue('_id', $this->_id, $this);
        $this->getDataGateway()->remove(array(
            '_id' => $id
        ));
    }


    /**
     * @param $name
     * @throws \InvalidArgumentException
     * @return void
     */
    public function __get($name)
    {
        throw new \InvalidArgumentException('Not a valid field in this object: ' . $name);
    }

    /**
     * @param string $name
     * @param mixed $value
     * @throws \InvalidArgumentException
     * @return void
     */
    public function __set($name, $value)
    {
        throw new \InvalidArgumentException('Not a valid field in this object: ' . $name);
    }

    /**
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return false;
    }

    /**
     * @param string $name
     * @throws \InvalidArgumentException
     * @return void
     */
    public function __unset($name)
    {
        throw new \InvalidArgumentException('Not a valid field in this object: ' . $name);
    }
}