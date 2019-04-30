<?php
/**
 * Created by PhpStorm.
 * User: lewis
 * Date: 11/08/2018
 * Time: 19:26
 */

namespace Framework\Application\UtilitiesV2\AutoExecs;


use Framework\Application\UtilitiesV2\User;

use Framework\Application\UtilitiesV2\Group as GroupManager;
use Framework\Application\UtilitiesV2\Debug;

class Group extends Base
{

    /**
     * @var GroupManager
     */

    protected $group;

    /**
     * @var User
     */

    protected $user;

    /**
     * Group constructor.
     * @throws \RuntimeException
     */

    public function __construct()
    {

        $this->group = new GroupManager();
        $this->user = new User();

        parent::__construct();
    }

    /**
     * @param array $data
     * @return mixed
     * @throws \RuntimeException
     */

    public function execute(array $data)
    {

        if( isset( $data["userid"] ) == false )
            throw new \RuntimeException("Expecting userid");


        if( isset( $data["group"] ) == false )
            throw new \RuntimeException("Expecting group");

        if( $this->group->exist( $data["group"] ) == false )
            throw new \RuntimeException("Group does not exist: " . $data["group"] );


        $this->user->update( $data["userid"], ["group" => $data["group"] ] );
        Debug::message("Group changed");

        return parent::execute($data); // TODO: Change the autogenerated stub
    }
}