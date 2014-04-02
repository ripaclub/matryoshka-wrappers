<?php
/**
 * Matryoshka Wrappers
 *
 * @link        https://github.com/ripaclub/matryoshka
 * @copyright   Copyright (c) 2014, Ripa Club
 * @license     http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace Matryoshka\Wrapper\Mongo\Paginator;

use Zend\Paginator\Adapter\AdapterInterface;
use Matryoshka\Model\ResultSet\HydratingResultSet;

class MongoPaginatorAdapter implements AdapterInterface
{

    protected $cursor;
    protected $resultSet;

    public function __construct(HydratingResultSet $resultSet)
    {
        $this->resultSet = $resultSet;
        $this->cursor    = $resultSet->getDataSource();
    }

    public function count()
    {
        $this->cursor->limit(null)->skip(null);
        return $this->cursor->count();
    }

    public function getItems($offset, $itemCountPerPage)
    {
        $this->cursor->skip($offset);
        $this->cursor->limit($itemCountPerPage);
        $this->resultSet->initialize($this->cursor);
        return $this->resultSet->toArray();
    }

}