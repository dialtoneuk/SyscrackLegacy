<?php

	namespace Framework\Application\UtilitiesV2\Scripts;

	/**
	 * Created by PhpStorm.
	 * User: lewis
	 * Date: 31/08/2018
	 * Time: 21:17
	 */

	use Framework\Application\UtilitiesV2\Debug as Util;
	use Framework\Application\UtilitiesV2\Format;

	class Debug extends Base
	{

		public function execute($arguments)
		{

			if (Util::isEnabled() == false)
				Util::echo("Debug is disabled, please enable debugging in order to view debug information");
			else
			{

				if (isset($arguments["verbrosity"]) == false)
				{

					$keys = array_keys($arguments);

					if (empty($keys) == false)
						$arguments["verbrosity"] = $keys[0];
					else
						$arguments["verbrosity"] = 1;
				}

				$verbrosity = $arguments["verbrosity"];

				if ($verbrosity >= 1)
				{

					Util::echo("\nPrinting debug messages\n");

					$message = Util::getMessages();

					foreach ($message as $key => $item)
						Util::echo("[" . $key . "] => " . $item["message"] . " at " . Format::timestamp($item["time"]));
				}

				if ($verbrosity >= 2)
				{

					Util::echo("\nPrinting timers\n");

					$timers = Util::getTimers();

					if (empty($timers))
						Util::echo(" ! No Timers Found ! ");
					else
					{

						foreach ($timers as $item)
							Util::echo($item["start"] . "=>" . $item["end"]);
					}
				}
			}

			return parent::execute($arguments); // TODO: Change the autogenerated stub
		}
	}