<?php
require_once "init.php";
$searchString = $_GET["searchString"];
$order = "1";//$_GET["order"];


$scraperObj = new \Cls\ScraperFlipkart($searchString);

$scraperObj->sorting($order);
$arrayval[] = $scraperObj->getItemArry();

echo $arrayval;

//Saving Json to file
$data[] = $arrayval;

$inp = file_get_contents('results.json');
$tempArray = json_decode($inp);
array_push($tempArray, $data);
$jsonData = json_encode($tempArray);
file_put_contents('results.json', $jsonData);



?>