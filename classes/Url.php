<?php

	/**
	 * Class Url
	 */
	class Url
	{

		/**
		 * @param string $path		The path to redirect to
		 *
		 * @return void
		 */
		public static function redirect($path)
		{
			if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
				$protocol = 'https';
			} else {
				$protocol = 'http';
			}

			// TODO /cms verwijderen
			header("Location: $protocol://" . $_SERVER['HTTP_HOST'] . '/cms' . $path);
			exit;
		}

	}
