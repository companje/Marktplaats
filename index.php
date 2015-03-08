<?php
require('lib/phpQuery/phpQuery.php');
header('Content-type: application/json');
setlocale(LC_ALL, "nl_NL");
date_default_timezone_set("Europe/Amsterdam");

//check 'search' parameter
if (empty($_GET['search'])) die("search is undefined");
else $search = urlencode($_GET['search']);

//check 'since' parameter
if (empty($_GET['since'])) {
  $since = "";
  $startDateFrom = "";
} else {
  $since = $_GET['since'];
  $startDateFrom = empty($since) ? "" : (strtotime($since) . "000");
}

// &sortBy=SortIndex&sortOrder=decreasing&utm_source=systemmail&utm_medium=email&utm_campaign=searchAlerts&utm_content=results_link_hit
$url = "http://www.marktplaats.nl/z.html?query=$search&startDateFrom=$startDateFrom&view=lr";
$contents = file_get_contents($url);
$doc = phpQuery::newDocumentHTML($contents);
$items = [];

foreach($doc['article.search-result'] as $brick) { // div a img
  $brick = pq($brick);
  $item = [];
  $item["title"] = $brick['h2.heading a span']->html();
  $item["summary"] = $brick['span.mp-listing-description']->html();
  $item["summary"] .= $brick['span.mp-listing-description-extended']->html();
  $item["price"] = trim($brick['div.price div']->html());
  $item["seller"] = trim($brick['div.seller-name a']->html());
  $item["thumbnail"] = "http:".$brick['figure span div img']->attr('src');
  $item["image"] = str_replace("_82","_83",$item["thumbnail"]);
  $item["href"] = $brick['figure span']->attr('data-url');
  $item["location"] = $brick['div.location-name']->html();
  $items[] = $item;
}

$result["url"] = $url;
$result["search"] = $search;
$result["shownResults"] = count($doc['article.search-result']);
$result["totalResults"] = intval($doc['ul.breadcrumbs li h1 span']->html());
if (!empty($since)) {
  $result["since"] = $since;
  $result["sinceDate"] = date("Y-m-d",strtotime($since));
}

foreach($doc['.suggested-searches h3.item a'] as $s) {
  $result["suggested"][] = pq($s)->html();
}

$result["items"] = $items;

echo json_encode($result);
?>