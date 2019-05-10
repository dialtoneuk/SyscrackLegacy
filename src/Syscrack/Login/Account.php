<?php

	namespace Framework\Syscrack\Login;

	/**
	 * Lewis Lancaster 2016
	 *
	 * Class Account
	 *
	 * @package Framework\Syscrack\Login
	 */

	use Framework\Application\Settings;
	use Framework\Application\Utilities\Hashes;
	use Framework\Exceptions\LoginException;
	use Framework\Exceptions\SyscrackException;
	use Framework\Syscrack\User;
	use Framework\Syscrack\Verification;

	class Account
	{

		/**
		 * @var User
		 */

		protected $user;

		/**
		 * @var Verification
		 */

		protected $verification;

		/**
		 * @var LoginException
		 */

		public static $error;

		/**
		 * Account constructor.
		 */

		public function __construct()
		{

			$this->user = new User();

			$this->verification = new Verification();
		}

		/**
		 * Logs in a user
		 *
		 * @param $username
		 *
		 * @param $password
		 *
		 * @return bool
		 */

		public function loginAccount($username, $password)
		{

			try
			{

				if ($this->user->usernameExists($username) == false)
				{

					throw new LoginException('Username does not exist');
				}

				$userid = $this->user->findByUsername($username);

				if (Settings::setting('login_admins_only') == true)
				{

					if ($this->user->isAdmin($userid) == false)
					{

						throw new LoginException('Sorry, the game is currently in admin mode, please try again later');
					}
				}

				if ($this->checkPassword($userid, $password, $this->user->getSalt($userid)) == false)
				{

					throw new LoginException('Password is invalid');
				}

				if ($this->verification->isVerified($userid) == false)
				{

					throw new LoginException('Please verify your email');
				}

				return true;

			} catch (LoginException $error)
			{

				self::$error = $error;
				throw $error;
			}
		}

		/**
		 * Gets the users ID from their username
		 *
		 * @param $username
		 *
		 * @return mixed
		 */

		public function getUserID($username)
		{

			return $this->user->findByUsername($username);
		}

		/**
		 * Checks to see if a password is valid
		 *
		 * @param $userid
		 *
		 * @param $password
		 *
		 * @param $salt
		 *
		 * @return bool
		 */

		private function checkPassword($userid, $password, $salt)
		{

			if ($this->user->userExists($userid) == false)
			{

				throw new SyscrackException();
			}

			$accountpassword = $this->user->getPassword($userid);

			if (Hashes::sha1($salt, $password) !== $accountpassword)
			{

				return false;
			}

			return true;
		}
	}