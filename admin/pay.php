<?php
session_start();
require_once './config/config.php';

if(!($cust_id=  base64_decode(filter_input(INPUT_GET, 'p'))))
	$cust_id=$_SESSION['id'];

$select = array('p.id','c.f_name','c.l_name', 'p.calcCost', 'c.phone','c.email');
$db->join("customers c", "p.id=c.id", "LEFT");
$db->where("c.id",$cust_id );
$custdetails = $db->get ("usagedetails p",null, $select);
//print_r ($custdetails[0]);
//print_r (base64_decode($cust_id));

$MERCHANT_KEY = "xvbKWVM";
$SALT = "E9rAhK21Qo";
// Merchant Key and Salt as provided by Payu.

//$PAYU_BASE_URL = "https://test.payu.in";		// For Sandbox Mode
$PAYU_BASE_URL = "https://secure.payu.in";			// For Production Mode

$action = $PAYU_BASE_URL . '/_payment';

$posted = array();
$posted['key']=$MERCHANT_KEY;
$posted['txnid']=substr(hash('sha256', mt_rand() . microtime()), 0, 20);
$posted['amount']=$custdetails[0]['calcCost'];
$posted['firstname']=$custdetails[0]['f_name'].$custdetails[0]['l_name'];
$posted['email']=$custdetails[0]['email'];
$posted['phone']=$custdetails[0]['phone'];
$posted['productinfo']='Electricity Bill Payment';
$posted['surl']='index.php?payment=success';
$posted['furl']='index.php?payment=failure';
$posted['service_provider']='payu_paisa';

$formError = 0;

  // Generate random transaction id
$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);

$hash = '';//strtolower(hash('sha512', $hash_string));
// Hash Sequence
$hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

if(empty($posted['hash']) && sizeof($posted) > 0) {
  if(
          empty($posted['key'])
          || empty($posted['txnid'])
          || empty($posted['amount'])
          || empty($posted['firstname'])
          || empty($posted['email'])
          || empty($posted['phone'])
          || empty($posted['productinfo'])
          || empty($posted['surl'])
          || empty($posted['furl'])
		  || empty($posted['service_provider'])
  ) {
    $formError = 1;
  } else {
    //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
	$hashVarsSeq = explode('|', $hashSequence);
    $hash_string = '';	
	foreach($hashVarsSeq as $hash_var) {
      $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
      $hash_string .= '|';
    }

    $hash_string .= $SALT;


    $hash = strtolower(hash('sha512', $hash_string));
    $action = $PAYU_BASE_URL . '/_payment';
  }
} elseif(!empty($posted['hash'])) {
  $hash = $posted['hash'];
  $action = $PAYU_BASE_URL . '/_payment';
}
?>
<html>
  <head>
  <script>
    var hash = '<?php echo $hash ?>';
    function submitPayuForm() {
		$('#processing').modal('show');
      setTimeout(function(){
		  if(hash == '') {
			return;
			}
      var payuForm = document.forms.payuForm;
      payuForm.submit();
		  }, 1500); 
    }
  </script>
	  <link rel='stylesheet prefetch' href='css/bootstrap.min.css'>
	  <link rel='stylesheet prefetch' href='css/animate.min.css'>

      <link rel="stylesheet" href="css/process.css">
  </head>
  <body onload="submitPayuForm()">
    <br/>
    <?php if($formError) { ?>
	
      <span style="color:red">Please fill all mandatory fields.</span>
      <br/>
      <br/>
    <?php } ?>
    <form action="<?php echo $action; ?>" method="post" name="payuForm" style="display: none;">
      <input  name="key" value="<?php echo $MERCHANT_KEY ?>" />
      <input  name="hash" value="<?php echo $hash ?>"/>
      <input name="txnid" value="<?php echo $txnid ?>" />
      <table>
        <tr>
          <td><b>Mandatory Parameters</b></td>
        </tr>
        <tr>
          <td>Amount: </td>
          <td><input name="amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" /></td>
          <td>First Name: </td>
          <td><input name="firstname" id="firstname" value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname']; ?>" /></td>
        </tr>
        <tr>
          <td>Email: </td>
          <td><input name="email" id="email" value="<?php echo (empty($posted['email'])) ? '' : $posted['email']; ?>" /></td>
          <td>Phone: </td>
          <td><input name="phone" value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone']; ?>" /></td>
        </tr>
        <tr>
          <td>Product Info: </td>
          <td colspan="3"><textarea name="productinfo"><?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo'] ?></textarea></td>
        </tr>
        <tr>
          <td>Success URI: </td>
          <td colspan="3"><input name="surl" value="<?php echo (empty($posted['surl'])) ? '' : $posted['surl'] ?>" size="64" /></td>
        </tr>
        <tr>
          <td>Failure URI: </td>
          <td colspan="3"><input name="furl" value="<?php echo (empty($posted['furl'])) ? '' : $posted['furl'] ?>" size="64" /></td>
        </tr>

        <tr>
          <td colspan="3"><input type="hidden" name="service_provider" value="payu_paisa" size="64" /></td>
        </tr>

        <tr>
          <td><b>Optional Parameters</b></td>
        </tr>
        <tr>
          <td>Last Name: </td>
          <td><input name="lastname" id="lastname" value="<?php echo (empty($posted['lastname'])) ? '' : $posted['lastname']; ?>" /></td>
          <td>Cancel URI: </td>
          <td><input name="curl" value="" /></td>
        </tr>
        <tr>
          <td>Address1: </td>
          <td><input name="address1" value="<?php echo (empty($posted['address1'])) ? '' : $posted['address1']; ?>" /></td>
          <td>Address2: </td>
          <td><input name="address2" value="<?php echo (empty($posted['address2'])) ? '' : $posted['address2']; ?>" /></td>
        </tr>
        <tr>
          <td>City: </td>
          <td><input name="city" value="<?php echo (empty($posted['city'])) ? '' : $posted['city']; ?>" /></td>
          <td>State: </td>
          <td><input name="state" value="<?php echo (empty($posted['state'])) ? '' : $posted['state']; ?>" /></td>
        </tr>
        <tr>
          <td>Country: </td>
          <td><input name="country" value="<?php echo (empty($posted['country'])) ? '' : $posted['country']; ?>" /></td>
          <td>Zipcode: </td>
          <td><input name="zipcode" value="<?php echo (empty($posted['zipcode'])) ? '' : $posted['zipcode']; ?>" /></td>
        </tr>
        <tr>
          <td>UDF1: </td>
          <td><input name="udf1" value="<?php echo (empty($posted['udf1'])) ? '' : $posted['udf1']; ?>" /></td>
          <td>UDF2: </td>
          <td><input name="udf2" value="<?php echo (empty($posted['udf2'])) ? '' : $posted['udf2']; ?>" /></td>
        </tr>
        <tr>
          <td>UDF3: </td>
          <td><input name="udf3" value="<?php echo (empty($posted['udf3'])) ? '' : $posted['udf3']; ?>" /></td>
          <td>UDF4: </td>
          <td><input name="udf4" value="<?php echo (empty($posted['udf4'])) ? '' : $posted['udf4']; ?>" /></td>
        </tr>
        <tr>
          <td>UDF5: </td>
          <td><input name="udf5" value="<?php echo (empty($posted['udf5'])) ? '' : $posted['udf5']; ?>" /></td>
          <td>PG: </td>
          <td><input name="pg" value="<?php echo (empty($posted['pg'])) ? '' : $posted['pg']; ?>" /></td>
        </tr>
        <tr>
          <?php if(!$hash) { ?>
            <td colspan="4"><input type="submit" value="Submit" /></td>
          <?php } ?>
        </tr>
      </table>
    </form>
	  <div class='modal fade bottom' id='processing' tabindex='-1' data-backdrop="static" data-keyboard="false">
  <div class='modal-dialog'>
    <div class='modal-content text-center'>
      <div class='modal-header'>
        <h4 class='modal-title'>Processing Payment</h4>
      </div>
      <div class='modal-body processing'>
        <div class='row'>
          <div class='col-xs-12'>
            <div class='loader'>
              <h2>
                Loading
                <span class='loading-dot'>.</span>
                <span class='loading-dot'>.</span>
                <span class='loading-dot'>.</span>
              </h2>
            </div>
          </div>
          <div class='col-xs-12'>
            <h3>
              We are processing your payment.
              <br>
              Almost Done!
            </h3>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
	  
  </body>
	
	<script src='js/jquery.min.js'></script>
<script src='js/bootstrap.min.js'></script>
</html>
