<?php

require_once '../config/config.php';

if(isset($_POST['user_name']))
{
 $name=$_POST['user_name'];

	$db->where ("user_name",  $name);
   $checkdata = $db->get('admin_accounts');
 //$checkdata=" SELECT name FROM user WHERE name='$name' ";

 //$query=mysql_query($checkdata);

 if($db->count >= 1)
 {
  echo "User Name Already Exist";
 }
 else
 {
  echo "OK";
 }
 exit();
}

if(isset($_POST['user_email']))
{
 $emailId=$_POST['user_email'];

 //$checkdata=" SELECT loginid FROM user WHERE loginid='$emailId' ";
	$db->where ("email",  $emailId);
$checkdata = $db->get('customers');
 //$query=mysql_query($checkdata);

 if($db->count >= 1)
 {
  echo "Email Already Exist";
 }
 else
 {
  echo "OK";
 }
 exit();
}
?>