<?php
require('/usr/lib/phpquery/phpQuery.php');
header('Content-type: application/json');
setlocale(LC_ALL, "nl_NL");
date_default_timezone_set("Europe/Amsterdam");

//check 'search' parameter

$category = $_GET['category'];

// &sortBy=SortIndex&sortOrder=decreasing&utm_source=systemmail&utm_medium=email&utm_campaign=searchAlerts&utm_content=results_link_hit
$url = "http://www.marktplaats.nl/z.html?query=&categoryId=$category&sortBy=price&sortOrder=increasing&postcode=9713LZ&distance=3000&priceFrom=0%2C00&priceTo=5%2C00&numberOfResultsPerPage=200";

$contents = file_get_contents($url);
$doc = phpQuery::newDocumentHTML($contents);
$items = [];

foreach($doc['article.search-result'] as $brick) { // div a img
  $brick = pq($brick);
  $price = trim($brick['div.price div']->html());
 /* if ($price !== "Gratis") {
    continue;
  }*/
  $item = [];
  $item["title"] = $brick['h2.heading a span']->html();
  $item["summary"] = $brick['span.mp-listing-description']->html();
  $item["summary"] .= $brick['span.mp-listing-description-extended']->html();
  $item["price"] = $price;
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
$result["totalResults"] = intval(str_replace(".","",$doc['ul.breadcrumbs li h1 span']->html()));

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