<?php
require_once 'admin/config/config.php';
$user_id=  filter_input(INPUT_GET, 'user');

//$data = Array ('');
$db->where ('id', $user_id);

$result=$db->get ('usageDetails');


$data = array('energy' => $result);
print json_encode($data);

?>