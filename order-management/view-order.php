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
if(isset($_GET['usid'])&&is_numeric($_GET['usid']))
  {if(($_GET['usid']>0)&&(intval($_GET['usid'])==$_GET['usid']))
    $uid=$_GET['usid'];
   else	
    $uid=0;
  } 
else  
if(isset($_POST['usid'])&&is_numeric($_POST['usid']))
  {if(($_POST['usid']>0)&&(intval($_POST['usid'])==$_POST['usid']))
    $uid=$_POST['usid'];
   else	
    $uid=0;
  } 
else
//$uid=0;
	$uid=$_GET['usid'];
if($uid>0)
  { $q2="select * from orderrss where id=".$uid;
    $rez2=mysqli_query($con,$q2);
    if(mysqli_num_rows($rez2)==0)$uid=0;
	else
	$r2=mysqli_fetch_array($rez2);
  }
if($uid==0)
   print'<meta http-equiv="refresh" content="0; url=manage-customers.php">';
else{
							
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
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>First Name</th>
											<th>Last Name</th>
											<th>Email</th>
											<th>Date ordered</th>
											<th>Way paid</th>
											<th>Order value</th>
											<th>Sizes</th>
											<th>Quantity</th>
                                            <th>Nick name options</th>
                                            <th>Nick name to print</th>
											<th>Amount paid</th>
											<th>Date paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $nrr=1;
                                            
                                            if($r2['methodofpayment']==0){
                                                $qusers="select * from students where orderid='".$r2['sdn']."'";
                                                }else{
                                                    $qusers="select * from students where amountpaid > 0 and orderid='".$r2['sdn']."'";
                                                }
                                            
                                            $rezusers=mysqli_query($con,$qusers);
                                            while($ru=mysqli_fetch_array($rezusers))
                                        {   
                                        ?>									
                                        <tr class="<?php if($nrr%2==1){?>odd gradeA<?php }else {?>even gradeA<?php }?>">
                                            <td><?php print $ru['fname'];?></td>
											<td><?php print $ru['lname'];?></td>
											<td><?php print $ru['email'];?></td>
											<td><?php print substr($ru['datep'],6,2).'-'.substr($ru['datep'],4,2).'-'.substr($ru['datep'],0,4);?></td>
											<td><?php print $ru['wayp'];?></td>
											<td><?php print $r2['orderval'];?></td>

                                            <?php
                                                $studentId = $ru['id'];
                                                $qusers2="select * from order_sizes where student_id = $studentId";
                                                $rezusers2=mysqli_query($con,$qusers2);  
                                                $orderSIzesLength = mysqli_num_rows($rezusers2);
                                                if($orderSIzesLength == 0){
                                            ?>
                                            <td><?php print $ru['size'];?></td>
                                            <td><?php print $ru['quantity'];?></td>
                                            <td>
                                                <?php
                                                    $nickName = $ru['nickname'];
                                                    if($nickName == '(Blank)'){
                                                        echo 'Keep name space blank';
                                                    }else if($nickName == '(NA)')
                                                    {
                                                        echo 'Not Applicable';
                                                    }
                                                    else{
                                                        echo 'Write a nick name to print';
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $nickName = $ru['nickname'];
                                                    if($nickName == '(Blank)'){
                                                        echo 'Blank';
                                                    }else if($nickName == '(NA)')
                                                    {
                                                        echo 'N/A';
                                                    }
                                                    else{
                                                        echo $nickName;
                                                    }
                                                ?>
                                            </td>
                                            <?php
                                                }else{
                                            ?>
                                            <td style="padding: 5px 0px;">
                                                <?php
                                                    while($ru2=mysqli_fetch_assoc($rezusers2)){
                                                        echo '<span style="display: block; padding: 0px 8px;">'.$ru2['size'].'</span>';
                                                        $totalQuantity = $ru2['quantity'];
                                                        for($i=0; $i<$totalQuantity; $i++){
                                                            echo '<br />';
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td style="padding: 5px 0px;">
                                                <?php
                                                    $rezusers2=mysqli_query($con,$qusers2);
                                                    while($ru2=mysqli_fetch_assoc($rezusers2)){
                                                        echo '<span style="display: block; padding: 0px 8px;">'.$ru2['quantity'].'</span>';
                                                        $totalQuantity = $ru2['quantity'];
                                                        for($i=0; $i<$totalQuantity; $i++){
                                                            echo '<br />';
                                                        }
                                                    }
                                                ?>
                                            </td>

                                            <td style="padding: 5px 0px;">
                                                <?php
                                                    $rezusers2=mysqli_query($con,$qusers2);
                                                    while($ru2=mysqli_fetch_assoc($rezusers2)){
                                                        $oderSizeId = $ru2['id'];
                                                        $qusers3="select * from order_nick_name where order_sizes_id = $oderSizeId";
                                                        $rezusers3=mysqli_query($con,$qusers3);
                                                        while($ru3=mysqli_fetch_assoc($rezusers3)){
                                                            $nickValue = '';
                                                            if($ru3['nick_name_option'] == 1) {
                                                                $nickValue = 'Not applicable';
                                                            } else if($ru3['nick_name_option'] == 2) {
                                                                $nickValue = 'Keep name space blank';
                                                            } else if($ru3['nick_name_option'] == 3) {
                                                                $nickValue = 'Write a nick name to print';
                                                            }
                                                            echo '<span style="display: block; padding: 0px 8px;">'.$nickValue.'</span>';
                                                        }
                                                        echo '<br />';
                                                    }
                                                ?>
                                            </td>

                                            <td style="padding: 5px 0px;">
                                                <?php
                                                    $rezusers2=mysqli_query($con,$qusers2);
                                                    while($ru2=mysqli_fetch_assoc($rezusers2)){
                                                        $oderSizeId = $ru2['id'];
                                                        $qusers3="select * from order_nick_name where order_sizes_id = $oderSizeId";
                                                        $rezusers3=mysqli_query($con,$qusers3);
                                                        while($ru3=mysqli_fetch_assoc($rezusers3)){
                                                            $nickName = '';
                                                            if($ru3['nick_name_option'] == 1) {
                                                                $nickName = 'NA';
                                                            } else if($ru3['nick_name_option'] == 2) {
                                                                $nickName = 'Blank';
                                                            } else if($ru3['nick_name_option'] == 3) {
                                                                $nickName = $ru3['print_nick_name'];
                                                            }
                                                            echo '<span style="display: block; padding: 0px 8px;">'.$nickName.'</span>';
                                                        }
                                                        echo '<br />';
                                                    }
                                                ?>
                                            </td>
                                            <?php
                                                }
                                            ?>


											<td><?php print $r2['orderval']*$ru['quantity'];?></td>
											<td><?php print substr($ru['datepaid'],6,2).'-'.substr($ru['datepaid'],4,2).'-'.substr($ru['datepaid'],0,4);?></td>
                                        </tr>
                                        <?php $nrr++;}?>                                        
                                    </tbody>
                                </table>
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
            "scrollX": true,
            columnDefs: [
                { width: 170, targets: [8, 9] },
                { width: 100, targets: [0, 1, 3, 4, 5, 6, 7, 10, 11] },
                { orderable: false, targets: '_all' }
            ],
        });
    });
    </script>

</body>

</html>
<?php }mysqli_close($con);}}?>