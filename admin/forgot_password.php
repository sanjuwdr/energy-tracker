<?php
session_start();
require_once './config/config.php';
//If User has already logged in, redirect to dashboard page.
if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] === TRUE) {
    header('Location:index.php');
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

	$message = file_get_contents("reset.html");

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


	$mail->Subject = "Reset Password";
	$mail->Body    = $message;
	$mail->IsHTML(true); 
	$mail->Send();
	
	
}

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

include_once 'includes/header.php';?>
<div id="page-" class="col-md-4 col-md-offset-4">
	<form class="form loginform" method="POST" action="">
		<div class="login-panel panel panel-default">
			<div class="panel-heading">Reset your password</div>
			<div class="panel-body">
				<p>Enter your email address that you used to register. <br>We'll send you an email with your username and resetted password.</p>
			
				
				<div class="form-group">
					<label class="control-label">Email</label>
					<input type="text" name="email" class="form-control" required="required">
				</div>
				
				<?php
				if(isset($_SESSION['login_failure'])){ ?>
				<div class="alert alert-danger alert-dismissable fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<?php echo $_SESSION['login_failure']; unset($_SESSION['login_failure']);?>
				</div>
				<?php } ?>
		  		<button type="submit" class="btn btn-success loginField" >Reset password</button>
		
				</div>
			
		</div>
		<a href="login.php"><p style="text-decoration: underline; text-align: center;font-weight: bold;">Sign in here!</p></a>
	</form>
</div>
<?php include_once 'includes/footer.php'; ?>