<?php
    namespace Framework\Syscrack\Game\Computers;

    /**
     * Lewis Lancaster 2017
     *
     * Class Npc
     *
     * @package Framework\Syscrack\Game\Computer
     */

    use Framework\Application\UtilitiesV2\Conventions\ComputerData;
    use Framework\Exceptions\SyscrackException;
    use Framework\Syscrack\Game\BaseClasses\Computer as BaseClass;
    use Framework\Syscrack\Game\Metadata;
    use Framework\Syscrack\Game\Structures\Computer as Structure;

    class Npc extends BaseClass implements Structure
    {

        /**
         * Npc constructor.
         */

        public function __construct()
        {

            parent::__construct( true );
        }

        /**
         * The configuration of this computer
         *
         * @return array
         */

        public function configuration()
        {

            return array(
                'installable' => false,
                'type'        => 'npc'
            );
        }

        /**
         * What to do when this computer resets
         *
         * @param $computerid
         */

        public function onReset($computerid)
        {

            parent::onReset($computerid);
        }

        /**
         * @param $computerid
         * @param $userid
         * @param array $software
         * @param array $hardware
         * @param array $custom
         */

        public function onStartup($computerid, $userid, array $software = [], array $hardware = [], array $custom = [])
        {

            parent::onStartup($computerid, $userid, $software, $hardware, $custom );
        }

        /**
         * What to do when you login to this computer
         *
         * @param $computerid
         *
         * @param $ipaddress
         */

        public function onLogin($computerid, $ipaddress)
        {

            if( $this->internet->ipExists( $ipaddress ) == false )
                throw new SyscrackException();

            $this->internet->setCurrentConnectedAddress( $ipaddress );

            $this->log( $computerid, 'Logged in as root', $this->getCurrentComputerAddress() );
            $this->logToIP( $this->getCurrentComputerAddress(), 'Logged in as root at <' . $ipaddress . '>');
        }

        /**
         * What to do when you logout of a computer
         *
         * @param $computerid
         *
         * @param $ipaddress
         */

        public function onLogout($computerid, $ipaddress)
        {

            if( $this->internet->ipExists( $ipaddress ) == false )
                throw new SyscrackException();

            $this->internet->setCurrentConnectedAddress( null );
        }
    }