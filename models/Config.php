<?php

class BaseConfig
{
	public static $_config = [];

	static public function get($string)
	{

		$path = explode('/', $string);

		$location = static::$_config;

		foreach($path as $element)
		{
			if(isset($location[$element]))
			{
				$location = $location[$element];
			}
			else
			{
				return '';
			}
		}

		return $location;
	}

}