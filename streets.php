<?php

// Require external libraries
require_once 'functions.php';
require_once 'vendor/simple_html_dom.php';

$urlStreets = 'http://www4.gipuzkoa.net/ogasuna/catastro/selVias.asp?mapa=DONOSTIA-SAN%20SEBASTIAN&calle=';
$htmlStreets = file_get_contents($urlStreets);
$htmlStreets = iconv("ISO-8859-1", "UTF-8", $htmlStreets);
$html = str_get_html($htmlStreets);

$streets = array();

foreach ($html->find('a') as $link) {

	$streets[] = $link->plaintext;

}

$json = json_encode($streets);
print_r($json);