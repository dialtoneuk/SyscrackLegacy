<?php
	/**
	 * Created by PhpStorm.
	 * User: lewis
	 * Date: 06/08/2018
	 * Time: 15:02
	 */

	namespace Framework\Application\UtilitiesV2\Scripts;

	use Framework\Application\UtilitiesV2\AutoExec as AutoExecManager;
	use Framework\Application\UtilitiesV2\Container;
	use Framework\Application\UtilitiesV2\Debug;

	class AutoExec extends Base
	{

		/**
		 * @var AutoExecManager
		 */

		protected $autoexecmanager;

		/**
		 * AutoExec constructor.
		 * @throws \Error
		 */

		public function __construct()
		{

			$this->autoexecmanager = new AutoExecManager(false);
		}

		/**
		 * @param $arguments
		 *
		 * @return bool
		 * @throws \Error
		 */

		public function execute($arguments)
		{

			if (Container::exist("application") == false)
				$this->initDatabase();

			$this->autoexecmanager->create();

			if ($this->autoexecmanager->exist($arguments["script"]) == false)
				throw new \Error("Script does not exist: " . $arguments["script"]);

			if (Debug::isCMD())
				Debug::echo("Executing autoexec script: " . $arguments["script"], 5);

			if ($arguments["arguments"] == "false" || $arguments["arguments"] == "f" || $arguments["arguments"] == null)
				$this->autoexecmanager->execute($arguments["script"]);
			else
			{

				$data = $this->parse($arguments["arguments"]);
				$this->autoexecmanager->execute($arguments["script"], $data);
			}

			if (Debug::isCMD())
				Debug::echo("Finished: " . $arguments["script"], 5);

			return parent::execute($arguments); // TODO: Change the autogenerated stub
		}

		/**
		 * @return array|null
		 */

		public function requiredArguments()
		{

			return ([
				"script",
				"arguments"
			]);
		}
	}