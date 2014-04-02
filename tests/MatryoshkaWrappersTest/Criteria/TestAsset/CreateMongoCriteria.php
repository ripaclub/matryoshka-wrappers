<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 02/04/14
 * Time: 12.18
 */

namespace MatryoshkaWrappersTest\Criteria\TestAsset;

use Matryoshka\Model\Criteria\WritableCriteriaInterface;
use Matryoshka\Model\ModelInterface;

class CreateMongoCriteria implements WritableCriteriaInterface
{
    /**
     * @param ModelInterface $model
     * @param array $data
     * @return array|bool
     */
    public function applyWrite(ModelInterface $model, array &$data)
    {
        unset($data['_id']);
        /* @var $dataGatewayMongo \MongoCollection */
        $dataGatewayMongo = $model->getDataGateway();
        return $dataGatewayMongo->save($data);
    }

}