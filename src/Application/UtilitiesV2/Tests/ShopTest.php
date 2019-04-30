<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 05/08/2018
 * Time: 21:52
 */

namespace Framework\Application\UtilitiesV2\Tests;

use Framework\Application\UtilitiesV2\Shop;
use Framework\Application\UtilitiesV2\Debug;

class ShopTest extends Base
{

    /**
     * @var Shop;
     */

    protected $shopmanager;

    /**
     * @var array
     */

    protected $keys = [
        "name",
        "item",
        "description",
        "cost",
        "requirements",
        "onetime",
        "discontinued"
    ];

    /**
     * Shop constructor.
     * @throws \RuntimeException
     */

    public function __construct()
    {

        $this->shopmanager = new Shop( false );
    }

    /**
     * @return bool
     * @throws \RuntimeException
     */

    public function execute()
    {

        $inventory =  $this->shopmanager->inventory();

        foreach( $inventory as $key=>$value )
        {

            if ( Debug::isCMD() )
                Debug::echo("Checking item keys: " . $key, 4 );

            if( $this->checkKeys( $value ) == false )
                return false;

            if ( Debug::isCMD() )
                Debug::echo("Checking if referenced class [item] exists: " . $value["item"], 4 );

            if( $this->shopmanager->exist( $value["item"] ) == false )
                return false;
        }

        return parent::execute(); // TODO: Change the autogenerated stub
    }

    /**
     * @param $item
     * @return bool
     */

    private function checkKeys( $item )
    {

        $values = array_flip( $this->keys );

        foreach( $item as $key=>$value )
        {

            if( isset( $values[ $key ] ) == false )
                return false;
        }

        return true;
    }
}