<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'admin/config/config.php';
$user_id=  filter_input(INPUT_GET, 'user');

//$data = Array ('');
$db->where ('id', $user_id);

$result=$db->get ('usagedetails');

//print_r($result);
//$data = array('energy' => $result);
$data = array();
$data["id"]=$result[0]["id"];
$data["currentVal"]=$result[0]["currentVal"];
$data["lastMonth"]=$result[0]["lastMonth"];
$data["updated_at"]=$result[0]["updated_at"];
print json_encode($data);

?>