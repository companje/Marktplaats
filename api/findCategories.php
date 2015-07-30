<?php
require('/usr/lib/phpquery/phpQuery.php');
header('Content-type: application/json');
setlocale(LC_ALL, "nl_NL");
date_default_timezone_set("Europe/Amsterdam");

$url = "http://www.marktplaats.nl";
$contents = file_get_contents($url);
$doc = phpQuery::newDocumentHTML($contents);
$categories = [];
foreach($doc["ul#navigation-categories li"] as $node){
	$item = [];
	$node = pq($node);
	$item["name"] = $node['a']->html();
	$item["href"] = $node['a']->attr('href');
	$item["id"] = substr(array_shift(explode('.', end(explode('/', $item["href"])))), 1);
	array_push($categories, $item);
}

echo json_encode($categories);

?>