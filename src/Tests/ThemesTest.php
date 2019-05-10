<?php
	/**
	 * Created by PhpStorm.
	 * User: newsy
	 * Date: 01/05/2019
	 * Time: 15:14
	 */

	namespace Framework\Tests;

	use Framework\Syscrack\Game\Themes;

	class ThemesTest extends BaseTestCase
	{

		/**
		 * @var Themes
		 */

		protected static $themes;
		protected static $theme = 'bootstrap4';

		public static function setUpBeforeClass(): void
		{

			self::$themes = new Themes(false);
			parent::setUpBeforeClass(); // TODO: Change the autogenerated stub
		}

		public function testCurrentTheme()
		{

			$this->assertNotEmpty(self::$themes->currentTheme());
		}

		public function testRequiresMVC()
		{

			self::$themes->getThemes();
			$this->assertTrue(self::$themes->requiresMVC(self::$theme));
		}

		public function testGather()
		{

			$folders = self::$themes->getFolders();

			$this->assertNotEmpty($folders);
			$this->assertNotEmpty(self::$themes->gather($folders));
		}

		public function testGetTheme()
		{

			$themes = self::$themes->getThemes();
			$this->assertNotEmpty(self::$themes->getTheme(self::$theme));
		}

		public function testMvcOutput()
		{

			$this->assertIsBool(self::$themes->mvcOutput());
		}

		public function testGetData()
		{

			self::$themes->getThemes();
			$this->assertNotEmpty(self::$themes->getData(self::$theme));
		}

		public function testGetThemes()
		{

			$result = self::$themes->getThemes();
			$this->assertNotEmpty($result);
		}

		public function testThemeExists()
		{

			self::$themes->getThemes();
			$this->assertTrue(self::$themes->themeExists(self::$theme));
		}

		public function testGetFolders()
		{

			$this->assertNotEmpty(self::$themes->getFolders());
		}
	}
