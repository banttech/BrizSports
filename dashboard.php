<?php session_start();
      include("../conc.php");
	if((!isset($_SESSION['admid']))||(!isset($_SESSION['unam']))||(!isset($_SESSION['pass'])))
	{print'<h3>Incorrect login information</h3>';
                                   print'<meta http-equiv="refresh" content="2; url=index.php">';
    }
	else
	{
      $q1="select * from pass where user='".$_SESSION['unam']."' and pass='".$_SESSION['pass']."' and id=".$_SESSION['admid'];
      $rez1=mysqli_query($con,$q1);
      if(mysqli_num_rows($rez1)==0){print'<h3>Incorrect login information</h3>';
                                   print'<meta http-equiv="refresh" content="2; url=index.php">';
                                  }
							else{
							include("functions.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Brizsports payment settings management</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="css/plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.php"><img src="images/logo.png" alt="Brizsports payment settings management" title="Brizsports payment settings management" /></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

                <!-- /.dropdown -->
<?php include("pop-menu.php");?>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
<?php include("side-menu.php");?>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Manage Orders</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Manage orders
					  </div>
                        <!-- /.panel-heading -->
                        
                        
                        
                        <div class="panel-body">
                        
                        <?php
						
						if (!empty($_POST)){
							$checkbox = $_POST['checkbox'];
							$count = count($checkbox);
						
							for($i=0;$i<$count;$i++){

								if(!empty($checkbox[$i])){ /* CHECK IF CHECKBOX IS CLICKED OR NOT */
						
								$id = mysqli_real_escape_string($con,$checkbox[$i]); /* ESCAPE STRINGS */
								mysqli_query($con,"DELETE FROM orderrss WHERE id = '$id'"); /* EXECUTE QUERY AND USE ' ' (apostrophe) IN YOUR VARIABLE */
						
								} /* END OF IF NOT EMPTY CHECKBOX */
						
							} /* END OF FOR LOOP */
						
						} /* END OF ISSET DELETE */
						
						?>
                            <div class="table-responsive">
                                <form action="" method="post">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th>Order value</th>
                                            <th>Six digit number</th>
                                            <th>Order date</th>
											<th>Deadline</th>
                                            <th>Order name</th>
											<th>Belongs to</th>
											<th>View order</th>
											<th>Edit Information</th>
                                            <th>Delete Order</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<?php $nrr=1;
      $qube="select * from customers";
      $rezbe=mysqli_query($con,$qube);
	  while($rbe=mysqli_fetch_array($rezbe))
	       $belto[$rbe['id']]=$rbe['custname'];
      $qusers="select * from orderrss";
      $rezusers=mysqli_query($con,$qusers);
	  while($ru=mysqli_fetch_array($rezusers))
{   
?>									
                                        <tr class="<?php if($nrr%2==1){?>odd gradeA<?php }else {?>even gradeA<?php }?>">
                                            <td><input name="checkbox[]" type="checkbox" value="<?php print$ru['id'];?>"></td>
                                            <td><?php print $ru['orderval'];?></td>
                                            <td><?php print $ru['sdn'];?></td>
                                            <td><?php print date("d.m.Y", strtotime($ru['orddate']));?></td>
											<td><?php if($ru['deadline']<>''){print date("d.m.Y", strtotime($ru['deadline']));}else{print '(NA)';}?></td>
                                            <td><?php print $ru['ordname'];?></td>
											<td><?php print $belto[$ru['belto']];?></td>
                                            <td><a href="view-order.php?usid=<?php print$ru['id'];?>"><button class="btn btn-primary pink btn-xs" type="button">View order</button></a></td>
											<td><a href="edit-order.php?usid=<?php print$ru['id'];?>"><button class="btn btn-primary pink btn-xs" type="button">Edit Information</button></a></td>
											<td><a href="delete-order.php?usid=<?php print$ru['id'];?>"><button class="btn btn-primary pink btn-xs" type="button">Delete Order</button></a></td>
                                        </tr>
<?php $nrr++;}?>                                        
                                    </tbody>
                                    
                                </table>
                                <input class="btn btn-danger btn-xs" type="submit" id="delete" value="Delete selected">
                                </form>
                            </div>
                            <!-- /.table-responsive -->

                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->


           
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery Version 1.11.0 -->
    <script src="js/jquery-1.11.0.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="js/plugins/metisMenu/metisMenu.min.js"></script>

    <!-- DataTables JavaScript -->
    <script src="js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="js/sb-admin-2.js"></script>

    <!-- Page-Level Demo Scripts - Tables - Use for reference -->
    <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>

</body>

</html>
<?php }mysqli_close($con);}?>