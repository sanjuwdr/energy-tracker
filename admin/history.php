<?php
session_start();
require_once 'includes/auth_validate.php';
require_once './config/config.php';

// Serve deletion if POST method and del_id is set.

//Get data from query string
$search_string = filter_input(INPUT_GET, 'search_string');


$filter_col = filter_input(INPUT_GET, 'filter_col');
$order_by = filter_input(INPUT_GET, 'order_by');
$page = filter_input(INPUT_GET, 'page');
$pagelimit = 20;
if ($page == "") {
    $page = 1;
}
// If filter types are not selected we show latest added data first
if ($filter_col == "") {
    $filter_col = "id";
}
if ($order_by == "") {
    $order_by = "desc";
}

// select the columns
$select = array('id', 'currentVal', 'lastMonth');

$db->where ("id", $_SESSION['id']);
$db->pageLimit = $pagelimit;
$customers = $db->arraybuilder()->paginate("usagedetails", $page, $select);
$total_pages = $db->totalPages;

// get columns for order filter
foreach ($customers as $value) {
    foreach ($value as $col_name => $col_value) {
        $filter_options[$col_name] = $col_name;
    }
    //execute only once
    break;
}
include_once 'includes/header.php';
?>
<div id="page-wrapper">
    <div class="row">

        <div class="col-lg-6">
            <h1 class="page-header">History</h1>
        </div>
        
    </div>
        <?php include('./includes/flash_messages.php') ?>
     <table class="table table-striped table-bordered table-condensed">
        <thead>
            <tr>
                <th class="header">Energy Tracker ID</th>
                <th>Current Usage (Units)</th>
                <th>Last Month's Usage</th>
                <th>Usage Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($customers as $row) { ?>
                <tr>
	                <td>ET<?php echo $row['id'] ?></td>
	                <td><?php echo $row['currentVal'] ?></td>
	                <td><?php echo $row['lastMonth'] ?> </td>
					<td>Average</td>
	               
				</tr>

            <?php } ?>      
        </tbody>
    </table>
	

   
<!--    Pagination links-->
    <div class="text-center">

        <?php
        if (!empty($_GET)) {
            //we must unset $_GET[page] if built by http_build_query function
            unset($_GET['page']);
            $http_query = "?" . http_build_query($_GET);
        } else {
            $http_query = "?";
        }
        if ($total_pages > 1) {
            echo '<ul class="pagination text-center">';
            for ($i = 1; $i <= $total_pages; $i++) {
                ($page == $i) ? $li_class = ' class="active"' : $li_class = "";
                echo '<li' . $li_class . '><a href="customers.php' . $http_query . '&page=' . $i . '">' . $i . '</a></li>';
            }
            echo '</ul></div>';
        }
        ?>
    </div>
	
	<div class="col-lg-8">
            <h1>Usage Statistics</h1>
    
		<?php
		require_once 'chart/chart.php';
		echo Chart::bar(array(
			'Last Month Usage' => $row['lastMonth'] ,
			'This Month Usage' => $row['currentVal']				
		), array('percentage' => true));

		?>
		</div>
</div>
<!--Main container end-->


<?php include_once './includes/footer.php'; ?>

