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
use Matryoshka\Wrapper\Mongo\Paginator\MongoPaginatorAdapter;

/**
 * Class CollectionCriteria
 */
class CollectionCriteria extends AbstractCriteria
{
    /**
     * @var array
     */
    protected $query;

    /**
     * @var array
     */
    protected $fields;


    public function __construct(array $query = null, array $fields = null)
    {
        $this->query = $query;
        $this->fields = $fields;
    }

    public function getPaginatorAdapter(ModelInterface $model)
    {
        $resultSet = clone $model->getResultSetPrototype();
        $resultSet->initialize($this->apply($model));
        return new MongoPaginatorAdapter($resultSet);
    }

    /**
     * {@inheritdoc}
     */
    public function apply(ModelInterface $model)
    {
        /** @var $dataGateway \MongoCollection */
        $dataGateway = $model->getDataGateway();
        return $cursor = $dataGateway->find($this->query, $this->fields)->limit($this->limit)->skip($this->offset);
    }

}

