<?php
	declare(strict_types=1);

	namespace Framework\Application\UtilitiesV2\Conventions;

/**
 * Class InventoryData
 *
 * Automatically created at: 2019-05-14 00:09:14
 *
 * @property array items
 */

class InventoryData extends EditableData
{

    /**
     * The syntax for requirements is as follows
     *
     *  "key" => "type"
     *
     * so for instance
     *
     *  "settings"  => "array"  : Specifies that this should be an array
     *  "filename"  => "string" : Specifies that this should be a string
     *  "admin"     => "bool"   : Specifies that this should be a bool
     *  "admin"     => "int"    : Specifies that this should be a number
     *  "dynamic"   => null     : Specifies that it is a "dynamic" field, thus may or may not have a value
     * @var array
     */
}