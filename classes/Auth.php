<?php

	/**
	 * Class Auth
	 */
	class Auth {
		/**
		 * @return bool
		 */
		public static function isLoggedIn()
		{
			return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'];
		}

		/**
		 *
		 * @return void
		 */
		public static function requireLogin()
		{
			if (! static::isLoggedIn()) {

				die("unauthorised");

			}
		}

		/**
		 *
		 */
		public static function login()
		{
			// prevent session fixation
			session_regenerate_id(true);

			$_SESSION['is_logged_in'] = true;

		}

		/**
		 *
		 */
		public static function logout()
		{
			// Unset all of the session variables.
			$_SESSION = array();

			// If it's desired to kill the session, also delete the session cookie.
			// Note: This will destroy the session, and not just the session data!
			if (ini_get("session.use_cookies")) {
				$params = session_get_cookie_params();

				setcookie(session_name(),
					'',
					time() - 42000,
					$params["path"],
					$params["domain"],
					$params["secure"],
					$params["httponly"]
				);
			}

			session_destroy();

		}
	}
