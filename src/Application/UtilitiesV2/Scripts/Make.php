<?php

	namespace Framework\Application\UtilitiesV2\Scripts;

	/**
	 * Created by PhpStorm.
	 * User: lewis
	 * Date: 25/08/2018
	 * Time: 17:15
	 */

	use Framework\Application\UtilitiesV2\Debug;
	use Framework\Application\UtilitiesV2\Makers;
	use Framework\Application\UtilitiesV2\TokenReader;
	use Framework\Application\Settings;

	class Make extends Base
	{

		/**
		 * @var Makers
		 */

		protected $makers;

		/**
		 * @param $arguments
		 *
		 * @return bool
		 * @throws \Exception
		 */

		public function execute($arguments)
		{

			$this->makers = new Makers();

			$keys = array_keys($arguments);

			if (isset($keys[0]) == false)
				if (isset($arguments["make"]))
					$class_name = $arguments["make"];
				else
					throw new \Error("please include a class name");
			else
				$class_name = $keys[0];

			array_shift($arguments);

			if ($this->makers->exist($class_name) == false)
				throw new \Error("script does not exist: " . $class_name);

			$required = $this->makers->getRequiredTokens($class_name);

			if (empty($required) == false)
			{

				if (isset($arguments["arguments"]) == false)
				{

					$keys = array_keys($arguments);

					if (isset($keys[0]) == false)
						throw new \Error("arguments not present");
					else
					{

						if ($keys[0] == $class_name)
							array_shift($keys[0]);

						foreach ($required as $key => $item)
							if (isset($keys[$key]))
								$arguments[$item] = $keys[$key];
							else
							{

								if ($item == "namespace")
									$arguments[$item] = $this->getNamespace($class_name);

								if ($item == "classname")
									$arguments[$item] = "MyClass";
							}
					}
				}
				else
					$arguments = array_merge($arguments, $this->parse($arguments));

				$tokens = TokenReader::dataInstance([
					"values" => $arguments
				]);
			}
			else
				$tokens = TokenReader::dataInstance([
					null
				]);

			if (isset($arguments["path"]) == false)
				$path = $this->getPath($class_name);
			else
				$path = $this->getPath($class_name);

			$path = $path . $arguments["classname"] . ".php";

			if (file_exists($path))
				throw new \Error("file exists! unsafe to make class.");

			try
			{

				$result = $this->makers->process($tokens, ucfirst( $class_name ), $path);

				if (empty($result) || $result == null)
					throw new \Exception("object passed was null but file could have still been made");

				Debug::echo("\n[SUCCESS!] File created! " . $result->path . "\n");
			} catch (\Exception $e)
			{

				Debug::echo("[FAILED] Failed to create file!");
				throw $e;
			}

			return parent::execute($arguments); // TODO: Change the autogenerated stub
		}

		/**
		 * @param $class_name
		 *
		 * @return mixed|string
		 */

		public function getNamespace($class_name)
		{

			$array = [
				"controller" => MVC_NAMESPACE . "Controllers",
				"model" => MVC_NAMESPACE . "Models",
				"view" => MVC_NAMESPACE . "Views",
				"script" => SYSCRACK_NAMESPACE_ROOT . "Application\\UtilitiesV2\\Scripts",
				"convention" => SYSCRACK_NAMESPACE_ROOT . "Application\\UtilitiesV2\\Conventions",
				"page" => SYSCRACK_NAMESPACE_ROOT . "Views\\Pages",
			];

			if (isset($array[strtolower($class_name)]) == false)
				return (SYSCRACK_NAMESPACE_ROOT . "Application\\");
			else
				return ($array[strtolower($class_name)]);
		}

		/**
		 * @param $class_name
		 *
		 * @return mixed|string
		 */

		public function getPath($class_name)
		{

			$array = [
				"controller" => MVC_ROOT . MVC_NAMESPACE_CONTROLLERS . DIRECTORY_SEPARATOR,
				"model" => MVC_ROOT . MVC_NAMESPACE_MODELS . DIRECTORY_SEPARATOR,
				"view" => MVC_ROOT . MVC_NAMESPACE_VIEWS . DIRECTORY_SEPARATOR,
				"convention" => "src/Application/UtilitiesV2/Conventions/",
				"script" => SCRIPTS_ROOT,
				"page" => Settings::setting('controller_page_folder')
			];

			if (isset($array[strtolower($class_name)]) == false)
				return ("src/Application/");
			else
				return ($array[strtolower($class_name)]);
		}

		/**
		 * @return array
		 */

		public function help()
		{

			return ([
				"arguments" => [
					"[type] Refers to what kind of thing to make. For instance, a controller, model, or view. Not case sensitive.",
					"[classname] The name of the class (Case Sensitive).",
					"[namespace:optional] Specify a custom namespace.",
					"[path:optional] Specify a custom output path."
				],
				"help" => [
					"Creates class based based off of a template. Useful when developing. Supports a wide range of class types",
					"such as Computers, Softwares and Scripts. The arguments for this script are worked out implicity by the",
					"order they are typed so be sure to follow the order of which the arguments appear above or implicitly ",
					"specifcy the index using normal console syntax."
				]
			]);
		}

		/**
		 * @return array|null
		 */

		public function requiredArguments()
		{

			return ([]);
		}
	}