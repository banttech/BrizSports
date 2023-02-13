<?php session_start();
    include("conc.php");
	if((!isset($_SESSION['admid']))||(!isset($_SESSION['unam']))||(!isset($_SESSION['pass'])))
	{print'<h3>Incorrect login information</h3>';
                                   print'<meta http-equiv="refresh" content="2; url=admin-login.php">';
    }
	else
	{
      $q1="select * from customers where email='".$_SESSION['unam']."' and passwoo='".$_SESSION['pass']."' and id=".$_SESSION['admid'];
      $rez1=mysqli_query($con,$q1);
	  $sch = mysqli_fetch_array($rez1);
      if(mysqli_num_rows($rez1)==0){print'<h3>Incorrect login information</h3>';
                                   print'<meta http-equiv="refresh" content="2; url=index.php">';
                                  }
							else{
							include("functions.php");
                            $school = $sch['custname'];
                            if (isset($_GET['usid'])) {
                                $sdn=$_GET['usid'];
                            }
							
?>
<!DOCTYPE html>
<html lang="en"><head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Brizsports Order Management</title>

    <!-- Bootstrap Core CSS -->
    <link href="https://brizsports.com.au/order-management/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="https://brizsports.com.au/order-management/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://brizsports.com.au/order-management/css/plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="https://brizsports.com.au/order-management/css/style.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://brizsports.com.au/order-management/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
    <style type="text/css">

@media print {
  body * {
    visibility: hidden;
  }
  .section-to-print, .section-to-print * {
    visibility: visible;
  }
  .not-to-print, .not-to-print * {
	  display:none;
  }
  .section-to-print {
    position: absolute;
    left: 0;
    top: 0;
  }
  .dataTables_filter, .dataTables_length, .dataTables_paginate { display: none; }
}

    table {
        border-collapse: collapse;
    }
    .trtop td {border-top: 1px solid black;}
	.trtopgt td {border-top: 3px solid black;}
    </style>

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
                <a class="navbar-brand" href="dashboard.php"><img src="https://brizsports.com.au/order-management/images/logo.png" alt="Brizsports payment settings management" title="Brizsports payment settings management" /><img src="https://brizsports.com.au/order-management/images/briz-leavers-logo.png" alt="Brizsports orders management" title="Brizsports orders management" style="margin-left:25px;"></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

                <!-- /.dropdown -->

                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            <?php include("side-menu.php");?>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Order by sizes</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
					<? ob_start(); ?>
                    <div class="panel panel-default" id="employee_table">
                        <div class="panel-heading">
                        <?
                        $qube="select * from orderrss where belto=".$_SESSION['admid']." order by id desc";
                        $rezbe=mysqli_query($con,$qube);
                        $ordname='';
                        while($rbe=mysqli_fetch_array($rezbe)) {
                            $ordname=$rbe['ordname'];
                            if($sdn==''){
                                $sdn=$rbe['sdn'];
                            }
                        }
                        ?>
                        
                          Customer: <strong><? echo $school ?></strong>, order: <strong><? echo $ordname ?></strong>, number: <strong><? echo $sdn ?></strong>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive" style="margin-top: 30px;">
								
                                <table cellpadding="10" cellspacing="10">
                                    <thead>
                                        <tr>
                                            
											<th width="150px">Nickname</th>
                                            <th width="150px">Sizes</th>
                                            <th width="50px">Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                        $qube="select * from students where orderid=".$sdn;
                                        $rezbe=mysqli_query($con,$qube);
                                        $sizes = array();
                                        $grandTotal = 0;
                                        while($rbe=mysqli_fetch_array($rezbe)) {
                                            $sizes[$rbe['size']] = $rbe['size'];
                                        }
                                        ?>

                                        <?
                                        foreach($sizes as $size) {
                                            $qube="select * from students where orderid=".$sdn." and size='".$size."'";
                                            $rezbe=mysqli_query($con,$qube);
                                            $total = 0;
                                            while($rbe=mysqli_fetch_array($rezbe)) {
                                                ?>
                                                <tr>
                                                    <td><? echo $rbe['nickname'] ?></td>
                                                    <td><? echo $rbe['size'] ?></td>
                                                    <td><? echo $rbe['quantity'] ?></td>
                                                </tr>
                                                <?
                                            }

                                            $qube="select sum(quantity) as total from students where orderid=".$sdn." and size='".$size."'";
                                            $rezbe=mysqli_query($con,$qube);
                                            $total = 0;
                                            while($rbe=mysqli_fetch_array($rezbe)) {
                                                $total = $rbe['total'];
                                                $grandTotal += $total;
                                            }
                                            ?>
                                            <tr class="trtop">
                                                <td>Total for size <? echo $size ?></td>
                                                
                                                <td></td>
                                                <td><? print $total ?></td>
                                            </tr>
                                            <tr><td style="height:20px;"></td></tr>
                                            <?
                                        }
                                        ?>		  
                                        <tr class="trtopgt">
                                            <td>Grand total</td>
                                            
                                            <td></td>
                                            <td><? print $grandTotal ?></td>
                                        </tr>
                                    </tbody>
                                </table>
								<? $_SESSION['save_to_pdf'] = ob_get_contents();  ?>
                            </div>
							<div align="left" style="margin-top: 30px">  
								 <button name="create_excel" id="create_excel" class="btn btn-success" style="//display: none; margin-right: 20px;"><i class="fa fa-file-excel-o fa-fw"></i> Export to Excel</button> 
								
								<a class="btn btn-danger" href="adminsavepdf.php" target="_blank"><i class="fa fa-file-pdf-o fa-fw"></i> Export to PDF</a>
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
        $('#dataTables-example').dataTable({
			"paging":   false,
        	"ordering": false,
        	"info":     false }
		);
		
    });
    </script>

<script>  
 $(document).ready(function(){  
      $('#create_excel').click(function(){  
           var excel_data = $('#employee_table').html();
           var usid = <?php echo $sdn; ?>;
		  
		  $.ajax({
				url: '../order-management/set_session.php',
				type: 'post',
				data: {data:excel_data,order_id:usid},
				success:function(data){
                    console.log("data", data);
					//alert(data);
					var page = "../order-management/excel.php";
           			window.location = page;
				}
			});
		  
		  
			  
      });  
 });  
 </script>

</body>

</html>
<?php }mysqli_close($con);}?>
