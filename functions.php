<?php

function curlPostViaShell($url, $params) {

	$paramsBuilt = http_build_query($params);
	$command = 'curl --data "' . $paramsBuilt . '" ' . $url;
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