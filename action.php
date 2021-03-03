<?php
session_start();
include 'DbConnect.php';
$db = new DbConnect();

if($_POST['action'] == 'delete_bill' && $_POST['id']) {
	$db->deleteInvoice($_POST['id']);	
	$jsonResponse = array(
		"status" => 1	
	);
	echo json_encode($jsonResponse);	
}

if($_GET['action'] == 'delete_bill' && $_GET['id']) {
	$db->deleteInvoice($_GET['id']);	
	$jsonResponse = array(
		"status" => 1	
	);
	echo json_encode($jsonResponse);	
}
if($_GET['action'] == 'logout') {
session_unset();
session_destroy();
header("Location:index.php");
}

