<?php

	require_once(dirname(__FILE__).'/lib/dhtmlxScheduler/connector/db_pdo.php');
	$dbtype = "PDO";
	$res = new PDO("mysql:host=127.0.0.1;dbname=property_ger", "root", "");

?>