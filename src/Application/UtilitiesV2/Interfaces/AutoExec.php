<?php
	declare(strict_types=1);
	/**
	 * Created by PhpStorm.
	 * User: lewis
	 * Date: 06/08/2018
	 * Time: 02:02
	 */

	namespace Framework\Application\UtilitiesV2\Interfaces;


	/**
	 * Interface AutoExec
	 * @package Framework\Application\UtilitiesV2\Interfaces
	 */
	interface AutoExec
	{

		/**
		 * @param array $data
		 *
		 * @return mixed
		 */

		public function execute(array $data);
	}