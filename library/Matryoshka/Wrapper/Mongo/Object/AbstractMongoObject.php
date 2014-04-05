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
use Zend\Stdlib\Hydrator\HydratorAwareTrait;
use Zend\InputFilter\InputFilterAwareTrait;
use Matryoshka\Model\DataGatewayAwareTrait;
use Matryoshka\Model\DataGatewayAwareInterface;
use Zend\Stdlib\Hydrator\ObjectProperty;
use Zend\InputFilter\InputFilter;
use Zend\Stdlib\Hydrator\AbstractHydrator;
use Matryoshka\Model\ModelAwareInterface;
use Matryoshka\Model\ModelAwareTrait;
use Matryoshka\Model\Object\ActiveRecordInterface;
use Matryoshka\Wrapper\Mongo\Criteria\ActiveRecordCriteria;
use Matryoshka\Model\AbstractModel;
use Matryoshka\Model\Exception;
use Matryoshka\Model\ModelInterface;

/**
 * Class AbstractMongoObject
 */
abstract class AbstractMongoObject implements
    HydratorAwareInterface,
    InputFilterAwareInterface,
    ModelAwareInterface,
    ActiveRecordInterface
{

    use HydratorAwareTrait;
    use InputFilterAwareTrait;
    use ModelAwareTrait;

    /**
     * @var string
     */
    public $_id;

    /**
     * Set Model
     * @param ModelInterface $model
     * @return $this
     */
    public function setModel(ModelInterface $model)
    {
        if (!$model instanceof AbstractModel) {
            throw new Exception\InvalidArgumentException(
                'AbstractModel required in order to work with ActiveRecord'
            );
        }
        $this->model = $model;
        return $this;
    }

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
        $criteria = new ActiveRecordCriteria();
        return $this->getModel()->save($criteria, $this);
    }

    /**
     * Delete
     * @return void
     * @throws Exception\RuntimeException
     */
    public function delete()
    {
        if (!$this->objectExistsInDatabase()) {
            throw new Exception\RuntimeException("The asset must exists in database to be deleted");
        }

        $criteria = new ActiveRecordCriteria();
        $criteria->setId($this->_id);
        return $this->getModel()->delete($criteria);
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
