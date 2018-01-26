<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 26/01/2018
 * Time: 22:31
 */

namespace Framework\Application;

use Flight;
use Framework\Application\Utilities\FileSystem;
use Framework\Exceptions\ApplicationException;

class Render
{

    /**
     * @var array
     */

    public static $stack = [];
    
    /**
     * Renders a page
     * 
     * @param $template
     * 
     * @param array $array
     */
    
    public static function view($template, $array=[] )
    {

        if ( Settings::getSetting('render_log') )
        {

            self::$stack[] = [
                'template' => $template,
                'array' => $array
            ];
        }

        Flight::render( self::getViewFolder() . DIRECTORY_SEPARATOR . $template, $array );
    }

    /**
     * Gets the current view folder
     *
     * @return mixed
     */

    private static function getViewFolder()
    {

        return Settings::getSetting('render_folder');
    }
}