<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Energy Tracker</title>

        <!-- Bootstrap Core CSS -->
		<link  rel="stylesheet" href="chart/chart.css"/>
        <link  rel="stylesheet" href="css/bootstrap.min.css"/>

        <!-- MetisMenu CSS -->
        <link href="js/metisMenu/metisMenu.min.css" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="css/sb-admin-2.css" rel="stylesheet">
        <!-- Custom Fonts -->
        <link href="fonts/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
		<link rel="shortcut icon" href="../image/favicon.png" type="image/gif" sizes="16x16">
		<script src="jquery.timeago.js" type="text/javascript"></script>

        <script src="js/jquery.min.js" type="text/javascript"></script> 
		
		<script type="text/javascript">
   jQuery(document).ready(function() {
     $("time.timeago").timeago();
   });
</script>
		
		<style>
				.card {
			  position: relative;
			  margin: auto;
			  height: 350px;
			  width: 600px;
			  text-align: center;
			  background: linear-gradient(#E96874, #6E3663, #2B0830);
			  border-radius: 2px;
			  box-shadow: 0 6px 12px -3px rgba(0,0,0,.3);
			  color: #fff;
			  padding: 30px;
			}

			.card header {
			  position: absolute;
			  top: 31px;
			  left: 0;
			  width: 100%;
			  padding: 0 10%;
			  transform: translateY(-50%);
			  display: grid;
			  grid-template-columns: 1fr 1fr 1fr;
			  align-items: center;
			}

			.card header > *:first-child {
			  text-align: left;
			}
			.card header > *:last-child {
			  text-align: right;
			}

			.logo {
			  font-size: 24px;
			  position: relative;
			}
			.logo:before,
			.logo:after {
			  content: '';
			  position: absolute;
			  top: 50%;
			  border-top: 3px solid currentColor;
			  transform: translateY(-50%);
			}

			.logo:before {
			  right: 158px;
			  width: 40%;
			}
			.logo:after {
			  left: 158px;
			  width: 55%;
			}

			.logo span {
			  /*border: solid currentColor;
			  border-width: 0 3px 3px 0;
			  position: absolute;
			  top: -22px;
			  width: 69px;
			  height: 70px;
			  left: 50%;
			  transform: translateX(-58%) rotate(58deg) skew(0deg, -30deg);*/
			  display: block;
			  position: absolute;
			  width: 100%;
			  top: calc(50% - 1px);
			}

			.announcement {
			  position: relative;
			  border: 3px solid currentColor;
			  border-top: 0;
			  width: 100%;
			  height: 100%;
			  display: flex;
			  flex-direction: column;
			  justify-content: center;
			  align-items: center;
			}

			.announcement:before,
			.announcement:after {
			  content: '';
			  position: absolute;
			  top: 0px;
			  border-top: 3px solid currentColor;
			  height: 0;
			  width: 15px;
			}
			.announcement:before {
			  left: -3px;
			}
			.announcement:after {
			  right: -3px;
			}


			.inspiration {
			  position: absolute;
			  bottom: 20px;
			  left: 20px;
			}

		</style>
    </head>

    <body>

        <div id="wrapper">

            <!-- Navigation -->
            <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in'] == true ) : ?>
                <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="">Energy Tracker</a>
                    </div>
                    <!-- /.navbar-header -->

                    <ul class="nav navbar-top-links navbar-right">
                        <!-- /.dropdown -->

                        <!-- /.dropdown -->
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                                <i class="fa fa-user fa-fw"></i> <?php echo $_SESSION['user']?>  <i class="fa fa-caret-down"></i>
                            </a>
                            <ul class="dropdown-menu dropdown-user">
                                <li><a href="edit_admin.php?admin_user_id=<?php echo $_SESSION['id']?>&operation=edit"><i class="fa fa-gear fa-fw"></i> Settings</a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                                </li>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                        <!-- /.dropdown -->
                    </ul>
                    <!-- /.navbar-top-links -->
		          <div class="navbar-default sidebar" role="navigation">
                        <div class="sidebar-nav navbar-collapse">
                            <ul class="nav" id="side-menu">
                                <li>
                                    <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                                </li>
							<?php if($_SESSION['admin_type'] != 'cust') : ?>
   
          
                                <li class="">
                                    <a href="#"><i class="fa fa-user-circle fa-fw"></i> Customers<span class="fa arrow"></span></a>
                                    <ul class="nav nav-second-level">
                                        <li>
                                            <a href="customers.php"><i class="fa fa-list fa-fw"></i> List all</a>
                                        </li>
                                    <li>
                                        <a href="add_customer.php"><i class="fa fa-plus fa-fw"></i> Add New</a>
                                    </li>
                                    </ul>
                                </li>
								
								<li>
                                    <a href="reports.php" data-toggle="tooltip" title="View the detailed reports of customers"><i class="fa fa-calendar fa-fw"></i> Reports</a>
                                </li>
								
       							<?php if ($_SESSION['admin_type'] == 'super'){ ?>
								<li>
                                    <a href="admin_users.php"><i class="fa fa-users"></i> Users</a>
								</li>
								<?php }; ?>
						<?php else : ?>
								<li>
                                    <a href="history.php"><i class="fa fa-history fa-fw"></i> History</a>
                                </li>
								<li>
                                    <a href="edit_customer.php?customer_id=<?php echo $_SESSION['id']?>&operation=edit"><i class="fa fa-user fa-fw"></i> My Account</a>
                                </li>
						<?php endif; ?>		
                            </ul>
                        </div>
                        <!-- /.sidebar-collapse -->
                    </div>
						
			
					
                    <!-- /.navbar-static-side -->
                </nav>
            <?php endif; ?>
            <!-- The End of the Header -->
			
			