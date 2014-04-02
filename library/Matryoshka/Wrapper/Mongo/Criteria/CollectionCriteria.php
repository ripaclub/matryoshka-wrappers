<?php
/**
 * Matryoshka Wrappers
 *
 * @link        https://github.com/ripaclub/matryoshka
 * @copyright   Copyright (c) 2014, Ripa Club
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace Matryoshka\Wrapper\Mongo\Criteria;

use Matryoshka\Model\Criteria\AbstractCriteria;
use Matryoshka\Model\ModelInterface;
use Zend\Paginator\AdapterAggregateInterface;
use Matryoshka\Wrapper\Mongo\Paginator\MongoPaginatorAdapter;

class CollectionCriteria extends AbstractCriteria
{

    /**
     * @param ModelInterface $model
     * @return mixed
     */
    public function apply(ModelInterface $model)
    {
        /** @var $dataGateway \MongoCollection */
        $dataGateway = $model->getDataGateway();
        return $dataGateway->find()->limit($this->limit)->skip($this->offset);
    }

    public function getPaginatorAdapter(ModelInterface $model)
    {
        $resultSet = clone $model->getResultSetPrototype();
        $resultSet->initialize($this->apply($model));
        return new MongoPaginatorAdapter($resultSet);
    }

}