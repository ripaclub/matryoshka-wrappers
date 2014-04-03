<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 02/04/14
 * Time: 12.18
 */

namespace MatryoshkaWrappersTest\Criteria\TestAsset;

use Matryoshka\Model\Criteria\AbstractCriteria;
use Matryoshka\Model\ModelInterface;

class FindMongoCriteria extends AbstractCriteria
{
    /**
     * Apply
     * @param ModelInterface $model
     * @return mixed
     */
    public function apply(ModelInterface $model)
    {
        /* @var $dataGatewayMongo \MongoCollection */
        $dataGatewayMongo = $model->getDataGateway();
        return $dataGatewayMongo->find();
    }

}
