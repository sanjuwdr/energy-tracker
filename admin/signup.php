<?php
session_start();
require_once './config/config.php';
require_once "./lib/class.phpmailer.php";
//require_once './includes/auth_validate.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);

function generate_username($fname,$lname) {
	$fname = strtolower($fname);
	$lname = substr(strtolower($lname), 0,3);
	$nrRand = rand(0, 100);

	$username = trim($fname).trim($lname).trim($nrRand);
	return $username;
}

function generate_pass()
{
   $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function send($user,$pwd){
	
	
	$variables = array();

	$variables['username'] = $user;
	$variables['passwd'] = $pwd;

	$message = file_get_contents("email.html");

	foreach($variables as $key => $value)
	{
		$message = str_replace('{{ '.$key.' }}', $value, $message);
	}

	
	$mail = new PHPMailer();

	$mail->IsSMTP();                                      // set mailer to use SMTP
	$mail->Host = "onemediagroup.in;mail.onemediagroup.in";  // specify main and backup server
	$mail->Port       = 587;  
	$mail->SMTPAuth = true;     // turn on SMTP authentication
	$mail->Username = "energytracker@onemediagroup.in";  // SMTP username
	$mail->Password = "d&V@_^KWpw1W"; // SMTP password

	$mail->From = "energytracker@onemediagroup.in";
	$mail->FromName = "Energy Tracker";
	$mail->AddAddress($_POST['email']);


	$mail->Subject = "Login Credentials";
	$mail->Body    = $message;
	$mail->IsHTML(true); 
	$mail->Send();
	
	
}

//If User has already logged in, redirect to dashboard page.
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === TRUE) {
    header('Location:index.php');
}


//If user has previously selected "remember me option", his credentials are stored in cookies.
if(isset($_COOKIE['username']) && isset($_COOKIE['password']))
{
	//Get user credentials from cookies.
	$username = filter_var($_COOKIE['username']);
	$passwd = filter_var($_COOKIE['password']);
	$db->where ("user_name", $username);
	$db->where ("passwd", $passwd);
    $row = $db->get('admin_accounts');

    if ($db->count >= 1) 
    {
    	//Allow user to login.
        $_SESSION['user_logged_in'] = TRUE;
        $_SESSION['admin_type'] = $row[0]['admin_type'];
		$_SESSION['id']=$row[0]['id'];
        header('Location:index.php');
        exit;
    }
    else //Username Or password might be changed. Unset cookie
    {
    unset($_COOKIE['username']);
    unset($_COOKIE['password']);
    setcookie('username', null, -1, '/');
    setcookie('password', null, -1, '/');
    header('Location:login.php');
    exit;
    }
}

//signup
if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    //Mass Insert Data. Keep "name" attribute in html form same as column name in mysql table.
    $data_to_store = filter_input_array(INPUT_POST);
    //Insert timestamp
    $data_to_store['created_at'] = date('Y-m-d H:i:s');

    $last_id = $db->insert ('customers', $data_to_store);
    
	$username=generate_username($_POST['f_name'],$_POST['l_name']);
	$pwd=generate_pass();
    
	$data = Array ("id" => $_POST['id'],
				   "user_name" => "$username",
				   "passwd" => md5($pwd),
				   "admin_type" => "cust"
				  );
	$id = $db->insert ('admin_accounts', $data);
	
	date_default_timezone_set('Asia/Kolkata'); 
	$timestamp =date('Y-m-d H:i:s');
	
	$usage_data = Array ("id" => $_POST['id'],
				   "currentVal" => "0",
				   "lastMonth" => "0",
					"updated_at" => $timestamp
				  );
	$u_id = $db->insert ('usagedetails', $usage_data);
	
    if($last_id && $id && $u_id)
    {
		
		send($username,$pwd);
		$_SESSION['registration'] = TRUE;
		//header("location: login.php?user=$username&pwd=$pwd");
		header("location: login.php");
    	exit();
	}  
	else
	{
		header("location: login.php?error=true");
    	exit();
	}
}


$edit = false;
$signup=true;

include_once 'includes/header.php';?>
<div id="page-" class="col-md-4 col-md-offset-4">
	<form class="form" action="" method="post"  id="customer_form" enctype="multipart/form-data">
		<div class="login-panel panel panel-default">
			<div class="panel-heading">Sign Up</div>
			<div class="panel-body">
				 <?php  include_once('./includes/forms/customer_form.php'); ?>
			</div>
			
		</div>
		<a href="login.php"><p style="text-decoration: underline; text-align: center;font-weight: bold;">Already a member? Login Here</p></a>
	</form>
</div>
<?php include_once 'includes/footer.php'; ?>