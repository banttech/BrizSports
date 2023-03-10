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
							  if (isset($_GET['id'])) {
									$sdn=$_GET['id'];
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
    <link href="https://bsworkcopy.banttechenergies.com/order-management/css/style.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://brizsports.com.au/order-management/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link rel="stylesheet" type="text/css" media="print" href="https://bsworkcopy.banttechenergies.com/orders/print.css">
    
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
    </style>

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
                    <h1 class="page-header">Manage Orders for <? print $school ?></h1>
                </div>
                <div class="form-group col-md-4">
                	<label for="exampleFormControlSelect1">Your Orders</label>
                    <select class="form-control" id="orderid" onchange="window.location='https://bsworkcopy.banttechenergies.com/orders/dashboard.php?id=' + this.value;">
                    <?
					$qube="select * from orderrss where belto=".$_SESSION['admid']." order by id desc";
      $rezbe=mysqli_query($con,$qube);
	  while($rbe=mysqli_fetch_array($rezbe)) {
		  if($sdn==''){
			  $sdn=$rbe['sdn'];
		  }
		  //$dline=$rbe['deadline'];
		  //$methodofpayment=$rbe['methodofpayment'];
	  ?>
                      <option value="<?php print $rbe['sdn'];?>" <? if($rbe['sdn']===$sdn) {$dline=$rbe['deadline'];$oname=$rbe['ordname']; ?> selected="selected"<? } ?>><?php print $rbe['ordname'].' ('.$rbe['sdn'].')';?></option>
                      <? } ?>
                    </select><br>
                    <label>Deadline: <?php if($dline<>''){ print date("d.m.Y", strtotime($dline));}else{print '(NA)';} ?></label><a href="deadline.php?usid=<?php print $sdn;?>" style="margin-left:10px;"><button class="btn btn-primary pink btn-sm" type="button"><? if($dline==''){ ?>Set a new deadline<? }else{ ?>Modify deadline<? } ?></button></a>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row section-to-print">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Manage orders
					  </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                            <? ob_start(); ?>
								<p>Customer: <? echo $school ?></p>
								<p style="//margin-left: 45px">Order name: <? echo $oname ?></p>
								<p style="//margin-left: 45px">Order number: <? echo $sdn ?></p>
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;"><small>No.</small></th>
                                            <th style="text-align:center;"><small>First name</small></th>
                                            <th style="text-align:center;"><small>Last name</small></th>
                                            <th style="text-align:center;"><small>Class/Group</small></th>
                                            <th style="text-align:center;"><small>Date</small></th>
                                            <th style="text-align:center;"><small>Back name</small></th>
                                            <th style="text-align:center;"><small>Size</small></th>
                                            <th style="text-align:center;"><small>Quantity</small></th>
                                            <th style="text-align:center;"><small>Nick name options</small></th>
                                            <th style="text-align:center;"><small>Nick name to print</small></th>
											<th style="text-align:center;"><small>Payment made?</small></th>
											<th style="text-align:center;"><small>Amount</small></th>
											<th style="text-align:center;"><small>Date paid</small></th>
											<div class="not-to-print"><th class="not-to-print"><small>Edit Information</small></th></div>
                                            <div class="not-to-print"><th class="not-to-print"><small>Resend Receipt</small></th></div>
                                            <div class="not-to-print"><th class="not-to-print"><small>Delete</small></th></div>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $nrr=1; $ttl = 0; $aps=0;
                                            
                                            
                                            $qmop = "select * from orderrss where sdn = $sdn";
                                                $resmop=mysqli_query($con,$qmop);
                                                $rowmop=mysqli_fetch_array($resmop);
                                                $methodofpayment = $rowmop['methodofpayment'];
                                                                        
                                            if ($methodofpayment == 1){
                                                $qusers="select * from students where orderid=$sdn and amountpaid > 0 order by lname";
                                            }
                                                                        
                                            if ($methodofpayment == 0){
                                                $qusers="select * from students where orderid=$sdn order by lname";
                                            }
                                                                        
                                            
                                            $rezusers=mysqli_query($con,$qusers);
                                                                    
                                                
                                                                        
                                            while($ru=mysqli_fetch_array($rezusers))
                                        {   
                                        ?>									
                                        <tr class="<?php if($nrr%2==1){?>odd gradeA<?php }else {?>even gradeA<?php }?>">
                                            <td style="text-align:center;"><?php print $nrr;?></td>
                                            <td style="text-align:center;"><?php print $ru['fname'];?></td>
                                            <td style="text-align:center;"><?php print $ru['lname'];?></td>
                                            <td style="text-align:center;"><?php print $ru['classgroup'];?></td>
                                            <td style="text-align:center;"><?php print substr($ru['datep'],6,2).'-'.substr($ru['datep'],4,2).'-'.substr($ru['datep'],0,4);?></td>
                                            <td style="text-align:center;"><?php print $ru['nickname'];?></td>
                                            <?php
                                                $studentId = $ru['id'];
                                                $qusers2="select * from order_sizes where student_id = $studentId";
                                                $rezusers2=mysqli_query($con,$qusers2); 
                                                $orderSIzesLength = mysqli_num_rows($rezusers2);
                                                if($orderSIzesLength == 0){                                           
                                            ?>
                                            <td style="padding: 5px 0px; text-align:center;"><?php print $ru['size'];?></td>
                                            <td style="padding: 5px 0px; text-align:center;"><?php print $ru['quantity'];?></td>
                                            <td style="padding: 5px 0px; text-align:center;">
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
                                            <td style="padding: 5px 0px; text-align:center;">
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
                                            <?php }else{ ?>

                                            <td style="padding: 5px 0px; text-align:center;">
                                                <?php
                                                    while($ru2=mysqli_fetch_assoc($rezusers2)){
                                                        echo '<p style="display: block; padding: 0px 8px; margin: 0px;">'.$ru2['size'].'</p>';
                                                        $totalQuantity = $ru2['quantity'];
                                                        for($i=0; $i<$totalQuantity; $i++){
                                                            echo '<br />';
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td style="padding: 5px 0px; text-align:center;">
                                                <?php
                                                    $rezusers2=mysqli_query($con,$qusers2);
                                                    while($ru2=mysqli_fetch_assoc($rezusers2)){
                                                        echo '<p style="display: block; padding: 0px 8px; margin: 0px;">'.$ru2['quantity'].'</p>';
                                                        $totalQuantity = $ru2['quantity'];
                                                        for($i=0; $i<$totalQuantity; $i++){
                                                            echo '<br />';
                                                        }
                                                    }
                                                ?>
                                            </td>

                                            <td style="padding: 5px 0px; text-align:center;">
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
                                                            echo '<p style="display: block; padding: 0px 8px; margin: 0px;">'.$nickValue.'</p>';
                                                        }
                                                        echo '<br />';
                                                    }
                                                ?>
                                            </td>

                                            <td style="padding: 5px 0px; text-align:center;">
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
                                                            echo '<p style="display: block; padding: 0px 8px; margin: 0px;">'.$nickName.'</p>';
                                                        }
                                                        echo '<br />';
                                                    }
                                                ?>
                                            </td>
                                            <?php } ?>

											<td style="text-align:center;"><?php if($ru['paidd']==1){print 'yes';}else{print 'no';} ?></td>
											<td style="text-align:center;"><?php print $ru['amountpaid'];?></td>
											<td style="text-align:center;"><?php print substr($ru['datepaid'],6,2).'-'.substr($ru['datepaid'],4,2).'-'.substr($ru['datepaid'],0,4);?></td>
                                            <div class="not-to-print"><td class="not-to-print"><a href="edit-order.php?usid=<?php print$ru['id'];?>&oid=<?php print $sdn;?>"><button class="btn btn-primary pink btn-xs" type="button">Edit Information</button></a></td></div>

                                            <div class="not-to-print"><td class="not-to-print"><a onclick="resendReceipt(<?php print$ru['id']; ?>, <?php print $sdn; ?>)"><button class="btn btn-primary pink btn-xs" type="button">Resend Receipt</button></a></td></div>

                                            <div class="not-to-print"><td class="not-to-print"><a href="delete-order.php?usid=<?php print$ru['id'];?>&oid=<?php print $sdn;?>"><button class="btn btn-primary pink btn-xs" type="button">Delete</button></a></td></div>
											
                                        </tr>
										
<?php $ttl = $ttl + $ru['quantity']; $aps = $aps + $ru['amountpaid']; $nrr++;}?>                                        
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th style="text-align:center;"><? print $ttl ?></th>
                                            <th></th>
											<th style="text-align:center;"><? print $aps ?></th>
											<th></th>
                                            <div class="not-to-print"><th class="not-to-print"></th></div>
                                            <div class="not-to-print"><th class="not-to-print"></th></div>
                                        </tr>
                                    </tfoot>
                                </table>
                                <? $_SESSION['savepdf'] = ob_get_contents();  ?>
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
        	"info":     false,
            "scrollX": true,
            columnDefs: [
                { width: 170, targets: [8] },
                { width: 150, targets: [9]},
                { width: 100, targets: [6, 10, 12] },
                {width: 70, targets: [1, 2, 3, 5, 11]},
                {width: 80, targets: [4]},
                {width: 20, targets: [0, 7]}
            ]
        });
    });
    </script>

    <script>
    function resendReceipt(usid, sdn) {
        var r = confirm("Are you sure you want to resend the receipt?");
        if (r == true) {
            // ajax call to resend receipt
            $.ajax({
                type: "POST",
                url: "resend-receipt.php",
                data: {
                    usid: usid,
                    sdn: sdn
                },
                success: function(data) {
                    alert(data);
                }
            });
        } else {
            return false;
        }
    }
    </script>

</body>

</html>
<?php }mysqli_close($con);}?>
