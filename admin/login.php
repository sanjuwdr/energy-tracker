<?php
session_start();
require_once './config/config.php';
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



include_once 'includes/header.php';?>
<div id="page-" class="col-md-4 col-md-offset-4">
	<form class="form loginform" method="POST" action="authenticate.php">
		<div class="login-panel panel panel-default">
			<div class="panel-heading">Log in to your portal</div>
			<div class="panel-body">
				<div class="form-group">
					<label class="control-label">Username</label>
					<input type="text" name="username" class="form-control" required="required">
				</div>
				<div class="form-group">
					<label class="control-label">Password</label>
					<input type="password" name="passwd" class="form-control" required="required">
				</div>
				<div class="checkbox">
					<label>
						<input name="remember" type="checkbox" value="1">Remember Me
					</label>
				</div>
				<a href="forgot_password.php"><p style="text-decoration: underline; text-align: right;font-weight: bold;">Can't access your account?</p></a>
				<?php
				if(isset($_SESSION['login_failure'])){ ?>
				<div class="alert alert-danger alert-dismissable fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<?php echo $_SESSION['login_failure']; unset($_SESSION['login_failure']);?>
				</div>
				<?php } ?>
		  		<button type="submit" class="btn btn-success loginField" >Login</button>
		
				<?php
				$reg = filter_input(INPUT_GET, 'error',FILTER_SANITIZE_STRING);
				if(isset($_SESSION['registration']) && $_SESSION['registration'] === TRUE){ ?>
				<br><br><div class="alert alert-info alert-dismissable fade in">
					<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
					<?php echo 'Check your email for login credentials!'; unset($_SESSION['registration']);?>
				
				</div>
				<?php } ?>
				<a href="signup.php"><p style="text-decoration: underline; text-align: center;font-weight: bold;">New Customer? Sign Up here</p></a>
			</div>
			
		</div>
		<a href="../"><p style="text-decoration: underline; text-align: center;font-weight: bold;">Back to Home</p></a>
	</form>
</div>
<?php include_once 'includes/footer.php'; ?>