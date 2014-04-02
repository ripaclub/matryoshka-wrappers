<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 01/04/14
 * Time: 11.54
 */

namespace MatryoshkaWrappersTest\Object\TestAsset;

use Matryoshka\Wrapper\Mongo\Hydrator\Strategy\IntStrategy;
use Matryoshka\Wrapper\Mongo\Object\AbstractMongoObject;

class MongoObject extends AbstractMongoObject
{
    /**
     * @var String
     */
    public $name;

    /**
     * @var int
     */
    public $age;

    function __construct()
    {
        $this->hydrator = parent::getHydrator();
        $this->hydrator->addStrategy('age', new IntStrategy());
    }


} 