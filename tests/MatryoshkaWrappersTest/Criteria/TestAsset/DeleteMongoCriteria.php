<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 02/04/14
 * Time: 12.18
 */

namespace MatryoshkaWrappersTest\Criteria\TestAsset;

use Matryoshka\Model\Criteria\DeletableCriteriaInterface;
use Matryoshka\Model\ModelInterface;

class DeleteMongoCriteria implements DeletableCriteriaInterface
{
    /**
     * @param ModelInterface $model
     * @return mixed
     */
    public function applyDelete(ModelInterface $model)
    {
        /* @var $dataGatewayMongo \MongoCollection */
        $dataGatewayMongo = $model->getDataGateway();
        return $dataGatewayMongo->remove(array());
    }
}
