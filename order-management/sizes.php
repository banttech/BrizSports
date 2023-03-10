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
    
    <style type="text/css">
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
						
						$qord="select * from orderrss where sdn=".$_GET['usid'];
      $resord=mysqli_query($con,$qord);
	  while($ro=mysqli_fetch_array($resord)){
		  $cid =  $ro['belto'];
		  $oname =  $ro['ordname'];
		  $method =  $ro['methodofpayment'];
	  }
						
						$qcust="select * from customers where id=".$cid;
      $rescust=mysqli_query($con,$qcust);
	  while($rc=mysqli_fetch_array($rescust)){
		  $cname =  $rc['custname'];
	  }
?>
                          Customer: <strong><? echo $cname ?></strong>, order: <strong><? echo $oname ?></strong>, number: <strong><? echo $_GET['usid'] ?></strong>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive" style="margin-top: 30px;">
								
                                <table cellpadding="10" cellspacing="10">
                                <thead>
                                        <tr>
                                            <th width="160px">Size</th>
                                            <th width="160px">Quantity</th>
                                            <th width="200px">Nick name options</th>
                                            <th width="200px">Nick name to print</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?
                                            $qube="select * from students where orderid=".$_GET['usid'];
                                            $rezbe=mysqli_query($con,$qube);
                                            $studentsIds = array();
                                            $grandTotal = 0;
                                            while($rbe=mysqli_fetch_array($rezbe)) {
                                                $studentsIds[] = $rbe['id'];
                                            }
                                            $orderSizes = "select * from order_sizes where student_id in (".implode(',', $studentsIds).")";
                                            $orderSizes = mysqli_query($con,$orderSizes);
                                            $sizes = array();
                                            while($orderSize = mysqli_fetch_array($orderSizes)) {
                                                $sizes[$orderSize['size']] = $orderSize['size'];
                                            }
                                        ?>
                                        <?
                                        foreach($sizes as $size) {
                                            $studentOrderSizes = "select * from order_sizes where student_id in (".implode(',', $studentsIds).") and size='".$size."'";
                                            $studentOrderSizes = mysqli_query($con,$studentOrderSizes);
                                            while($studentOrderSize = mysqli_fetch_assoc($studentOrderSizes)) {
                                        ?>
                                        <tr>
                                            <td><? echo $studentOrderSize['size'] ?></td>
                                            <td><? echo $studentOrderSize['quantity'] ?></td>
                                            <td>
                                                <?
                                                    $orderNickValues = "select * from order_nick_name where order_sizes_id=".$studentOrderSize['id'];
                                                    $orderNickValues = mysqli_query($con,$orderNickValues);
                                                    $totalOrderNickValues = mysqli_num_rows($orderNickValues);
                                                    while($orderNickValue = mysqli_fetch_assoc($orderNickValues)) {
                                                        $nickValue = '';
                                                        if($orderNickValue['nick_name_option'] == 1) {
                                                            $nickValue = 'Not applicable';
                                                        } else if($orderNickValue['nick_name_option'] == 2) {
                                                            $nickValue = 'Keep name space blank';
                                                        } else if($orderNickValue['nick_name_option'] == 3) {
                                                            $nickValue = 'Write a nick name to print';
                                                        }
                                                        echo $nickValue;
                                                        if($totalOrderNickValues > 1) {
                                                            echo "<br>";
                                                        }
                                                        $totalOrderNickValues--;
                                                    }
                                                    echo "<br>";
                                                ?>
                                            </td>
                                            <td>
                                                <?
                                                    $orderNickValues = "select * from order_nick_name where order_sizes_id=".$studentOrderSize['id'];
                                                    $orderNickValues = mysqli_query($con,$orderNickValues);
                                                    $totalOrderNickValues = mysqli_num_rows($orderNickValues);
                                                    while($orderNickValue = mysqli_fetch_assoc($orderNickValues)) {
                                                        $nickName = '';
                                                        if($orderNickValue['nick_name_option'] == 1) {
                                                            $nickName = 'NA';
                                                        } else if($orderNickValue['nick_name_option'] == 2) {
                                                            $nickName = 'Blank';
                                                        } else if($orderNickValue['nick_name_option'] == 3) {
                                                            $nickName = $orderNickValue['print_nick_name'];
                                                        }
                                                        echo $nickName;
                                                        if($totalOrderNickValues > 1) {
                                                            echo "<br>";
                                                        }
                                                        $totalOrderNickValues--;
                                                    }
                                                    echo "<br>";
                                                ?>
                                            </td>
                                        </tr>
                                        <? } ?>
                                        <tr class="trtop">
                                            <td>
                                                <?
                                                    $totalQuantity = 0;
                                                    $orderSizes = "select * from order_sizes where student_id in (".implode(',', $studentsIds).") and size='".$size."'";
                                                    $orderSizes = mysqli_query($con,$orderSizes);
                                                    while($orderSize = mysqli_fetch_array($orderSizes)) {
                                                        $totalQuantity += $orderSize['quantity'];
                                                    }
                                                    $grandTotal += $totalQuantity;
                                                ?>
                                                Total for size <? echo $size ?>
                                            </td>
                                            <td><? echo $totalQuantity ?></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr class="trtop">
                                            <td colspan="4"><br /></td>
                                        </tr>
                                        <? } ?>
                                        <tr class="trtopgt">
                                            <td>Grand total</td>
                                            <td><? print $grandTotal ?></td>                                            
                                            <td></td>
                                            <td></td>
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
        $('#dataTables-example').dataTable();
    });
    </script>
	
	<script>  
 $(document).ready(function(){  
      $('#create_excel').click(function(){  
           var excel_data = $('#employee_table').html();
           var usid = <? echo $_GET['usid'] ?>;
		  
		  $.ajax({
				url: 'set_session.php',
				type: 'post',
				data: {data:excel_data,order_id:usid},
				success:function(data){
					//alert(data);
					var page = "excel.php";
           			window.location = page;
				}
			});
		  
		  
			  
      });  
 });  
 </script>

</body>

</html>
<?php }mysqli_close($con);}?>