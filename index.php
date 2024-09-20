<?php

	$iphone = strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone');
	$android = strpos($_SERVER['HTTP_USER_AGENT'], 'Android');
	$palmpre = strpos($_SERVER['HTTP_USER_AGENT'], 'webOS');
	$berry = strpos($_SERVER['HTTP_USER_AGENT'], 'BlackBerry');
	$ipod = strpos($_SERVER['HTTP_USER_AGENT'], 'iPod');

	require('backend.php');

	if($iphone || $android || $palmpre || $berry || $ipod)
		include('movilView.php');
	else{
		$desk = true;
		include('deskView.php');
	}
