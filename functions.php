<?php

function curlPostViaShell($url, $params, $referer = false) {

	$paramsBuilt = http_build_query($params);
	$command = 'curl --data "' . $paramsBuilt . '"';

	if ($referer) {
		$command .= '--referer ' . $referer;
	}

	$command .= ' ' . $url;

	$response = shell_exec($command);

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

function _log($message) {
	echo $message . PHP_EOL;
}