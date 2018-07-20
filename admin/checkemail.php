<?php
$registeredEmails = array('spazhankannur@gmail.com', 'gandhibhavan@gmail.com', 'test3@test.com');

$requestedEmail  = $_POST['email'];

if( in_array($requestedEmail, $registeredEmails) ){
    echo json_encode(FALSE);
}
else{
    echo json_encode(TRUE);
}
?>