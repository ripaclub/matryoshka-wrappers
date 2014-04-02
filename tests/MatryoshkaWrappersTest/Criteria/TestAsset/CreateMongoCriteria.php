<?php

namespace MatryoshkaWrappersTest\Criteria\TestAsset;

use Matryoshka\Model\Criteria\WritableCriteriaInterface;
use Matryoshka\Model\ModelInterface;

/**
 * Class CreateMongoCriteria
 */
class CreateMongoCriteria implements WritableCriteriaInterface
{
    /**
     * {@inheritdoc}
     */
    public function applyWrite(ModelInterface $model, array &$data)
    {
        unset($data['_id']);
        /* @var $dataGatewayMongo \MongoCollection */
        $dataGatewayMongo = $model->getDataGateway();
        return $dataGatewayMongo->save($data);
    }
}


