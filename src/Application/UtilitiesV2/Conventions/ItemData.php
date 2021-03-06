<?php
	declare(strict_types=1);

	namespace Framework\Application\UtilitiesV2\Conventions;


	use Framework\Application\UtilitiesV2\Convention;

	/**
	 * Created by PhpStorm.
	 * User: lewis
	 * Date: 31/08/2018
	 * Time: 01:16
	 */

	/**
	 * Class UploadData
	 * @package Framework\Application\UtilitiesV2\Conventions
	 *
	 * @property string name
	 * @property string item
	 * @property string description
	 * @property int cost
	 * @property array requirements
	 * @property bool onetime
	 * @property bool discontinued
	 */
	class ItemData extends Convention
	{

		/**
		 * @var array
		 */

		protected $requirements = [
			'userid'        => 'int',
			'name'          => 'string',
			'icon'          => 'string',
			'description'   => 'string',
			'item'          => 'string'
		];
	}