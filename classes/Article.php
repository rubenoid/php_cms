<?php

	/**
	 * Class Article
	 */
	class Article
	{
		/**
		 * @var integer
		 */
		public $id;
		/**
		 * @var string
		 */
		public $title;
		/**
		 * @var string
		 */
		public $content;
		/**
		 * @var datetime
		 */
		public $published_at;

		/**
		 * Validation errors
		 * @var array
		 */
		public $errors = [];

		/**
		 * @var
		 */
		public $image_file;

		/**
		 * @param $conn
		 * @return mixed
		 */
		public static function getAll($conn)
		{
			$sql = "SELECT *
        FROM article
        ORDER BY published_at;";

			$results = $conn->query($sql);

			return $results->fetchAll(PDO::FETCH_ASSOC);

		}

		/**
		 * @param $conn
		 * @param $limit
		 * @param $offset
		 * @return mixed
		 */
		public static function getPaggge($conn, $limit, $offset)
		{
			$sql = "SELECT a.*, category.name AS category_name
                FROM (SELECT *
                FROM article
                ORDER BY published_at
                LIMIT :limit
                OFFSET :offset) AS a
                LEFT JOIN article_category
                ON a.id = article_category.article_id
                LEFT JOIN category
                ON article_category.category_id = category.id";

			$stmt = $conn->prepare($sql);

			$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
			$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

			$stmt->execute();

			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$articles =[];

			$previous_id = null;

			foreach ($results as $row) {

				$article_id = $row['id'];

				if ($article_id != $previous_id) {
					$row['category_name'] = [];

					$articles[$article_id] = $row;
				}

				$articles[$article_id]['category_names'][] = $row['category_name'];

				$previous_id = $article_id;
			}

			return $articles;
		}

		/**
		 * Get a page of articles
		 *
		 * @param object $conn Connection to the database
		 * @param integer $limit Number of records to return
		 * @param integer $offset Number of records to skip
		 *
		 * @return array An associative array of the page of article records
		 */
		public static function getPage($conn, $limit, $offset)
		{
			$sql = "SELECT a.*, category.name AS category_name
                FROM (SELECT *
                FROM article
                ORDER BY published_at
                LIMIT :limit
                OFFSET :offset) AS a
                LEFT JOIN article_category
                ON a.id = article_category.article_id
                LEFT JOIN category
                ON article_category.category_id = category.id";

			$stmt = $conn->prepare($sql);

			$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
			$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

			$stmt->execute();

			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

			$articles = [];

			$previous_id = null;

			foreach ($results as $row) {

				$article_id = $row['id'];

				if ($article_id != $previous_id) {
					$row['category_names'] = [];

					$articles[$article_id] = $row;
				}

				$articles[$article_id]['category_names'][] = $row['category_name'];

				$previous_id = $article_id;
			}

			return $articles;
		}

		/**
		 * @param $conn
		 * @param $id
		 * @param string $columns
		 * @return mixed An object of this class, or null if not found
		 */
		public static function getByID($conn, $id, $columns = '*')
		{
			$sql = "SELECT $columns
						FROM article
						WHERE id = :id";

			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);

			// fetch zal straks een object returnen
			$stmt->setFetchMode(PDO::FETCH_CLASS, 'Article');

			if ($stmt->execute()) {
				return $stmt->fetch();
			}
		}

		/**
		 * @param $conn
		 * @param $id
		 * @return mixed
		 */
		public static function getWithCategories($conn, $id)
		{
			$sql = "SELECT article.*, category.name AS category_name
							FROM article
							LEFT JOIN article_category
							ON article.id = article_category.article_id
							LEFT JOIN category
							ON article_category.category_id = category.id
							WHERE article.id = :id";

			$stmt = $conn->prepare($sql);
			$stmt->bindValue(':id', $id, PDO::PARAM_INT);

			$stmt->execute();

			// this can return multiple records, so return an ass. array
			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		/**
		 * @param $conn
		 * @return mixed
		 */
		public function getCategories($conn)
		{
			$sql = "SELECT category.*
							FROM category
							JOIN article_category
							ON category.id = article_category.category_id
							WHERE article_id = :id";

			$stmt = $conn->prepare($sql);
			// the id of the current object
			$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

			$stmt->execute();

			return $stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		/**
		 * waarom is update unused?
		 * Update the article with its current property values
		 * Not static because it acts on an instance of an object itself
		 *
		 * @param object $conn Connection to the database
		 *
		 * @return boolean True if the update was successful, false otherwise
		 */
		public function update($conn)
		{

			if ($this->validate()) {

				$sql = "UPDATE article
									SET title = :title,
											content = :content,
											published_at = :published_at
									WHERE id = :id";
				$stmt = $conn->prepare($sql);
				$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
				$stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
				$stmt->bindValue(':content', $this->content, PDO::PARAM_STR);
				if ($this->published_at == '') {
					$stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
				} else {
					$stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
				}

				return $stmt->execute();
			} else {
				return false;
			}
		}

		public function setCategories($conn, $ids)
		{
			if ($ids) {
				$sql = "INSERT IGNORE INTO article_category (article_id, category_id)
								VALUES ";

				$values = [];

				foreach ($ids as $id) {
					$values[] = "({$this->id}, ?)";
				}

				$sql .= implode (", ", $values);

				$stmt = $conn->prepare($sql);

				foreach ($ids as $i => $id) {
					$stmt->bindValue($i + 1, $id, PDO::PARAM_INT);
				}
				$stmt->execute();
			}

			$sql = "DELETE FROM article_category
							WHERE article_id = {$this->id}";

			if ($ids) {

				$placeholders = array_fill(0, count($ids), '?');

				$sql .= " AND category_id NOT IN (" . implode(", ", $placeholders) . ")";
			}
			$stmt = $conn->prepare($sql);

			foreach ($ids as $i => $id) {
				$stmt->bindValue($i + 1, $id, PDO::PARAM_INT);
			}

			$stmt->execute();
		}


		/**
		 * @return bool
		 */
		protected function validate()
		{
			if ($this->title == '') {
				$this->errors[] = 'Title is required';
			}
			if ($this->content == '') {
				$this->errors[] = 'Content is required';
			}

			if ($this->published_at != '') {
				$date_time = date_create_from_format('Y-m-d H:i:s', $this->published_at);

				if ($date_time === false) {

					$this->errors[] = 'Invalid date and time';

				} else {

					$date_errors = date_get_last_errors();

					if ($date_errors['warning_count'] > 0) {
						$this->errors[] = 'Invalid date and time';
					}
				}
			}
			return empty($this->errors);
		}

		/**
		 * @param $conn
		 * @return boolean True if the delete was successfull, false otherwise
		 */
		public function delete($conn)
		{
			$sql = "DELETE FROM article
								WHERE id = :id";

			$stmt = $conn->prepare($sql);

			$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);

			return $stmt->execute();

		}
		/**
		 * waarom is update unused?
		 * Update the article with its current property values
		 * Not static because it acts on an instance of an object itself
		 *
		 * @param object $conn Connection to the database
		 *
		 * @return boolean True if the update was successful, false otherwise
		 */
		public function create($conn)
		{

			if ($this->validate()) {

				$sql = "INSERT INTO article (title, content, published_at)
								VALUES (:title, :content, :published_at)";

				$stmt = $conn->prepare($sql);

				$stmt->bindValue(':title', $this->title, PDO::PARAM_STR);
				$stmt->bindValue(':content', $this->content, PDO::PARAM_STR);

				if ($this->published_at == '') {
					$stmt->bindValue(':published_at', null, PDO::PARAM_NULL);
				} else {
					$stmt->bindValue(':published_at', $this->published_at, PDO::PARAM_STR);
				}

					if ($stmt->execute()) {
						$this->id = $conn->lastInsertId();   // <-- PDO method
						return true;
				}
			} else {
				return false;
			}
		}

		/**
		 * @param $conn
		 * @return integer The total number of records
		 */
		public static function getTotal($conn)
		{
			// we don't need a prepared statement
			return $conn->query('SELECT COUNT(*) FROM article')->fetchColumn();
		}


		/**
		 * @param $conn
		 * @param $filename
		 * @return boolean True if it was successfull, false otherwise
		 */
		public function setImageFile($conn, $filename)
		{
			$sql = "UPDATE article
							SET image_file = :image_file
							WHERE id = :id";

			$stmt = $conn->prepare($sql);

			$stmt->bindValue(':id', $this->id, PDO::PARAM_INT);
			$stmt->bindValue(':image_file', $filename, $filename == null ? PDO::PARAM_NULL : PDO::PARAM_STR);

			return $stmt->execute();
		}

	}


