<?php
	declare(strict_types=1);
	/**
	 * Created by PhpStorm.
	 * User: lewis
	 * Date: 06/08/2018
	 * Time: 01:48
	 */

	namespace Framework\Application\UtilitiesV2;


	use Framework\Application\UtilitiesV2\Interfaces\AutoExec as AutoExecInterface;
	use Framework\Application;

	/**
	 * Class AutoExec
	 * @package Framework\Application\UtilitiesV2
	 */
	class AutoExec
	{

		/**
		 * @var Constructor
		 */

		protected $constructor;

		/**
		 * @var array
		 */

		protected $scripts = [];

		/**
		 * AutoExecute constructor.
		 *
		 * @param bool $auto_create
		 *
		 * @throws \Error
		 */

		public function __construct($auto_create = true)
		{

			$this->constructor = new Constructor(Application::globals()->AUTOEXEC_ROOT, Application::globals()->AUTOEXEC_NAMESPACE);

			if ($auto_create)
				$this->create();
		}

		/**
		 * @param $script
		 * @param null $data
		 *
		 * @throws \Error
		 */

		public function execute($script, $data = null)
		{

			$classes = $this->getClasses($script);

			if ($this->checkClasses($classes) == false)
				throw new \Error("Invalid classes given. One or more does not exist: " . print_r($classes));

			Debug::message("Processing classes");
			Container::add("script", $script);

			foreach ($classes as $class)
			{

				Debug::message("Working with class: " . $class);

				$instance = $this->constructor->get($class);

				/** @var AutoExecInterface $instance */

				if ($instance instanceof AutoExecInterface == false)
					throw new \Error("Invalid class");

				Debug::message("Calling class execute function: " . $class);

				$instance->execute($data);
			}
		}

		/**
		 * @param $script
		 *
		 * @return bool
		 */

		public function exist($script)
		{

			if (isset($this->scripts[$script]) == false)
				return false;

			return true;
		}

		/**
		 * @param $class
		 *
		 * @return bool
		 */

		public function classExists($class)
		{

			if ($this->constructor->exist($class) == false)
				return false;

			return true;
		}

		/**
		 * @param $script
		 *
		 * @return mixed
		 */

		public function getClasses($script)
		{

			return ($this->scripts[$script]["classes"]);
		}

		/**
		 * @param $classes
		 *
		 * @return bool
		 */

		public function checkClasses($classes)
		{

			foreach ($classes as $class)
				if ($this->classExists($class) == false)
					return false;

			return true;
		}

		/**
		 * @throws \Error
		 */

		public function create()
		{

			$this->constructor->createAll();

			$scripts = $this->getScripts();

			foreach ($scripts as $script)
			{

				$this->scripts[$this->getFileName($script)] = json_decode(file_get_contents(SYSCRACK_ROOT . Application::globals()->AUTOEXEC_SCRIPTS_ROOT . $script), true);
			}
		}

		/**
		 * @return array
		 * @throws \Error
		 */

		public function getScripts()
		{

			$directory = new DirectoryOperator(Application::globals()->AUTOEXEC_SCRIPTS_ROOT);

			if ($directory->isEmpty())
				return [];

			return ($directory->omit($directory->search([".json"])));
		}

		/**#
		 * @param $script
		 *
		 * @return mixed
		 */

		private function getFileName($script)
		{

			return (explode(".", $script)[0]);
		}

	}