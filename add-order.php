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
    <link href="https://bsworkcopy.banttechenergies.com/order-management/css/style.css" rel="stylesheet">

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
	$totalQuantity=0;
	foreach($_POST['quantity'] as $quantity){
		$totalQuantity+=$quantity;
	}
	$qstudents="select * from students where payrefnum='".$_POST['payrefnum']."'";
	$rezstudents=mysqli_query($con,$qstudents);
	$rstudents=mysqli_fetch_array($rezstudents);
	if(mysqli_num_rows($rezstudents)>0) {
		$q1="update students set fname='".$firstname."',lname='".$lastname."',classgroup='".$classgroup."',email='".$_POST['email']."',nickname='".$nickname."',orderid='".$_POST['sdn']."',datep='".$datep."',paidd='".$_POST['paym']."',size='".$_POST['sizes'][0]."',quantity='".$totalQuantity."' where payrefnum='".$_POST['payrefnum']."'";
		$rez1=mysqli_query($con,$q1)or die(mysqli_error($con));
		// first delete all sizes for this student and then insert new sizes
		$qstudents="select * from students where payrefnum='".$_POST['payrefnum']."'";
		$rezstudents=mysqli_query($con,$qstudents);
		$rstu=mysqli_fetch_array($rezstudents);
		$studentId = $rstu['id'];
		$q3="delete from order_sizes where student_id='".$studentId."'";
		$rez3=mysqli_query($con,$q3)or die(mysqli_error($con));
		// delete all from order_nick_name table
		$q4="delete from order_nick_name where student_id='".$studentId."'";
		$rez4=mysqli_query($con,$q4)or die(mysqli_error($con));
		// loop through sizes and insert into order_sizes table
		$sizecount = count($_POST['sizes']);
		$nickOptionLocation = 0;
		for($i=0;$i<$sizecount;$i++) {
			$q2="insert into order_sizes (student_id,size,quantity)values('".$studentId."','".$_POST['sizes'][$i]."','".$_POST['quantity'][$i]."')";
			$rez2=mysqli_query($con,$q2)or die(mysqli_error($con));

			// insert all nicknames for this student to order_nick_name table
			$orderSizeId = mysqli_insert_id($con);
			$quantity = $_POST['quantity'][$i];
			$nickNameOptions = $_POST['nickoptions'];
			for($j=0;$j<$quantity;$j++) {
				$q3="insert into order_nick_name (order_sizes_id, student_id, nick_name_option, print_nick_name)values('".$orderSizeId."','".$studentId."','".$nickNameOptions[$nickOptionLocation]."','".$_POST['nickname'][$nickOptionLocation]."')";
				$rez3=mysqli_query($con,$q3)or die(mysqli_error($con));
				$nickOptionLocation++;
			}
		}
	} else {
		$q1="insert into students (fname,lname,classgroup,email,nickname,orderid,datep,paidd,size,quantity,payrefnum)values('".$firstname."','".$lastname."','".$classgroup."','".$_POST['email']."','".$nickname."','".$_POST['sdn']."','".$datep."','".$_POST['paym']."','".$_POST['sizes'][0]."','".$totalQuantity."','".$_POST['payrefnum']."')";
		$rez1=mysqli_query($con,$q1)or die(mysqli_error($con));
		
		$sizecount = count($_POST['sizes']);
		$qstudents="select * from students where payrefnum='".$_POST['payrefnum']."'";
		$rezstudents=mysqli_query($con,$qstudents);
		$rstu=mysqli_fetch_array($rezstudents);
		$studentId = $rstu['id'];
		$nickOptionLocation = 0;

		for($i=0;$i<$sizecount;$i++) {
			$q2="insert into order_sizes (student_id,size,quantity)values('".$studentId."','".$_POST['sizes'][$i]."','".$_POST['quantity'][$i]."')";
			$rez2=mysqli_query($con,$q2)or die(mysqli_error($con));

			// insert all nicknames for this student to order_nick_name table
			$orderSizeId = mysqli_insert_id($con);
			$quantity = $_POST['quantity'][$i];
			$nickNameOptions = $_POST['nickoptions'];
			for($j=0;$j<$quantity;$j++) {
				$q3="insert into order_nick_name (order_sizes_id, student_id, nick_name_option, print_nick_name)values('".$orderSizeId."','".$studentId."','".$nickNameOptions[$nickOptionLocation]."', '".$_POST['nickname'][$nickOptionLocation]."')";
				$rez3=mysqli_query($con,$q3)or die(mysqli_error($con));
				$nickOptionLocation++;
			}

		}
	}
	
	// Send order confirmation
	
	$qstudents="select * from students where payrefnum='".$_POST['payrefnum']."'";
	$rezstudents=mysqli_query($con,$qstudents);
	$rstu=mysqli_fetch_array($rezstudents);
	$orderid = $rstu['id'];
	$ordernumber=$rbe['id'].'/'.$orderid;
	
	require_once('phpmailer/class.phpmailer.php');
	
	if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {

		$getSenderEmail = "select * from emails where type='sender'";
		$rezSenderEmail = mysqli_query($con,$getSenderEmail);
		$rSenderEmail = mysqli_fetch_array($rezSenderEmail);
		$senderEmail = $rSenderEmail['email'];

		$getReceiversEmails = "select * from emails where type='receiver'";
		$rezReceiversEmails = mysqli_query($con,$getReceiversEmails);
		$receiversEmails = array();
		while($rReceiversEmails = mysqli_fetch_array($rezReceiversEmails)) {
			$receiversEmails[] = $rReceiversEmails['email'];
		}



		$qOrderSizes = "select * from order_sizes where student_id='".$studentId."'";
		$rezOrderSizes = mysqli_query($con,$qOrderSizes);
		$orderSizes = array();
		while($rOrderSizes = mysqli_fetch_assoc($rezOrderSizes)) {
			$orderSizes[] = $rOrderSizes;
			// select all from order_nick_name table where order_sizes_id = $rOrderSizes['id']
			$qOrderNickName = "select * from order_nick_name where order_sizes_id='".$rOrderSizes['id']."'";
			$rezOrderNickName = mysqli_query($con,$qOrderNickName);
			$orderNickName = array();
			while($rOrderNickName = mysqli_fetch_assoc($rezOrderNickName)) {
				$orderNickName[] = $rOrderNickName;
			}
			// add orderNickName array to the orderSizes array
			$orderSizes[count($orderSizes)-1]['nicknames'] = $orderNickName;
		}

		// loop through orderSizes array and create html like this formate
		$sizesHmtl = '';
		foreach($orderSizes as $orderSize) {
			$sizesHmtl .= '<tr>
				<td style="padding: 5px; border: 1px solid #ddd;">'.$orderSize['size'].'</td>
				<td style="padding: 5px; border: 1px solid #ddd;">'.$orderSize['quantity'].'</td>
				
				<td style="padding: 5px 0px; border: 1px solid #ddd;">';
				$totalSizes = $orderSize['quantity'];
				foreach($orderSize['nicknames'] as $key => $nickname) {
					$nickValue = '';
					if($nickname['nick_name_option'] == 1) {
						$nickValue = 'Not applicable';
					} else if($nickname['nick_name_option'] == 2) {
						$nickValue = 'Keep name space blank';
					} else if($nickname['nick_name_option'] == 3) {
						$nickValue = 'Write a nick name to print';
					}
					$border = ($key < $totalSizes - 1) ? 'border-bottom: 1px solid #ddd;' : '';
					$sizesHmtl .= '<span style="display: block; '.$border.'">'.$nickValue.'</span>';
				}
				$sizesHmtl .= '</td>

				<td style="padding: 5px 0px; border: 1px solid #ddd;">';
				foreach($orderSize['nicknames'] as $key => $nickname) {
					$nickName = '';
					if($nickname['nick_name_option'] == 1) {
						$nickName = 'NA';
					} else if($nickname['nick_name_option'] == 2) {
						$nickName = 'Blank';
					} else if($nickname['nick_name_option'] == 3) {
						$nickName = $nickname['print_nick_name'];
					}
					$border = ($key < $totalSizes - 1) ? 'border-bottom: 1px solid #ddd;' : '';
					$sizesHmtl .= '<span style="display: block; '.$border.'">'.$nickName.'</span>';
				}
				$sizesHmtl .= '</td>
			</tr>';
		}

		$mail = new PHPMailer();
		$mail->CharSet = 'UTF-8';

		$body = file_get_contents('emails/order-made.htm');
		$body = str_replace('[ordername]',$ordname,$body);
		$body = str_replace('[customer]',$customer,$body);
		$body = str_replace('[nickname]',stripslashes($nickname),$body);
		$body = str_replace('[size]',$_POST['sizes'][0],$body);
		$body = str_replace('[ordernumber]',$ordernumber,$body);
		// $body = str_replace('[quantity]',$_POST['quantity'][0],$body);
		$body = str_replace('[orderSizes]',$sizesHmtl,$body);
		$body = str_replace('[datetime]',$datetime,$body);
		
		// $mail->SetFrom("sales@brizsports.com.au","Briz Sports");
		$mail->SetFrom($senderEmail,"Briz Sports");
		$mail->Subject  = "Order confirmation no. ". $ordernumber;
		$mail->AddAddress($_POST['email']);
		foreach($receiversEmails as $receiverEmail) {
			$mail->AddAddress($receiverEmail);
		}

		// //$mail->AddBCC('ageorgievski@gmail.com');
		// $mail->AddBCC('receipts@brizsports.com.au');
		
		$mail->MsgHTML($body);
		$send = $mail->Send();
		$mail->ClearAllRecipients();

		// mail($_POST['email'], "Order confirmation no. ". $ordernumber, $body, "From: muzammilshahzad894@gmail.com");

	}
	
	
   print'Information added successfully!'; 
   print'<meta http-equiv="refresh" content="2; url=thankyou.php">';   
}else if($isok==2) {
	echo '2';
	exit;
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
                                <form role="form" action="<? if($methodofpayment==0){ echo 'add-order.php'; }else{echo 'paynow.php?id='.$sdn;} ?>" enctype="multipart/form-data" method="post" class="form-inline" id="order-form">
									<div class="form-group">
										<label>
											First name 
											<button type="button" class="btn btn-secondary information_i"  type="button" class="" data-toggle="tooltip" data-placement="top" title="Enter order details for the kid unless you are ordering for yourself.">
												i
											</button>
										</label><br />
										<input class="form-control" value="<?php if(isset($_POST['fname']))print $_POST['fname'];?>" name="fname" type="text" id="fname" required autofocus/>
										<br />
										<span class="errors" id="fname_error"></span>
										<br />
										<label>Last name </label><br />
										<input class="form-control" value="<?php if(isset($_POST['lname']))print $_POST['lname'];?>" name="lname" type="text" id="lname" required /><br />
										<span class="errors" id="lname_error"></span>
										<br />
										<label>Email</label><br />
										<input class="form-control" value="<?php if(isset($_POST['email']))print $_POST['email'];?>" name="email" type="email" id="email" required /><br />
										<span class="errors" id="email_error"></span>
										<br />
										<label>
											Class/Group 
											<button type="button" class="btn btn-secondary information_i"  type="button" class="" data-toggle="tooltip" data-placement="top" title="Please enter the class group here say 6A, 6Red, 11B, etc. or Staff if you are a teacher, staff etc.">
												i
											</button>
										</label><br />
										<input class="form-control" value="<?php if(isset($_POST['classgroup']))print $_POST['classgroup'];?>" name="classgroup" type="text" id="classgroup" required /><br />
										<span class="errors" id="classgroup_error"></span>
										<br />
										<!-- <? if($ifnick<>'no') { ?>
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
										<? } ?> -->
                                        <label>Product group </label><br />
										<select class="form-control" name="pgroup" id="pgroup" required <? if($productgroup<>''){ ?>disabled<? } ?>/>
										  <option selected value="">--- please select ---</option>
                                          <option value="polos" <? if($productgroup=='polos'){ ?>selected<? } ?> >Polos & Tees</option>
                                            <option value="jerseys" <? if($productgroup=='jerseys'){ ?>selected<? } ?>>Jerseys, Jumpers & Jackets</option>
                                            <option value="sportswear" <? if($productgroup=='sportswear'){ ?>selected<? } ?>>Sportswear</option>
                                        </select><br /><br />
										<div id="parent_sizequantity">
											<div id="sizequantity1" class="sizequantity">
												<button type="button" class="btn close_button hidden" id="close_button" data-toggle="tooltip" data-placement="top" title="Remove">
													<span aria-hidden="true">&times;</span>
												</button>

												<div class="sizequantity_group">
													<div class="size">
														<label>Size</label><br />
														<select class="form-control" name="sizes[]" id="sizes" required />
														<? if($productgroup<>''){
														$qsizes="select * from sizes where product='" . $productgroup . "' order by position";
														$rsizes=mysqli_query($con,$qsizes);
														while($rowsize=mysqli_fetch_array($rsizes)){
														?>
															<option value="<? echo $rowsize['size'] ?>"><? echo $rowsize['size'] ?></option>
															<? } ?>
														<? } else { ?>}
														<option value="">--- Please choose from above ---</option>
														<? } ?>
														</select><br /><br />
													</div>
													<div class="quantity">
														<label>Quantity</label><br />
														<div>
															<input class="form-control prod_quantity" value="<?php if(isset($_POST['quantity']))print $_POST['quantity'];?>" id="quantity1" name="quantity[]" type="number" onchange="fPaymentAmount()" onkeyup="fPaymentAmount()" oninput="quantityChange(this, 'addNickNameBtn1', 'parent_nickoptions1')"  min="1" required />
															<input type="button" class="btn btn-primary add_nick_btn addNickNameBtn1 disabled" value="Add Nick Name" id="addnick" onClick="showNickNameFields('parent_nickoptions1', 'quantity1', 'addNickNameBtn1')" />
															<br /><span style="font-size:12px;">No. of pieces jersey/jacket/polo you are ordering</span><br />
															<span class="errors error_quantity" id="quantity_error1"></span>
															<br />
														</div>
													</div>
													<div class="addNickNameBtn"></div>
												</div>
												
												<? if($ifnick<>'no') { ?>
												<div id="parent_nickoptions1" class="parent_nickoptions"></div>
												<? } ?>
											</div>
										</div>
										<div class="add_size_button">
											<input type="button" class="btn btn-primary" value="Add Another Size" id="addsize" onClick="addSize()" />
										</div>

                                        <!-- <label>Size </label><br />
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
										<input class="form-control" value="<?php if(isset($_POST['quantity']))print $_POST['quantity'];?>" id="quantity" name="quantity" type="number" onchange="fPaymentAmount()" onkeyup="fPaymentAmount()" min="1" required /><span style="margin-left:10px;font-size:12px;">No. of pieces jersey/jacket/polo you are ordering</span><br /><br /> -->



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
											<input type="hidden" name="epaybtt" value="Proceed to Payment">
	  										<input type="button" class="btn btn-primary pink" value="Proceed to Payment" onClick="placeOrder()">
 										<? } else { ?>
											<input type="hidden" name="methodofpayment" value="invoice" />
											<input type="hidden" name="payrefnum" id="payrefnum" value="<? echo $payrefnum ?>" />
											<input type="hidden" class="btn btn-primary pink" name="trimi" value="Submit">
											<input type="button" class="btn btn-primary pink" value="Submit" onClick="placeOrder()">
										<? } ?>
										
										
									</div>	
								</form>
                                <?php } ?>
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
			var methodofpayment = "<?php echo $methodofpayment; ?>";
			if(methodofpayment == 0) {
				return false;
			}

			var quantity = document.getElementsByClassName('prod_quantity');
			var orderval = "<?php echo $orderval; ?>";
			var total = 0;
			for (var i = 0; i < quantity.length; i++) {
				total += quantity[i].value * orderval;
			}
			var xwithdecimals = total.toFixed(2);
			document.getElementById('paymentamount').innerHTML = xwithdecimals;
		}
		
		function quantityChange(inputField, btnClass, nickOtionsParentId){
			if((inputField.value) && (inputField.value > 0)){
				var nickOptionLength = document.getElementById(nickOtionsParentId).children.length;
				if(nickOptionLength > 0){
					if(nickOptionLength == inputField.value){
						return false;
					}
				}
				var element = document.getElementsByClassName(btnClass);
				var classList = element[0].classList.value;
				classList = classList.replace('disabled', '');
				element[0].classList = classList;
			}else{
				var element = document.getElementsByClassName(btnClass);
				var classList = element[0].classList.value;
				if(classList.indexOf('disabled') > -1){
					return false;
				}
				classList = classList + ' disabled';
				element[0].classList = classList;
			}
		}
		
		$totalSizez = 1;
		function addSize() {
			$totalSizez++;
			var parent_sizequantity = document.getElementById('parent_sizequantity');
			var sizequantity = document.getElementById('sizequantity1');
			var parentNickOptions = document.getElementById('parent_nickoptions1');
			var quantity = document.getElementById('quantity');
			var clone = sizequantity.cloneNode(true);
			clone.id = "sizequantity" + $totalSizez;

			let ifNickName = <?php echo($ifnick<>'no') ? 'true' : 'false' ?>;
			if(ifNickName){
				clone.getElementsByClassName('parent_nickoptions')[0].id = "parent_nickoptions" + $totalSizez;
				clone.getElementsByClassName('parent_nickoptions')[0].innerHTML = "";
			}
			clone.getElementsByClassName('prod_quantity')[0].id = "quantity" + $totalSizez;
			clone.getElementsByClassName('close_button')[0].className = "close_button";
			clone.getElementsByClassName('close_button')[0].setAttribute("onclick", "removeSize(this)");
			clone.getElementsByClassName('prod_quantity')[0].value = "";
			clone.getElementsByClassName('prod_quantity')[0].setAttribute("oninput", "quantityChange(this, 'addNickNameBtn" + $totalSizez + "', 'parent_nickoptions" + $totalSizez + "')");
			clone.getElementsByClassName('error_quantity')[0].id = "quantity_error" + $totalSizez;
			clone.getElementsByClassName('error_quantity')[0].innerHTML = "";
			clone.getElementsByClassName('add_nick_btn')[0].setAttribute("onclick", "showNickNameFields('parent_nickoptions" + $totalSizez + "', 'quantity" + $totalSizez + "', 'addNickNameBtn" + $totalSizez + "')");
			clone.getElementsByClassName('add_nick_btn')[0].className = "btn btn-primary add_nick_btn addNickNameBtn" + $totalSizez + " disabled";
			parent_sizequantity.appendChild(clone);
		}

		function removeSize(elem) {
			elem.parentNode.parentNode.removeChild(elem.parentNode);
			fPaymentAmount();
		}
		window.onload = function() {
			var methodofpayment = "<?php echo $methodofpayment; ?>";
			if(methodofpayment == 1) {
				fPaymentAmount();
			}
		}


		function showNickNameFields(fieldId, quantityId, btnClass){
			const itemQuantity = document.getElementById(quantityId).value;

			if(!itemQuantity){
				return false;
			}

			const quantity = itemQuantity;
			let ifNickName = <?php echo($ifnick<>'no') ? 'true' : 'false' ?>;
			if(!ifNickName){
				return false;
			}

			if(ifNickName){
				for(var i = 0; i <= quantity; i++){
					addNickNameFields(fieldId, quantity);
				}
				var element = document.getElementsByClassName(btnClass);
				var classList = element[0].classList.value;
				classList = classList + ' disabled';
				element[0].classList = classList;
			}
		}	

		var id = 1;
		
		function addNickNameFields(fieldId, quantity){
			let html = '<div class="nickoptions" id="nickname_field_'+id+'"><label>Nick name options </label><br /><select class="form-control" name="nickoptions[]" id="nickoptions" onclick="showNickName(this)" required><option value="">--- please select ---</option><option value="1">Not applicable</option><option value="2">Keep name space blank</option><option value="3">Write a nick name to print</option></select><span class="select_nickname_error errors" id="select_nickname_error'+id+'"></span><div id="shownick_'+id+'" class="write_nick_name" style="display:none;"><br><label>Nick name to print </label><br /><input class="form-control" value="<?php if(isset($_POST['nickname']))print $_POST['nickname'];?>" name="nickname[]" type="text" /></div><span class="nickname_error errors" id="nickname_error'+id+'"></span><br<br /><br /></div>';

			if(quantity < $('#'+fieldId).find('.nickoptions').length){
				var diff = $('#'+fieldId).find('.nickoptions').length - quantity;
				for(var i = 0; i < diff; i++){
					$('#'+fieldId).find('.nickoptions').last().remove();
				}
			}else{
				var diff = quantity - $('#'+fieldId).find('.nickoptions').length;
				if(diff > 0){
					$('#'+fieldId).append(html);
				}
			}
			id++;
		}

		function showNickName(elem){
			var id = elem.parentNode.id.split('_')[2];
			if(elem.value == 3){
				$('#shownick_'+id).show();
			}else{
				$('#shownick_'+id).hide();
			}
		}

	</script>


	<script>
		function placeOrder(){
			var fname = document.getElementById('fname').value;
			if(fname == ""){
				document.getElementById('fname_error').innerHTML = "Please enter your first name";
				document.getElementById('fname').scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
				return false;
			}else{
				document.getElementById('fname_error').innerHTML = "";
			}

			var lname = document.getElementById('lname').value;
			if(lname == ""){
				document.getElementById('lname_error').innerHTML = "Please enter your last name";
				document.getElementById('lname').scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
				return false;
			}else{
				document.getElementById('lname_error').innerHTML = "";
			}

			var email = document.getElementById('email').value;
			if(email == ""){
				document.getElementById('email_error').innerHTML = "Please enter your email";
				document.getElementById('email').scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
				return false;
			}else{
				document.getElementById('email_error').innerHTML = "";
			}

			var classgroup = document.getElementById('classgroup').value;
			if(classgroup == ""){
				document.getElementById('classgroup_error').innerHTML = "Please select your class group";
				document.getElementById('classgroup').scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
				return false;
			}else{
				document.getElementById('classgroup_error').innerHTML = "";
			}


			// get all the childs where id is parent_sizequantity and print the length of it
			var parentSizeQuantity = document.getElementById('parent_sizequantity').children.length;
			for(var i = 0; i < parentSizeQuantity; i++){
				var id = document.getElementById('parent_sizequantity').children[i].id;
				var position = id.substr(id.length - 1);
				var quantity = document.getElementById('quantity'+position).value;
				if(quantity == ""){
					document.getElementById('quantity_error'+position).innerHTML = "Please enter quantity";
					document.getElementById('quantity'+position).scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
					return false;
				}else{
					document.getElementById('quantity_error'+position).innerHTML = "";
				}
				var parentNickOptions = document.getElementById('parent_nickoptions'+position).children.length;
				if(quantity > parentNickOptions){
					document.getElementById('quantity_error'+position).innerHTML = "Please click on add nick name button";
					document.getElementById('quantity'+position).scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
					return false;
				}else if(quantity < parentNickOptions){
					document.getElementById('quantity_error'+position).innerHTML = "Please click on add nick name button";
					document.getElementById('quantity'+position).scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
					return false;
				}else{
					document.getElementById('quantity_error'+position).innerHTML = "";
				}

				var totalNickName = document.getElementById('parent_nickoptions'+position).children;

				// loop through the parentNickOptions and get the value of the select tag from each child of totalNickName
				for(var j = 0; j < parentNickOptions; j++){
					// inside child find the value where id is nickoptions
					var nickOptions = totalNickName[j].children[2].value;
					var nickErrorId = totalNickName[j].children[3].id;
					if(nickOptions == ""){
						document.getElementById(nickErrorId).innerHTML = "Please select nick name";
						document.getElementById(nickErrorId).scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
						return false;
					}	else{
						document.getElementById(nickErrorId).innerHTML = "";
					}

					if(nickOptions == 3){
						var writeNickName = totalNickName[j].children[4];
						var nickNameId = writeNickName.id.substr(writeNickName.id.length - 1);
						var nickNameValue = writeNickName.getElementsByTagName('input')[0].value;
						if(nickNameValue == ""){
							document.getElementById('nickname_error'+nickNameId).innerHTML = "Please enter nick name";
							document.getElementById('nickname_error'+nickNameId).scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
							return false;
						}else{
							document.getElementById('nickname_error'+nickNameId).innerHTML = "";
						}
					}
				}
			}
			$('#order-form').submit();
		}
	</script>

</body>

</html>