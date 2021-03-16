<?php
session_start();
include 'DbConnect.php';
$db = new DbConnect();
$db->checkLoggedIn();

$data = $db->getItems();

echo json_encode($data);

?>