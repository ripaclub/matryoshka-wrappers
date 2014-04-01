<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 01/04/14
 * Time: 15.29
 */

namespace MatryoshkaWrappersTest\Service;

use Matryoshka\Wrapper\Mongo\Service\MongoCollectionAbstractServiceFactory;
use Matryoshka\Wrapper\Mongo\Service\MongoDbAbstractServiceFactory;
use Zend\ServiceManager;
use Zend\Mvc\Service\ServiceManagerConfig;

class MongoDbServiceTest  extends \PHPUnit_Framework_TestCase
{

    /**
     * @var \Zend\ServiceManager\ServiceManager
     */
    protected $serviceManager;

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
                    'collection' => 'user'
                ),
                'MongoDataGateway\Restaurant' => array(
                    'database'   => 'MongoDb\Mangione',
                    'collection' => 'restaurant'
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
                )
            ))
        );

        $sm->setService('Config', $config);
        $sm->setService('MatryoshkaTest\Model\Service\TestAsset\FakeDataGateway', new \MatryoshkaTest\Model\Service\TestAsset\FakeDataGateway);
        $sm->setService('Matryoshka\Model\ResultSet\ResultSet', new \Matryoshka\Model\ResultSet\ResultSet);
        $sm->setService('Matryoshka\Model\ResultSet\HydratingResultSet', new \Matryoshka\Model\ResultSet\HydratingResultSet);
        $sm->setService('Zend\Stdlib\Hydrator\ArraySerializable', new \Zend\Stdlib\Hydrator\ArraySerializable);
        $sm->setService('ArrayObject', new \ArrayObject);

    }

    /**
     * @return void
     */
    public function testCanCreateServiceMongoDb()
    {
        $factory = new MongoDbAbstractServiceFactory();
        $serviceLocator = $this->serviceManager;

        $this->assertFalse($factory->canCreateServiceWithName($serviceLocator, 'mongodbNotExist', 'MongoDb\NonExist'));
        $this->assertTrue($factory->canCreateServiceWithName($serviceLocator, 'mongodbMangione', 'MongoDb\Mangione'));
    }

    public function testCanCreateServiceMongoCollection()
    {
        $factory = new MongoCollectionAbstractServiceFactory();
        $serviceLocator = $this->serviceManager;

        $this->assertFalse($factory->canCreateServiceWithName($serviceLocator, 'datagatewayNotExist', 'MongoDataGateway\NotExist'));
        $this->assertTrue($factory->canCreateServiceWithName($serviceLocator, 'datagatewayUser', 'MongoDataGateway\User'));
    }
} 