<?php
	declare(strict_types=1);

	namespace Framework\Syscrack\Game\Operations;

	/**
	 * Lewis Lancaster 2017
	 *
	 * Class ForceLogin
	 *
	 * @package Framework\Syscrack\Game\Operations
	 */

	use Framework\Syscrack\Game\Bases\BaseOperation;


	/**
	 * Class ForceLogin
	 * @package Framework\Syscrack\Game\Operations
	 */
	class ForceLogin extends BaseOperation
	{

		/**
		 * The configuration of this operation
		 */

		public function configuration()
		{

			return [
				'allowsoftware' => false,
				'allowlocal' => false
			];
		}

		/**
		 * @param null $ipaddress
		 *
		 * @return string
		 */
		public function url($ipaddress = null)
		{

			return ("game/internet/" . $ipaddress);
		}

		/**
		 * Called when this process request is created
		 *
		 * @param $timecompleted
		 *
		 * @param $computerid
		 *
		 * @param $userid
		 *
		 * @param $process
		 *
		 * @param array $data
		 *
		 * @return bool
		 */

		public function onCreation($timecompleted, $computerid, $userid, $process, array $data)
		{

			if (self::$user->isAdmin($userid) == false)
				return false;

			return true;
		}

		/**
		 * @param $timecompleted
		 *
		 * @param $timestarted
		 *
		 * @param $computerid
		 *
		 * @param $userid
		 *
		 * @param $process
		 *
		 * @param array $data
		 *
		 * @return bool|null|string
		 */

		public function onCompletion($timecompleted, $timestarted, $computerid, $userid, $process, array $data)
		{

			if (self::$user->isAdmin($userid) == false)
				return false;

			$computer = self::$internet->computer($data['ipaddress']);

			if (self::$computer->hasComputerClass($computer->type) == false)
				return false;

			self::$computer->getComputerClass($computer->type)->onLogin($computer->computerid, $data['ipaddress']);

			if( parent::onCompletion(
					$timecompleted,
					$timestarted,
					$computerid,
					$userid,
					$process,
					$data) == false )
				return false;
			else if (isset($data['redirect']) == false)
				return true;
			else
				return ($data['redirect']);
		}

		/**
		 * Gets the time of which to complete this process
		 *
		 * @param $computerid
		 *
		 * @param $ipaddress
		 *
		 * @param $softwareid
		 *
		 * @return null
		 */

		public function getCompletionSpeed($computerid, $ipaddress, $softwareid = null)
		{

			return null;
		}

		/**
		 * Gets the custom data for this operation
		 *
		 * @param $ipaddress
		 *
		 * @param $userid
		 *
		 * @return array
		 */

		public function getCustomData($ipaddress, $userid)
		{

			return [];
		}

		/**
		 * Called upon a post request to this operation
		 *
		 * @param $data
		 *
		 * @param $ipaddress
		 *
		 * @param $userid
		 *
		 * @return bool
		 */

		public function onPost($data, $ipaddress, $userid)
		{

			return true;
		}
	}