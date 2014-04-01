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
        $this->assertInstanceOf('Zend\Stdlib\Hydrator\ObjectProperty', $this->mongoObject->getHydrator());
    }

    public function testGetInputFilterNotPreSet()
    {
        $this->assertInstanceOf('Zend\InputFilter\InputFilter', $this->mongoObject->getInputFilter());
    }

    public function testGetIdNotPreSet()
    {
        $this->assertNull($this->mongoObject->getId());
    }

    public function testSetId()
    {
        $mongoObject = $this->mongoObject->setId("test");
        $this->assertSame($mongoObject, $this->mongoObject);
    }

    public function testIsObjectExists()
    {
        $this->assertFalse($this->mongoObject->objectExistsInDatabase());
    }

    /**
     * @expectedException Exception
     */
    public function testException__set()
    {
        $this->mongoObject->test = 4;
    }

    /**
     * @expectedException Exception
     */
    public function testException__get()
    {
        $test =  $this->mongoObject->test;
    }

    /**
     * @expectedException Exception
     */
    public function testException__unset()
    {
        unset($this->mongoObject->test);
    }

    public function testException__isset()
    {
        $this->assertFalse(isset($this->mongoObject->test));
    }
}
