<?php
/**
 * Created by PhpStorm.
 * User: antonio
 * Date: 01/04/14
 * Time: 11.27
 */

namespace MatryoshkaWrappersTest\Object\TestAsset;

use Matryoshka\Wrapper\Mongo\Object\AbstractMongoObject;

class MongoObject extends AbstractMongoObject
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
