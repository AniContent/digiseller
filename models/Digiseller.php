<?php

class Digiseller 
{
	function __construct($uniqueCode)
	{
		$ID = Config::get("ID");
		$password = Config::get("Password");

		$this->uniqueCode = $uniqueCode;
		$this->sign = md5($ID.":".$uniqueCode.":".$password);
	}

	public function Answer()
	{
		$request = self::Format($this->uniqueCode, $this->sign);
		$answer = self::Query($request);
		
		return $answer;
	}

	private function Format($uniqueCode, $sign) 
	{
		$ID = Config::get("ID");

		$request = "<?xml version=\"1.0\" encoding=\"windows-1251\"?>
		<digiseller.request>
		<id_seller>".$ID."</id_seller>
		<unique_code>".$uniqueCode."</unique_code>
		<sign>".$sign."</sign>
		</digiseller.request>";
		return $request;
	}

	private function Query($string)
	{
		$URL = Config::get("URL");

		$query = curl_init($URL);
		curl_setopt($query, CURLOPT_HEADER, 0);
		curl_setopt($query, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($query, CURLOPT_POST, 1);
		curl_setopt($query, CURLOPT_POSTFIELDS, $string);

		$result = curl_exec($query);

		if(curl_errno($query)) 
		{
			Fail($query);
		}

		curl_close($query);

		return $result;
	}

	private function Fail($query)
	{
		echo "Error number: ".curl_errno($query)."<br /> Exception: ".curl_error($query)."<br />";
	}
}