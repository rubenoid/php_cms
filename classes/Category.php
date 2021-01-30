<?php

	/**
	 * Class Category
	 */
	class Category
	{
		/**
		 * @param $conn
		 * @return mixed
		 */
		public static function getAll($conn)
		{
			$sql = "SELECT *
							FROM category
							ORDER BY name;";

			$results = $conn->query($sql);

			return $results->fetchAll(PDO::FETCH_ASSOC);

		}

	}