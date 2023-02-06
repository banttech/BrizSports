<?php

date_default_timezone_set("Australia/Brisbane");

$api_key = '44DD7AdXfCPX+zBFDyjYfd+sa0ept2AaqWs5jrfGACj8fczDJdF03ZL2wrg/g+eW0Wz+yg';
$api_password = 'sOrBiGFP';

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, 'https://api.ewaypayments.com/Transaction/'.$_GET['AccessCode']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $api_key . ":" . $api_password);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

$output = curl_exec($ch);
curl_close($ch);

$result = json_decode($output);

$accesscode = $_GET['AccessCode'];
								
								
$payrefnum = $result->Transactions[0]->InvoiceReference;


$amountpaid = $result->Transactions[0]->TotalAmount/100;


$datepaid = date("YmdHi");


//---------------

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

$qstudents="select * from students where payrefnum='".$payrefnum."'";
$rezstudents=mysqli_query($con,$qstudents);
$rstu=mysqli_fetch_array($rezstudents);
$fname = $rstu['fname'];
$lname = $rstu['lname'];
$nickname = $rstu['nickname'];
$size = $rstu['size'];
$orderid = $rstu['id'];
$email = $rstu['email'];
$datep = $rstu['datep'];
$quantity = $rstu['quantity'];

$datetime=substr($datep,6,2).'-'.substr($datep,4,2).'-'.substr($datep,0,4).' '.substr($datep,8,2).':'.substr($datep,10,2);
$customer=$fname.' '.$lname;
$ordernumber=$rbe['id'].'/'.$orderid;
//$amountpaid = $orderval * $quantity;
$amountpaid = number_format($amountpaid,2);

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
                    <h1 class="page-header">Payment Status</h1>

                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>Order name: <? print $ordname ?></strong><br>
                            Name: <? print $fname.' '.$lname ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
								
							<?
	
	



if ($result->Transactions[0]->TransactionStatus) {
    echo "Transaction successful";
	
	
	$q1="update students  set amountpaid='".$amountpaid."',datepaid='".$datepaid."',paidd=1,wayp='epay',accesscode='".$accesscode."' where payrefnum='".$payrefnum."'";
	$rez1=mysqli_query($con,$q1)or die(mysqli_error($con));
	
	$amountpaid = '$'.$amountpaid;
	
	// Send payment confirmation
	
	require_once('phpmailer/class.phpmailer.php');
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		
		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';

		$body = file_get_contents('emails/order-paid.htm');
		$body = str_replace('[ordername]',$ordname,$body);
		$body = str_replace('[customer]',$customer,$body);
		$body = str_replace('[nickname]',$nickname,$body);
		$body = str_replace('[size]',$size,$body);
		$body = str_replace('[ordernumber]',$ordernumber,$body);
		$body = str_replace('[quantity]',$quantity,$body);
		$body = str_replace('[amountpaid]',$amountpaid,$body);
		$body = str_replace('[datetime]',$datetime,$body);
		
		// $mail->SetFrom("sales@brizsports.com.au","Briz Sports");
		$mail->SetFrom("muzammilshahzad894@gmail.com","Briz Sports");
		$mail->Subject  = "Payment receipt for order no. ". $ordernumber;
		$mail->AddAddress($email);
		//$mail->AddBCC('ageorgievski@gmail.com'); //receipts@brizsports.com.au
		$mail->AddBCC('receipts@brizsports.com.au');
		
		$mail->MsgHTML($body);
		$send = $mail->Send();
		$mail->ClearAllRecipients();

	}
	
	
	print'<meta http-equiv="refresh" content="12; url=thankyou.php">';
	
} else {
    echo "Transaction declined";
	
	//$qxv="delete from students where payrefnum='".$payrefnum."'";
	//$rezxv=mysqli_query($con,$qxv);
	
	// Send payment is declined
	
	require_once('phpmailer/class.phpmailer.php');
	
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		
		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';

		$body = file_get_contents('emails/order-declined.htm');
		$body = str_replace('[ordername]',$ordname,$body);
		$body = str_replace('[customer]',$customer,$body);
		$body = str_replace('[nickname]',$nickname,$body);
		$body = str_replace('[size]',$size,$body);
		$body = str_replace('[ordernumber]',$ordernumber,$body);
		$body = str_replace('[quantity]',$quantity,$body);
		$body = str_replace('[amountpaid]',$amountpaid,$body);
		$body = str_replace('[datetime]',$datetime,$body);
		
		// $mail->SetFrom("sales@brizsports.com.au","Briz Sports");
		$mail->SetFrom("muzammilshahzad894@gmail.com","Briz Sports");
		$mail->Subject  = "Payment declined for order no. ". $ordernumber;
		$mail->AddAddress($email);
		//$mail->AddBCC('ageorgievski@gmail.com');
		$mail->AddBCC('receipts@brizsports.com.au');
		
		$mail->MsgHTML($body);
		$send = $mail->Send();
		$mail->ClearAllRecipients();

	}
	
	
	
	//print'Order deleted successfully!'; 
	print'<meta http-equiv="refresh" content="12; url=student-login.php">';
}
								
								echo '<br><br>';
								
								//print_r($result);
								
								echo '<br><br>';
								
								
								
								
								
								?>
								
								
								
							
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