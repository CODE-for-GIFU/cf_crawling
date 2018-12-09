<?php

ini_set('display_errors', "On");

$res = array();
require_once('./api.php');

for ($i = 1; $i < 100; $i += 10)
{
	$cse_url = "https://www.googleapis.com/customsearch/v1?key=".$api_key."&cx=".$search_id."&q=CODE+for&hl=ja&lr=lang_ja";
	$cse_url .= "&start=".$i;

	echo $cse_url."<br>";

	$search_result = file_get_contents($cse_url);
	$search_result = json_decode($search_result, true);

	foreach($search_result["items"] as $key => $val)
	{
		preg_match('/(CODE|Code|code) for [A-z]+/', $val["snippet"], $matches);
		if (count($matches) > 0)
		{
			echo $matches[0]."<br>";
			$res []= $matches[0];
		}
	}
}

$res = array_unique($res);
print_r($res);

$res_text = "";
foreach ($res as $key => $val)
{
	$res_text .= $val."\n";
}

date_default_timezone_set('Asia/Tokyo');
file_put_contents(date("Ymd_Hi").".txt", $res_text);


?>