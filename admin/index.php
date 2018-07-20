<?php
session_start();
require_once './config/config.php';
require_once 'includes/auth_validate.php';

//Get Dashboard information
$db->get('customers');
$numCustomers = $db->count;


//get total usage
$db->get('usagedetails');

$count = $db->getValue ("usagedetails", "SUM(currentVal)");//$db->rawQueryValue ('SELECT SUM(currentVal) FROM usagedetails limit 1', 'limit 1');

//get current usage
$select = array('currentVal','calcCost','updated_at');
$db->where ("id", $_SESSION['id']);
$usage = $db->get ("usagedetails",null, $select);//$db->rawQueryValue ("SELECT currentVal FROM usagedetails WHERE id=".$_SESSION['id']." limit 1", 'limit 1');

include_once('includes/header.php');
?>
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Dashboard</h1>
			
			<h2><?php //	echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>'; ?></h2>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
	  <!-- Form Name -->
	<?php if($_SESSION['admin_type'] != 'cust') : ?>
    	<div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-user fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $numCustomers; ?></div>
                            <div>Customers</div>
                        </div>
                    </div>
                </div>
                <a href="customers.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel panel-green">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-3">
                            <i class="fa fa-list-ol fa-5x"></i>
                        </div>
                        <div class="col-xs-9 text-right">
                            <div class="huge"><?php echo $count; ?></div>
                            <div>Total Units Used</div>
                        </div>
                    </div>
                </div>
                <a href="reports.php">
                    <div class="panel-footer">
                        <span class="pull-left">View Details</span>
                        <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                        <div class="clearfix"></div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
        
        </div>
        <div class="col-lg-3 col-md-6">
            
        </div>
    </div>
	<?php else : ?>
	
	<div class="row">
			<div class="col-lg-6 col-md-6">
					<h2><?php //echo "Your current usage is ".$usage." units." ; ?></h2>
				<div class="card">
  <header>
    <time  
  datetime="<?php echo $usage[0]['updated_at']; ?>"><?php echo date('d M, Y')?></time>
    <div class="logo">
      <span>
        <svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" viewBox="0 0 234.5 53.7"><style>.st0{fill:none;stroke:#FFFFFF;stroke-width:5;stroke-miterlimit:10;}</style><path d="M.6 1.4L116.9 52l117-50.6" class="st0"/></svg>
      </span></div>
    <div class="sponsor"> <time class="timeago" datetime="<?php echo $usage[0]['updated_at']; ?>">time ago</time></div>
  </header>
  <div class="announcement">
    <h3>Your current usage is</h3>
    <h1><?php echo $usage[0]['currentVal']." units" ?></h1>
	  
    <h3 class="italic">and the cost is </h3>
	  
	  <div class="col-lg-4">
			<ul class="nav nav-pills nav-stacked" >
                <li class="active" ><a href="pay.php"><span class="badge pull-right"><i class="fa fa-inr" aria-hidden="true"></i> <?php echo $usage[0]['calcCost'] ?></span> Pay Now</a>
                </li>
            </ul>
            <!-- /.panel -->
        </div>
  </div>
</div>
				 
			</div>
		</div>
	<?php endif; ?>
		
    
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-8">


            <!-- /.panel -->
        </div>
        <!-- /.col-lg-8 -->
       
        <!-- /.col-lg-4 -->
    </div>
    <!-- /.row -->
</div>
<!-- /#page-wrapper -->

<?php include_once('includes/footer.php'); ?>
