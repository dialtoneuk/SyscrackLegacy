<?php
	declare(strict_types=1);

	namespace Framework\Syscrack\Login;

	/**
	 * Lewis Lancaster 2017
	 *
	 * Class Facebook
	 *
	 * @package Framework\Syscrack\Login
	 */

	use Facebook\Exceptions\FacebookSDKException;
	use Facebook\Facebook as NSA;
	use Framework\Application\Settings;


	/**
	 * Class Facebook
	 * @package Framework\Syscrack\Login
	 */
	class Facebook
	{

		/**
		 * @var NSA
		 */

		protected $facebook;

		/**
		 * Facebook constructor.
		 * @throws \Facebook\Exceptions\FacebookSDKException
		 */

		public function __construct()
		{

			$this->facebook = new NSA([
				'api_id' => Settings::setting('facebook_app_id'),
				'api_secret' => Settings::setting('facebook_app_secret'),
				'default_graph_version' => Settings::setting('facebook_app_version')
			]);
		}

		/**
		 * Gets the login URL
		 *
		 * @return string
		 */

		public function getLoginURL()
		{

			$helper = $this->facebook->getRedirectLoginHelper();

			if (empty($helper))
			{

				throw new \Error();
			}

			return $helper->getLoginUrl(Settings::setting('facebook_redirect_url'), ['email']);
		}

		/**
		 * @return \Facebook\Authentication\AccessToken|null
		 */

		public function getAccessToken()
		{

			$helper = $this->facebook->getRedirectLoginHelper();

			if (empty($helper))
			{

				throw new \Error();
			}

			try
			{
				return $helper->getAccessToken();
			} catch (FacebookSDKException $e)
			{
			}

			return null;
		}
	}