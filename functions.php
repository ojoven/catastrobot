<?php

function curlPostViaShell($url, $params, $referer = false) {

	$paramsBuilt = http_build_query($params);
	$command = 'curl --data "' . $paramsBuilt . '"';

	if ($referer) {
		$command .= '--referer "' . $referer . '"';
	}

	$command .= ' ' . $url;

	$response = shell_exec($command);

	return $response;
}

function curlPost($url, $params, $referer = false) {

	$builtQuery = http_build_query($params);
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $builtQuery);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

	if ($referer) {
		curl_setopt($ch, CURLOPT_REFERER, $referer);
	}

	$response = curl_exec($ch);
	curl_close($ch);

	return $response;

}

function getURLWithReferer($url, $referer) {

	$opts = array(
		'http'=>array(
			'header'=>array("Referer: $referer\r\n")
		)
	);
	$context = stream_context_create($opts);
	return file_get_contents($url, false, $context);

}

function writeToCSV($csv, $row) {
	$handle = fopen($csv, "a");
	fputcsv($handle, $row); # $line is an array of string values here
	fclose($handle);
}

function clearFile($path) {
	file_put_contents($path, "");
}

function removeSpaces($string) {

	$string = str_replace('&nbsp;', ' ', $string);
	$string = trim(preg_replace('/\t+/', '', $string));
	return $string;

}

function _log($message) {
	echo $message . PHP_EOL;
}