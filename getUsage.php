<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'admin/config/config.php';

//$units = ($_GET["currentValue"]);

$usage=  filter_input(INPUT_GET, 'currentValue');
$user_id=  filter_input(INPUT_GET, 'user');

function calcCost($units)
{
    $cost='0';

	if($units<'40')
		$cost=(float)1.50*$units;
	elseif ($units<'50')
		$cost=(float) 2.90*$units;
	elseif ($units>'50' && $units<='100')
		$cost=(float) 3.40*$units;
	elseif ($cost>'100' && $cost<='150')
		$cost=(float) 4.50*$units;
	elseif ($cost>'150' && $cost<='200')
		$cost=(float) 6.10*$units;
	elseif ($cost>'200' && $cost<='250')
		$cost=(float) 7.30*$units;
	elseif ($cost>'250' && $cost<='300')
		$cost=(float) 5.50*$units;
	elseif ($cost>'300' && $cost<='350')
		$cost=(float) 6.20*$units;
	elseif ($cost>'350' && $cost<='400')
		$cost=(float) 6.50*$units;
	elseif ($cost>'400' && $cost<='500')
		$cost=(float) 6.70*$units;
	else
		$cost=(float) 7.50*$units;

	$cost+='30';
	return $cost;
}

//echo $usage." ".$user_id;
date_default_timezone_set('Asia/Kolkata'); 
$timestamp =date('Y-m-d H:i:s');
$dt= date("d"); // time in India

$usage=$db->rawQueryValue ("SELECT currentVal FROM usagedetails WHERE id=".$user_id." limit 1", 'limit 1');
$data = Array (
	'currentVal' => $usage+1,
	'calcCost' => calcCost($usage),
	"updated_at" => $timestamp
);


$db->where ('id', $user_id);
if ($db->update ('usagedetails', $data)){

	echo "Record updated successfully<br>";
	echo "Cost is ".calcCost($usage);
	echo '<pre>' . print_r($data, TRUE) . '</pre>';
//$sql = "UPDATE usageDetails SET currentVal='$units' WHERE id";//, now())”;

	if($dt==='01')//do every month
	{
		$data = Array (
			'currentVal' => '0',
			'lastMonth' => $usage,
			'calcCost'=> '0',
			"updated_at" => date('Y-m-d H:i:s')
		);
		$db->where ('id', $user_id);
		$db->update ('usagedetails', $data);
	}	
	

}
else {
//echo "Error updating record:" ;
}

?>