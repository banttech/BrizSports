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
$productgroup = $rbe['productgroup'];
$ifnick = $rbe['nickname'];

$now = date("Y-m-d");

if($deadline<>''){

if ($now > $deadline){
	header("Location: order-login.php?expired");
	die();
}else{
	$deadline = date("d.m.Y", strtotime($deadline));
}
	
}else{
	$deadline = '(NA)';
}

$qusers="select * from customers where id=".$customer;
$rezusers=mysqli_query($con,$qusers);
$ru=mysqli_fetch_array($rezusers);
$school = $ru['custname'];

$payrefnum = uniqid();

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
                    <h1 class="page-header">Add Order for <? print $school ?></h1>
                    <p class="text-danger">Please fill out all information carefully and correctly. To make any changes please contact your coordinator.</p>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <strong>Order name: <? print $ordname ?></strong><br>Add new order till <? print $deadline ?>
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
<?

$isok=0;
$err="";
if(isset($_POST['trimi'])) { $isok=1; }
if(isset($_POST['epaybtt'])) { $isok=2; }

if($isok==1) {
	if($_POST['nickoptions']==1){$nickname='(NA)';};
	if($_POST['nickoptions']==2){$nickname='(Blank)';};
	if($_POST['nickoptions']==3){$nickname=mysqli_real_escape_string($con, $_POST['nickname']);};
	if($_POST['nickoptions']==''){$nickname='(Blank)';};
	
	$firstname=mysqli_real_escape_string($con, $_POST['fname']);
	$lastname=mysqli_real_escape_string($con, $_POST['lname']);
	$classgroup=mysqli_real_escape_string($con, $_POST['classgroup']);
	
   $datep=date("YmdHi");
	$datetime=substr($datep,6,2).'-'.substr($datep,4,2).'-'.substr($datep,0,4).' '.substr($datep,8,2).':'.substr($datep,10,2);
	$customer=$_POST['fname'].' '.$_POST['lname'];

	// find payrefnum if exist then update else insert
	$qstudents="select * from students where payrefnum='".$_POST['payrefnum']."'";
	$rezstudents=mysqli_query($con,$qstudents);
	$rstudents=mysqli_fetch_array($rezstudents);
	if(mysqli_num_rows($rezstudents)>0) {
		$q1="update students set fname='".$firstname."',lname='".$lastname."',classgroup='".$classgroup."',email='".$_POST['email']."',nickname='".$nickname."',orderid='".$_POST['sdn']."',datep='".$datep."',paidd='".$_POST['paym']."',size='".$_POST['sizes']."',quantity='".$_POST['quantity']."' where payrefnum='".$_POST['payrefnum']."'";
		$rez1=mysqli_query($con,$q1)or die(mysqli_error($con));
	} else {
		$q1="insert into students (fname,lname,classgroup,email,nickname,orderid,datep,paidd,size,quantity,payrefnum)values('".$firstname."','".$lastname."','".$classgroup."','".$_POST['email']."','".$nickname."','".$_POST['sdn']."','".$datep."','".$_POST['paym']."','".$_POST['sizes']."','".$_POST['quantity']."','".$_POST['payrefnum']."')";
		$rez1=mysqli_query($con,$q1)or die(mysqli_error($con));
	}
	
	
	// Send order confirmation
	
	$qstudents="select * from students where payrefnum='".$_POST['payrefnum']."'";
	$rezstudents=mysqli_query($con,$qstudents);
	$rstu=mysqli_fetch_array($rezstudents);
	$orderid = $rstu['id'];
	$ordernumber=$rbe['id'].'/'.$orderid;
	
	require_once('phpmailer/class.phpmailer.php');
	
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
		
		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';

		$body = file_get_contents('emails/order-made.htm');
		$body = str_replace('[ordername]',$ordname,$body);
		$body = str_replace('[customer]',$customer,$body);
		$body = str_replace('[nickname]',stripslashes($nickname),$body);
		$body = str_replace('[size]',$_POST['sizes'],$body);
		$body = str_replace('[ordernumber]',$ordernumber,$body);
		$body = str_replace('[quantity]',$_POST['quantity'],$body);
		$body = str_replace('[datetime]',$datetime,$body);
		
		// $mail->SetFrom("sales@brizsports.com.au","Briz Sports");
		$mail->SetFrom("muzammilshahzad894@gmail.com","Briz Sports");
		$mail->Subject  = "Order confirmation no. ". $ordernumber;
		$mail->AddAddress($_POST['email']);
		//$mail->AddBCC('ageorgievski@gmail.com');
		$mail->AddBCC('receipts@brizsports.com.au');
		
		$mail->MsgHTML($body);
		$send = $mail->Send();
		$mail->ClearAllRecipients();

		// mail($_POST['email'], "Order confirmation no. ". $ordernumber, $body, "From: muzammilshahzad894@gmail.com");

	}
	
	
   print'Information added successfully!'; 
   print'<meta http-equiv="refresh" content="2; url=thankyou.php">';   
}else if($isok==2) {
	//echo $orderval.'<br>'.$_POST['quantity'];
	
	if($_POST['nickoptions']==1){$nickname='(NA)';};
	if($_POST['nickoptions']==2){$nickname='(Blank)';};
	if($_POST['nickoptions']==3){$nickname=mysqli_real_escape_string($con, $_POST['nickname']);};
	if($_POST['nickoptions']==''){$nickname='(Blank)';};
	
	$firstname=mysqli_real_escape_string($con, $_POST['fname']);
	$lastname=mysqli_real_escape_string($con, $_POST['lname']);
	$classgroup=mysqli_real_escape_string($con, $_POST['classgroup']);
	
   $datep=date("YmdHi");
   $q1="insert into students (fname,lname,classgroup,email,nickname,orderid,datep,paidd,size,quantity,payrefnum)values('".$firstname."','".$lastname."','".$classgroup."','".$_POST['email']."','".$nickname."','".$_POST['sdn']."','".$datep."','".$_POST['paym']."','".$_POST['sizes']."','".$_POST['quantity']."','".$payrefnum."')";
   $rez1=mysqli_query($con,$q1)or die(mysqli_error($con));
	
	header('Location: https://orders.brizsports.com.au/paynow.php');
	die();
	
	
}else{
  if(trim($err)!="") print'<div style="color:red">'.$err.'</div>';
?>							
                                <form role="form" action="<? if($methodofpayment==0){ echo 'add-order.php'; }else{echo 'paynow.php?id='.$sdn;} ?>" enctype="multipart/form-data" method="post" class="form-inline">
									<div class="form-group">
										<label>First name </label><br />
										<input class="form-control" value="<?php if(isset($_POST['fname']))print $_POST['fname'];?>" name="fname" type="text" required autofocus/><br /><br />
										<label>Last name </label><br />
										<input class="form-control" value="<?php if(isset($_POST['lname']))print $_POST['lname'];?>" name="lname" type="text" required /><br /><br />
										<label>Email</label><br />
										<input class="form-control" value="<?php if(isset($_POST['email']))print $_POST['email'];?>" name="email" type="email" required /><br /><br />
										<label>Class/Group </label><br />
										<input class="form-control" value="<?php if(isset($_POST['classgroup']))print $_POST['classgroup'];?>" name="classgroup" type="text" required /><br /><br />
										<? if($ifnick<>'no') { ?>
										<label>Nick name options </label><br />
                                        <select class="form-control" name="nickoptions" id="nickoptions" required>
										  <option value="">--- please select ---</option>
                                          <option value="1">Not applicable</option>
										  <option value="2">Keep name space blank</option>
                                          <option value="3">Write a nick name to print</option>
                                        </select>
                                        <div id="shownick" style="display:none;"><br><label>Nick name to print </label><br />
										<input class="form-control" value="<?php if(isset($_POST['nickname']))print $_POST['nickname'];?>" name="nickname" id="nickname" type="text" /></div>
                                        <br /><br />
										<? } ?>
                                        <label>Product group </label><br />
										<select class="form-control" name="pgroup" id="pgroup" required <? if($productgroup<>''){ ?>disabled<? } ?>/>
										  <option selected value="">--- please select ---</option>
                                          <option value="polos" <? if($productgroup=='polos'){ ?>selected<? } ?> >Polos & Tees</option>
                                            <option value="jerseys" <? if($productgroup=='jerseys'){ ?>selected<? } ?>>Jerseys, Jumpers & Jackets</option>
                                            <option value="sportswear" <? if($productgroup=='sportswear'){ ?>selected<? } ?>>Sportswear</option>
                                        </select><br /><br />
                                        <label>Size </label><br />
										<select class="form-control" name="sizes" id="sizes" required />
										<? if($productgroup<>''){ 
											$qsizes="select * from sizes where product='" . $productgroup . "'";
											$rsizes=mysqli_query($con,$qsizes);
											while($rowsize=mysqli_fetch_array($rsizes)){
									
									
									?>
											<option value="<? echo $rowsize['size'] ?>"><? echo $rowsize['size'] ?></option>
											<? } ?>
										<? } else { ?>}
										  <option value="">--- Please choose from above ---</option>
										<? } ?>
                                        </select><br /><br />
                                        
										<label>Quantity</label><br />
										<input class="form-control" value="<?php if(isset($_POST['quantity']))print $_POST['quantity'];?>" id="quantity" name="quantity" type="number" onchange="fPaymentAmount()" onkeyup="fPaymentAmount()" min="1" required /><span style="margin-left:10px;font-size:12px;">No. of pieces jersey/jacket/polo you are ordering</span><br /><br />
										<? if ($methodofpayment==0){ ?>
                                        <label>Payment made? </label><br />
										<select class="form-control" name="paym">
										  <option value="1">Yes</option>
										  <option value="0" selected>No</option>
                                        </select><br /><br />
										<? } ?>
										<? if ($methodofpayment==1){ ?>
										<p style="font-size: 18px;font-weight: bold;margin-top: 20px;margin-bottom: 30px;">Payment amount: $<span id="paymentamount">0.00</span></p>
										<? } ?>
                                    	<input type="hidden" name="sdn" value="<? print $sdn ?>" />

										
										<? if ($methodofpayment==1){ ?>
										
											<input type="hidden" name="methodofpayment" id="methodofpayment" value="epayment" />
											<input type="hidden" name="payrefnum" id="payrefnum" value="<? echo $payrefnum ?>" />
										
	  										<input type="submit" class="btn btn-primary pink" name="epaybtt" value="Proceed to Payment">
 										<? } else { ?>
											<input type="hidden" name="methodofpayment" value="invoice" />
										<input type="hidden" name="payrefnum" id="payrefnum" value="<? echo $payrefnum ?>" />
											<input type="submit" class="btn btn-primary pink" name="trimi" value="Submit">
										<? } ?>
										
										
										
										
									</div>	
								</form>
                                <?php }?>
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
	
	
	<script type="text/javascript">
		function fPaymentAmount() {

			var orderval = "<?php echo $orderval; ?>";
			var x = document.getElementById('quantity').value * orderval;
			var xwithdecimals = x.toFixed(2);
			document.getElementById('paymentamount').innerHTML = xwithdecimals;

		}
	</script>

</body>

</html>