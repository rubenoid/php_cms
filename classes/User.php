<?php

	/**
	 * Class User
	 */
	class User
	{
		/**
		 * @var integer
		 */
		public $id;
		/**
		 * @var string
		 */
		public $username;
		/**
		 * @var string
		 */
		public $password;

		/**
		 * @param $conn
		 * @param $username
		 * @param $password
		 * @return bool True if the credentials are correct, null otherwise
		 */
		public static function authenticate($conn, $username, $password)
		{
			$sql = "SELECT *
							FROM user
							WHERE username = :username";

			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':username', $username, PDO::PARAM_STR);

			$stmt->setFetchMode(PDO::FETCH_CLASS, 'User');

			$stmt->execute();

			if ($user = $stmt->fetch()) {
				return password_verify($password, $user->password);
				}
			}
	}
