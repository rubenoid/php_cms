<?php

	/**
	 * Class Database
	 */
	class Database
	{
		/**
		 * @return PDO
		 */
		public function getConn()
		{
			$db_host = 'localhost';
			//$db_user = 'root';
			//$db_pass = '';
			//$db_name = 'cms_r';
			$db_user = 'u52148p49394_wp5';
			$db_pass = 'N,A4~e7)clreGcdm(G[16*^6';
			$db_name = 'u52148p49394_wp5';

			$dsn = 'mysql:host=' . $db_host . ';dbname=' . $db_name . ';charset=utf8';

			try {
				$db = new PDO($dsn, $db_user, $db_pass);

				// set exceptions attributes zodat je ze later kunt afvangen.
				$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

				return $db;
		} catch (PDOException $e) {
				echo $e->getMessage();
				exit;
			}
		}
	}
