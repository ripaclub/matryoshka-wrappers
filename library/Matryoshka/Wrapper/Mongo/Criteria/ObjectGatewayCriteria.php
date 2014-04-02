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
use Matryoshka\Model\Criteria\ObjectGateway\AbstractCriteria;
use Matryoshka\Model\ModelInterface;

/**
 * Class ObjectGatewayCriteria
 */
class ObjectGatewayCriteria extends AbstractCriteria
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


    /**
     * {@inheritdoc}
     */
    public function apply(ModelInterface $model)
    {
        /** @var $dataGateway \MongoCollection */
        $dataGateway = $model->getDataGateway();
        return $dataGateway->find(array('_id' => $this->id))->limit(1);
    }

    /**
     * {@inheritdoc}
     */
    public function applyWrite(ModelInterface $model, array &$data)
    {
        if ($this->id) {
            $data['_id'] = $this->id;
        }

        if (isset($data['_id']) && $data['_id'] === null) {
            unset($data['_id']);
        }

        //FIXME: handle result
        $model->getDataGateway()->save($data, $this->getSaveOptions());

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