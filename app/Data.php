<?php

namespace App;

class Data
{
	protected $model;

	public function __construct($model)
	{
		$this->model = $model;
	}

	public function merge(array $attributes)
	{

	}
}