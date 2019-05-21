<?php
namespace Framework\Application\UtilitiesV2\Scripts;

/**
 * Class Reload
 *
 * Automatically created at: 2019-05-15 02:15:24
 */

use Framework\Application\UtilitiesV2\Container;
use Framework\Application\Settings;
use Framework\Application\UtilitiesV2\Debug;

class Reload extends Base
{

    /**
     * The logic of your script goes in this function.
     *
     * @param $arguments
     * @return bool
     */

    public function execute($arguments)
    {

    	Debug::echo("\nReloading instance...");
	    Debug::echo(">>>---[END OF INSTANCE]--------------------[Terminated: " . date("j F Y c", time() ) . "]---<<<\n");
	    Container::get('scripts')->terminal( "php -f execute.php");
	    exit;
    }

    /**
     * The help index can either be a string or an array containing a set of strings. You can only put strings in
     * there.
     *
     * @return array
     */

    public function help()
    {
        return([
            "arguments" => $this->requiredArguments(),
            "help" => "Hello World"
        ]);
    }

    /**
     * Example:
     *  [
     *      "file"
     *      "name"
     *  ]
     *
     *  View from the console:
     *      reload file=myfile.php name=no_space
     *
     * @return array|null
     */

    public function requiredArguments()
    {

        return parent::requiredArguments();
    }
}