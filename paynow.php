<?php

date_default_timezone_set("Australia/Brisbane");

include("conc.php");
$sdn=$_GET['id'];
if ($sdn==''){$sdn=$_POST['sdn'];};

$qube="select * from orderrss where sdn=".$sdn;
$rezbe=mysqli_query($con,$qube);
$rbe=mysqli_fetch_array($rezbe);
$deadline = $rbe['deadline'];
$customer = $rbe['belto'];
$ordname = $rbe['ordname'];
$methodofpayment = $rbe['methodofpayment'];
$orderval = $rbe['orderval'];

$qusers="select * from customers where id=".$customer;
$rezusers=mysqli_query($con,$qusers);
$ru=mysqli_fetch_array($rezusers);
$school = $ru['custname'];

$check_duplicate="select * from students where payrefnum='".$_POST['payrefnum']."'";
$res_duplicate=mysqli_query($con,$check_duplicate);

//$payrefnum = uniqid();

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
		.insert-symbol {
			margin-top: 10px;
		}
		.symbols {
			margin-left: 10px;
			font-size: 18px;
			cursor: pointer;
		}
    </style>
    
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>

	<script>
		$(function() {
		
			
			
			$("#pgroup").change(function() {
			
				var $dropdown = $(this);
			
				$.getJSON("jsondata/data.json", function(data) {
				
					var key = $dropdown.val();
					var vals = [];
										
					switch(key) {
						
						case 'polos':
							vals = data.polos.split(",");
							break;
						case 'jerseys':
							vals = data.jerseys.split(",");
							break;
						case 'sportswear':
							vals = data.sportswear.split(",");
							break;
						case 'base':
							vals = ['Please choose from above'];
					}
					
					var $jsontwo = $("#sizes");
					$jsontwo.empty();
					$.each(vals, function(index, value) {
						$jsontwo.append("<option value=" + value + ">" + value + "</option>");
					});
			
				});
			});

		});
	</script>

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
                <a class="navbar-brand" href="student-login.php"><img src="https://brizsports.com.au/order-management/images/logo.png" alt="Brizsports payment settings management" title="Brizsports payment settings management" /><img src="https://brizsports.com.au/order-management/images/briz-leavers-logo.png" alt="Brizsports orders management" title="Brizsports orders management" style="margin-left:25px;"></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">

                <!-- /.dropdown -->

                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->


            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper" style="margin:0;">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Pay Your Order</h1>

                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>Order name: <? print $ordname ?></strong><br>
                            Name: <? print $_POST['fname'].' '.$_POST['lname'] ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
								
							<?
	
	if($_POST['nickoptions']==1){$nickname='(NA)';};
	if($_POST['nickoptions']==2){$nickname='(Blank)';};
	if($_POST['nickoptions']==3){$nickname=mysqli_real_escape_string($con, $_POST['nickname']);};
	if($_POST['nickoptions']==''){$nickname='(Blank)';};
								
	$firstname=mysqli_real_escape_string($con, $_POST['fname']);
	$lastname=mysqli_real_escape_string($con, $_POST['lname']);
	$classgroup=mysqli_real_escape_string($con, $_POST['classgroup']);
							
   $datep=date("YmdHi");
	if (mysqli_num_rows($res_duplicate)==0){
   $q1="insert ignore into students (fname,lname,classgroup,email,nickname,orderid,datep,paidd,size,quantity,payrefnum)values('".$firstname."','".$lastname."','".$classgroup."','".$_POST['email']."','".$nickname."','".$_POST['sdn']."','".$datep."','".$_POST['paym']."','".$_POST['sizes']."','".$_POST['quantity']."','".$_POST['payrefnum']."')";
   $rez1=mysqli_query($con,$q1)or die(mysqli_error($con));			
	}else{
        $q1="update students set fname='".$firstname."',lname='".$lastname."',classgroup='".$classgroup."',email='".$_POST['email']."',nickname='".$nickname."',orderid='".$_POST['sdn']."',datep='".$datep."',paidd='".$_POST['paym']."',size='".$_POST['sizes']."',quantity='".$_POST['quantity']."',payrefnum='".$_POST['payrefnum']."' where payrefnum='".$_POST['payrefnum']."'";
        $rez1=mysqli_query($con,$q1)or die(mysqli_error($con));
    }							
								
								?>
								
								
								
							<p>Your payment will be securely processed by Eway Australia using VISA or MASTER card.</p>
							<p>* No payment processing fee applies<br>
							  * No EFT payment option available
							</p>
							<p>&nbsp;</p>
								
                                <script src="https://secure.ewaypayments.com/scripts/eCrypt.js"
											   class="eway-paynow-button"
											   data-publicapikey="epk-4AFB123D-4891-4D3B-A8E7-FE2DD5FC3FAF"
											   data-amount="<? echo $orderval*$_POST['quantity']*100 ?>"
												data-invoiceref="<? echo $_POST['payrefnum']; ?>"
												data-label="Pay now"
											   data-currency="AUD"
												data-submitform="yes"
												data-resulturl="https://bsworkcopy.banttechenergies.com/afterpay.php?id=<? echo $sdn ?>">
											</script>
								
								<!-- Begin Eway Linking Code -->
<div id="EwayBlock">
    <div style="text-align:left;margin-top: 120px;">
        <a href="https://www.eway.com.au/developers/secure-site-seal?i=12&se=3&theme=1" title="Eway Payment Gateway" target="_blank" rel="nofollow">
            <img alt="Eway Payment Gateway" src="https://www.eway.com.au/developers/developer/payment-code/verified-seal.php?img=12&size=3&theme=1" />
        </a>
    </div>
</div>
<!-- End Eway Linking Code -->
								
								
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
	function addText(event) {
		var targ = event.target || event.srcElement;
		document.getElementById("nickname").value += targ.textContent || targ.innerText;
		document.getElementById("nickname").focus();
		document.getElementById("nickname").selectionEnd= end;
	}
	</script>
    
    <script  src="js/nickname.js"></script>

</body>

</html>