<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 01/04/14
 * Time: 10.27
 */

namespace MatryoshkaWrappersTest\Object;

use Matryoshka\Wrapper\Mongo\Object\AbstractMongoObject;

class TestAssetObject extends AbstractMongoObject
{
    /**
     * @var String
     */
    public $proprietyString;

    /**
     * @var Int
     */
    public $proprietyInt;

    /**
     * @var Date
     */
    public $proprietyDate;

}
