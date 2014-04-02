<?php

namespace MatryoshkaWrappersTest\Criteria\TestAsset;

use Matryoshka\Model\Criteria\DeletableCriteriaInterface;
use Matryoshka\Model\ModelInterface;

/**
 * Class DeleteMongoCriteria
 */
class DeleteMongoCriteria implements DeletableCriteriaInterface
{
    /**
     * {@inheritdoc}
     */
    public function applyDelete(ModelInterface $model)
    {
        /* @var $dataGatewayMongo \MongoCollection */
        $dataGatewayMongo = $model->getDataGateway();
        return $dataGatewayMongo->remove(array());
    }
}

