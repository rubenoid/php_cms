<?php

	spl_autoload_register(function ($class) {
		echo $class . ' ';
		require "classes/{$class}.php";
	});

	$article = new Article();
	$article = new Database();
	$article = new Url();

	//var_dump($article);

