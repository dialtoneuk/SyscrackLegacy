<?php

	namespace Framework\Syscrack\Game\Operations;

	/**
	 * Lewis Lancaster 2017
	 *
	 * Class ForceDownload
	 *
	 * @package Framework\Syscrack\Game\Operations
	 */

	use Framework\Application\Settings;
	use Framework\Application\Utilities\PostHelper;
	use Framework\Exceptions\SyscrackException;
	use Framework\Syscrack\Game\Bases\BaseOperation;
	use Framework\Syscrack\Game\Viruses;

	class ForceDownload extends BaseOperation
	{

		/**
		 * @var Viruses
		 */

		protected static $viruses;

		/**
		 * Download constructor.
		 */

		public function __construct()
		{

			if (isset(self::$viruses) == false)
				self::$viruses = new Viruses();

			parent::__construct(true);
		}

		/**
		 * Returns the configuration
		 *
		 * @return array
		 */

		public function configuration()
		{

			return array(
				'allowsoftware' => true,
				'allowlocal' => true,
				'requiresoftware' => false,
				'requireloggedin' => true,
				'allowpost' => false,
				'allowcustomdata' => true
			);
		}

		/**
		 * @param null $ipaddress
		 *
		 * @return string
		 */

		public function url($ipaddress = null)
		{

			return ("admin/computer/edit/" . @$this->getComputerId($ipaddress));
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
		 * @return mixed
		 */

		public function onCreation($timecompleted, $computerid, $userid, $process, array $data)
		{

			if ($this->checkData($data, ['ipaddress']) == false)
				return false;

			if ($this->checkCustomData($data, ['softwareid']) == false)
				return false;

			if (self::$computer->hasSoftware(self::$internet->getComputer($data['ipaddress'])->computerid, $data['custom']['softwareid']) == false)
				return false;

			$software = self::$software->getSoftware($data['custom']['softwareid']);

			return true;
		}

		/**
		 * @param $timecompleted
		 * @param $timestarted
		 * @param $computerid
		 * @param $userid
		 * @param $process
		 * @param array $data
		 *
		 * @return bool|mixed
		 */

		public function onCompletion($timecompleted, $timestarted, $computerid, $userid, $process, array $data)
		{

			if ($this->checkData($data, ['ipaddress']) == false)
				return false;

			if ($this->checkCustomData($data, ['softwareid']) == false)
				return false;

			if (self::$internet->ipExists($data['ipaddress']) == false)
				return false;

			if (self::$software->softwareExists($data['custom']['softwareid']) == false)
				return false;

			$software = self::$software->getSoftware($data['custom']['softwareid']);
			$new_softwareid = self::$software->copySoftware($software->softwareid, $computerid, $userid);

			self::$computer->addSoftware($computerid, $new_softwareid, $software->type);
			if (self::$computer->hasSoftware($computerid, $new_softwareid) == false)
				throw new SyscrackException();

			if (isset($data['redirect']) == false)
				return true;
			else
				return ($data['redirect']);
		}

		/**
		 * @param $ipaddress
		 * @param $userid
		 *
		 * @return array|null
		 */

		public function getCustomData($ipaddress, $userid)
		{

			if (PostHelper::hasPostData() == false)
				return null;


			if (PostHelper::checkForRequirements(['softwareid']) == false)
				return null;

			return array('softwareid' => PostHelper::getPostData('softwareid'));
		}

		/**
		 * Returns the completion time for this action
		 *
		 * @param $computerid
		 *
		 * @param $ipaddress
		 *
		 * @param null $softwareid
		 *
		 * @return int
		 */

		public function getCompletionSpeed($computerid, $ipaddress, $softwareid = null)
		{

			return null;
		}
	}