<?php

	/**
	 * Class Paginator
	 */
	class Paginator
	{
		/**
		 * @var
		 */
		public $limit;
		/**
		 * @var float|int
		 */
		public $offset;

		/**
		 * @var
		 */
		public $previous;

		/**
		 * @var
		 */
		public $next;

		/**
		 * Paginator constructor.
		 * @param $page
		 * @param $records_per_page
		 */
		public function __construct($page, $records_per_page, $total_records) {

			$this->limit = $records_per_page;

			//validate $page as an int, default is 1 for non numeric values and negative numbers
			$page = filter_var($page, FILTER_VALIDATE_INT, [
				'options' => [
					'default' => 1,
					'min_range' => 1
				]
			]);

			if ($page > 1) {
				$this->previous = $page - 1;
			}

			$total_pages = ceil($total_records / $records_per_page);

			if ($page < $total_pages) {
				$this->next = $page + 1;
			}


			$this->offset = $records_per_page * ($page - 1);

		}
	}
