<?php
	require_once('./lib/dhtmlxScheduler/connector/scheduler_connector.php');
	include ('./config.php');

	$roomtypes = new JSONOptionsConnector($res, $dbtype);
	$roomtypes->render_table("users","id","id(value),name(label)");
	
	$roomstatuses = new JSONOptionsConnector($res, $dbtype);
	$roomstatuses->render_table("room_statuses","id","id(value),name(label)");

	$bookingstatuses = new JSONOptionsConnector($res, $dbtype);
	$bookingstatuses->render_table("booking_statuses","id","id(value),name(label)");

	$rooms = new JSONOptionsConnector($res, $dbtype);
	$rooms->render_table("property","id","id(value),name(label),users_id(type),status(status)");

	$scheduler = new JSONSchedulerConnector($res, $dbtype);

	$scheduler->set_options("roomType", $roomtypes);
	$scheduler->set_options("roomStatus", $roomstatuses);
	$scheduler->set_options("bookingStatus", $bookingstatuses);
	$scheduler->set_options("room", $rooms);

	$scheduler->render_table("booking","id","start_date,end_date,users_id(text),property_id(room),status,is_paid,capacity(capacity),price(amount),discount(discount),special_cleaning_fee,users_id");
?>


