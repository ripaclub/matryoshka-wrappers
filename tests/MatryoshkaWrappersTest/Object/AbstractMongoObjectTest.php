<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 01/04/14
 * Time: 10.27
 */

namespace MatryoshkaWrappersTest\Object;

use MatryoshkaWrappersTest\Object\TestAsset\MongoObject;

class AbstractMongoObjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MongoObject
     */
    protected $mongoObject;

    public function setUp()
    {
        $this->mongoObject = new MongoObject();
    }

    public function testGetHydratorNotPreSet()
    {
        // $this->assertInstanceOf('Zend\Stdlib\Hydrator\ObjectProperty', $this->mongoObject->getHydrator());
    }
}
