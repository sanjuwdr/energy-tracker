<?php


if (isset($_POST['tag']) && $_POST['tag'] != '') {
    // get tag
    $tag = $_POST['tag'];

    // include db handler
    require_once 'admin/config/config.php';
   
    // response Array
    $response = array("tag" => $tag, "error" => FALSE);

        // Request type is check Login
        $username = $_POST['username'];
        $password = md5($_POST['password']);

        // check for user
		$db->where ("user_name", $username);
		$db->where ("passwd", $password);
		$db->where ("admin_type", 'cust');
		$userid = $db->getValue ("admin_accounts a", "id");
		$select = array('f_name','l_name','email','phone');
		$db->where("id",$userid );
		$user = $db->get ("customers");//, $select);
	
		//print_r ($user);
		//echo "<br>id:".$userid."<br>";
		//$user = $db->getOne('admin_accounts a');//,null,$select);
     		
    	if ($db->count >= 1) {
            // user found
            $response["error"] = FALSE;
            $response["uid"] = $user[0]["id"];
			$response["user"]["name"] = $user[0]["f_name"]." ".$user[0]["l_name"];
			$response["user"]["email"] = $user[0]["email"];
			$response["user"]["phone"] = $user[0]["phone"];
            echo json_encode($response);
        } else {
            // user not found
            // echo json with error = 1
            $response["error"] = TRUE;
            $response["error_msg"] = "Incorrect email or password!";
            echo json_encode($response);
        }
    
    } 
?>
