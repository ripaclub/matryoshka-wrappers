<?php
/**
 * Matryoshka Wrappers
 *
 * @link        https://github.com/ripaclub/matryoshka
 * @copyright   Copyright (c) 2014, Ripa Club
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace Matryoshka\Wrapper\Mongo\Criteria;

use Matryoshka\Model\Exception;
use Matryoshka\Model\Criteria\ActiveRecord\AbstractCriteria;
use Matryoshka\Model\ModelInterface;
use Zend\Stdlib\Hydrator\AbstractHydrator;

/**
 * Class ObjectGatewayCriteria
 */
class ActiveRecordCriteria extends AbstractCriteria
{

    /**
     * @var array
     */
    protected $saveOptions = array();

    /**
     * @param array $options
     * @return $this
     */
    public function setSaveOptions(array $options)
    {
        $this->saveOptions = $options;
        return $this;
    }

    /**
     * @return array
     */
    public function getSaveOptions()
    {
        return $this->saveOptions;
    }

    protected function extractId(ModelInterface $model)
    {
        if (!$model->getHydrator() instanceof AbstractHydrator) {
                throw new Exception\RuntimeException(
                    'Hydrator must be an instance of Zend\Stdlib\Hydrator\AbstractHydrator'
                );
        }

        return $model->getHydrator()->extractValue('_id', $this->getId());
    }

    protected function hydrateId(ModelInterface $model, $value, $data = null)
    {
        if (!$model->getHydrator() instanceof AbstractHydrator) {
            throw new Exception\RuntimeException(
                'Hydrator must be an instance of Zend\Stdlib\Hydrator\AbstractHydrator'
            );
        }

        $this->id = $model->getHydrator()->hydrateValue('_id', $value, $data);
        return $this->id;
    }


    /**
     * {@inheritdoc}
     */
    public function apply(ModelInterface $model)
    {
        /** @var $dataGateway \MongoCollection */
        $dataGateway = $model->getDataGateway();
        return $dataGateway->find(array('_id' => $this->extractId($model)))->limit(1);
    }

    /**
     * {@inheritdoc}
     */
    public function applyWrite(ModelInterface $model, array &$data)
    {
        if (array_key_exists('_id', $data) && $data['_id'] === null) {
            unset($data['_id']);
        }

        //FIXME: handle result
        $tmp = $data;  // passing a referenced variable to save will fail in update the content
        $model->getDataGateway()->save($tmp, $this->getSaveOptions());
        $data = $tmp;
        $this->hydrateId($model, $data['_id'], $data);
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function applyDelete(ModelInterface $model)
    {
        if (!$this->id) {
            throw new Exception\RuntimeException('An id must be set in order to delete an object');
        }

        //FIXME: handle result
        $model->getDataGateway()->remove(array('_id' => $this->id));

        return true;
    }

}