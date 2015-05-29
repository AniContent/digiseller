<?php

require("models/Config.php");
require("config/Digiseller.php");
require("models/Digiseller.php");

$ID = Config::get("Key");

$shop = new Digiseller($ID);

$answer = $shop->Answer();

$xml_data = @new SimpleXMLElement($answer);

echo $answer;

if(!@$xml_data) 
{
	echo "<span class=\"warning\">Не удается разобрать XML-ответ!</span>\r\n";
}
else 
{
	if($xml_data -> retval == 0 && $xml_data -> unique_code == $ID) 
	{
		echo "<br /><fieldset>
		<legend>Детали платежа</legend>
		<strong>уникальный номер оплаченного счета</strong>: ".$xml_data -> inv."<br />
		<strong>дата и время платежа</strong>: ".$xml_data -> date_pay."<br />
		<strong>идентификатор оплаченного товара</strong>: ".$xml_data -> id_goods."<br />
		<strong>сумма, зачисленная на ваш счет</strong>: ".$xml_data -> amount."<br />
		<strong>тип валюты, зачисленный на ваш счет</strong>: ".$xml_data -> type_curr."<br />\r\n";
		if(!empty($xml_data -> unit_goods) && !empty($xml_data -> cnt_goods)) 
		{
			echo "<strong>единица оплачиваемого товара</strong>: ".$xml_data -> unit_goods."<br />
			<strong>количество единиц оплачиваемого товара</strong>: ".$xml_data -> cnt_goods."\r\n"; 
		}
		echo "</fieldset>\r\n"; 
	}
	else 
	{
		echo "<br /><span class=\"warning\">Платеж не найден!</span>\r\n";
	} 
}
