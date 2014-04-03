<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 03/04/14
 * Time: 10.40
 */

namespace MatryoshkaWrappersTest\Integration\Service;

use MatryoshkaWrappersTest\Criteria\TestAsset\CreateMongoCriteria;
use MatryoshkaWrappersTest\Criteria\TestAsset\DeleteMongoCriteria;
use MatryoshkaWrappersTest\Criteria\TestAsset\FindMongoCriteria;
use MatryoshkaWrappersTest\Object\TestAsset\MongoObject;
use Zend\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

class MongoDbTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

    /**
     * @var MongoObject
     */
    protected $obj;

    public function setUp()
    {
        $config = array(
            'mongodb' => array(
                'MongoDb\Mangione' => array(
                    'database' => 'test',
                ),
            ),
            'mongocollection' => array(
                'MongoDataGateway\User' => array(
                    'database'   => 'MongoDb\Mangione',
                    'collection' => 'userMatrioska'
                ),
                'MongoDataGateway\Restaurant' => array(
                    'database'   => 'MongoDb\Mangione',
                    'collection' => 'restaurantMatrioska'
                ),
            ),
            'model' => array(
                'ServiceModelUser' => array(
                    'datagateway' => 'MongoDataGateway\User',
                    'resultset'   => 'Matryoshka\Model\ResultSet\HydratingResultSet',
                    'object'      => 'ArrayObject',
                    'hydrator'    => 'Zend\Stdlib\Hydrator\ArraySerializable',
                    'type'        => 'MatryoshkaTest\Model\Service\TestAsset\MyModel',
                ),
            ),
        );


        $sm = $this->serviceManager = new ServiceManager\ServiceManager(
            new ServiceManagerConfig(array(
                'abstract_factories' => array(
                    'Matryoshka\Model\Service\ModelAbstractServiceFactory',
                    'Matryoshka\Wrapper\Mongo\Service\MongoDbAbstractServiceFactory',
                    'Matryoshka\Wrapper\Mongo\Service\MongoCollectionAbstractServiceFactory',
                )
            ))
        );

        $sm->setService('Config', $config);
        $sm->setService('MatryoshkaTest\Model\Service\TestAsset\FakeDataGateway', new \MatryoshkaTest\Model\Service\TestAsset\FakeDataGateway);
        $sm->setService('Matryoshka\Model\ResultSet\ArrayObjectResultSet', new \Matryoshka\Model\ResultSet\ArrayObjectResultSet);
        $sm->setService('Matryoshka\Model\ResultSet\HydratingResultSet', new \Matryoshka\Model\ResultSet\HydratingResultSet);
        $sm->setService('Zend\Stdlib\Hydrator\ArraySerializable', new \Zend\Stdlib\Hydrator\ArraySerializable);
        $sm->setService('ArrayObject', new \ArrayObject);


        $this->obj       = new MongoObject();
        $this->obj->name = "testMatrioska";
        $this->obj->age  = "8";

    }

    public function testIntegrationMongoDbDelete()
    {
        $criteria  = new DeleteMongoCriteria();

        /* @var $serviceUser \Matryoshka\Model\Model */
        $serviceUser = $this->serviceManager->get('ServiceModelUser');
        $result = $serviceUser->delete($criteria);

        $this->assertTrue($result);
    }

    /**
     * @depends testIntegrationMongoDbDelete
     */
    public function testIntegrationMongoDbFindEmpty()
    {
        $criteria  = new FindMongoCriteria();

        /* @var $serviceUser \Matryoshka\Model\Model */
        $serviceUser = $this->serviceManager->get('ServiceModelUser');
        $result = $serviceUser->find($criteria);

        $this->assertEmpty($result->toArray());
    }

    /**
     * @depends testIntegrationMongoDbDelete
     */
    public function testIntegrationMongoDbInsert()
    {
        $criteria  = new CreateMongoCriteria();

        /* @var $serviceUser \Matryoshka\Model\Model */
        $serviceUser = $this->serviceManager->get('ServiceModelUser');
        $result = $serviceUser->save($criteria, $this->obj);
        $this->assertTrue($result);
    }

    /**
     * @depends testIntegrationMongoDbInsert
     */
    public function testIntegrationMongoDbFind()
    {
        $criteria  = new FindMongoCriteria();

        /* @var $serviceUser \Matryoshka\Model\Model */
        $serviceUser = $this->serviceManager->get('ServiceModelUser');
        $result = $serviceUser->find($criteria);

        $this->assertNotEmpty($result->toArray());
    }
}
