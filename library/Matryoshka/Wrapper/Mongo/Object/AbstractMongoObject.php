<?php
/**
 * Matryoshka Wrappers
 *
 * @link        https://github.com/ripaclub/matryoshka
 * @copyright   Copyright (c) 2014, Ripa Club
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace Matryoshka\Wrapper\Mongo\Object;

use Matryoshka\Wrapper\Mongo\Hydrator\Strategy\MongoIdStrategy;
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
use Zend\Stdlib\Hydrator\AbstractHydrator;
use Matryoshka\Wrapper\Mongo\Criteria\ObjectGatewayCriteria;
use Matryoshka\Model\ModelAwareInterface;
use Matryoshka\Model\ModelAwareTrait;

/**
 * Class AbstractMongoObject
 */
abstract class AbstractMongoObject implements
    HydratorAwareInterface,
    InputFilterAwareInterface,
    IdentityAwareInterface,
    ObjectGatewayInterface,
    ModelAwareInterface
{

    use HydratorAwareTrait;
    use InputFilterAwareTrait;
    use ModelAwareTrait;

    /**
     * @var string
     */
    public $_id;

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $this->inputFilter = new InputFilter();
        }

        return $this->inputFilter;
    }

    /**
     * Get Id
     * @return string
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Set Id
     * @param string $id
     * @return $this
     */
    public function setId($id)
    {
        $this->_id = $id;
        return $this;
    }

    /**
     * Object Exists In Database
     * @return boolean
     */
    public function objectExistsInDatabase()
    {
        return empty($this->_id) ? false : true;
    }

    /**
     * Save
     */
    public function save()
    {
        $criteria = new ObjectGatewayCriteria();
        $this->getModel()->save($criteria, $this);
    }

    /**
     * Delete
     * @return void
     * @throws \Exception
     */
    public function delete()
    {
        if (!$this->objectExistsInDatabase()) {
            throw new \Exception("The asset must exists in database to be deleted");
        }

        if (!$this->getHydrator() instanceof AbstractHydrator) {
            $message = <<<MESSAGE
The hydrator must be set and must be an instance of Zend\Stdlib\Hydrator\AbstractHydrator in order to work with delete()
MESSAGE;
            throw new \Exception($message);
        }

        $criteria = new ObjectGatewayCriteria();
        $criteria->setId($this->getHydrator()->extractValue('_id', $this->_id, $this));

        $this->getModel()->delete($criteria);
    }


    /**
     * Get
     * @param $name
     * @throws \InvalidArgumentException
     * @return void
     */
    public function __get($name)
    {
        throw new \InvalidArgumentException('Not a valid field in this object: ' . $name);
    }

    /**
     * Set
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
     * Isset
     * @param string $name
     * @return bool
     */
    public function __isset($name)
    {
        return false;
    }

    /**
     * Unset
     * @param string $name
     * @throws \InvalidArgumentException
     * @return void
     */
    public function __unset($name)
    {
        throw new \InvalidArgumentException('Not a valid field in this object: ' . $name);
    }
}
