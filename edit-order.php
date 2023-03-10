<?php session_start();
      include("conc.php");
	if((!isset($_SESSION['admid']))||(!isset($_SESSION['unam']))||(!isset($_SESSION['pass'])))
	{print'<h3>Incorrect login information</h3>';
                                   print'<meta http-equiv="refresh" content="2; url=index.php">';
    }
	else
	{
      $q1="select * from customers where email='".$_SESSION['unam']."' and passwoo='".$_SESSION['pass']."' and id=".$_SESSION['admid'];
      $rez1=mysqli_query($con,$q1);
      if(mysqli_num_rows($rez1)==0){print'<h3>Incorrect login information</h3>';
                                   print'<meta http-equiv="refresh" content="2; url=index.php">';
                                  }
							else{include("functions.php");
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
$uid=0;
if($uid>0)
  { $q2="select * from students where id=".$uid;
    $rez2=mysqli_query($con,$q2);
    if(mysqli_num_rows($rez2)==0)$uid=0;
	else
	$r2=mysqli_fetch_array($rez2);
  }
if($uid==0)
   print'<meta http-equiv="refresh" content="0; url=dashboard.php">';
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
                    <h1 class="page-header">Edit order</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edit order
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
<?
$isok=0;
  $err="";
  if(isset($_POST['trimi']))
  {$isok=1;}
   
  if($isok==1) {
	$oldQuantity = $_POST['old_quantity'];
	$updatedQuantity = $_POST['updated_quantity'];
	$checkSizes = $_POST['checkSizes'];
	$studentDetails = "select * from students where id='".$uid."'";
	$studentDetailsResult = mysqli_query($con,$studentDetails)or die(mysqli_error($con));
	$studentDetailsRow = mysqli_fetch_assoc($studentDetailsResult);

	$orderDetails = "select * from orderrss where sdn='".$studentDetailsRow['orderid']."'";
	$orderDetailsResult = mysqli_query($con,$orderDetails)or die(mysqli_error($con));
	$orderDetailsRow = mysqli_fetch_assoc($orderDetailsResult);	

	if($orderDetailsRow['methodofpayment'] == 1 && $studentDetailsRow['amountpaid'] > 0){
		$updatedPrice = $updatedQuantity * $orderDetailsRow['orderval'];
		$q3 = "update students set fname='".$_POST['fname']."',lname='".$_POST['lname']."', paidd='".$_POST['paym']."', quantity='".intval($updatedQuantity)."', amountpaid='".$updatedPrice."' where id='".$uid."'";
		$rez3=mysqli_query($con,$q3)or die(mysqli_error($con));
	}else{
		$q3 = "update students set fname='".$_POST['fname']."',lname='".$_POST['lname']."', paidd='".$_POST['paym']."', quantity='".intval($updatedQuantity)."' where id='".$uid."'";
		$rez3=mysqli_query($con,$q3)or die(mysqli_error($con));
	}

	$q3="delete from order_sizes where student_id='".$uid."'";
	$rez3=mysqli_query($con,$q3)or die(mysqli_error($con));
	// delete all from order_nick_name table
	$q4="delete from order_nick_name where student_id='".$uid."'";
	$rez4=mysqli_query($con,$q4)or die(mysqli_error($con));

	$sizecount = count($_POST['sizes']);
	$nickOptionLocation = 0;
	for($i=0;$i<$sizecount;$i++) {
		$q2="insert into order_sizes (student_id,size,quantity)values('".$uid."','".$_POST['sizes'][$i]."','".$_POST['quantities'][$i]."')";
		$rez2=mysqli_query($con,$q2)or die(mysqli_error($con));

		// insert all nicknames for this student to order_nick_name table
		$orderSizeId = mysqli_insert_id($con);
		$quantity = $_POST['quantities'][$i];
		$nickNameOptions = $_POST['nickoptions'];
		for($j=0;$j<$quantity;$j++) {
			$q3="insert into order_nick_name (order_sizes_id, student_id, nick_name_option, print_nick_name)values('".$orderSizeId."','".$uid."','".$nickNameOptions[$nickOptionLocation]."','".$_POST['nickname'][$nickOptionLocation]."')";
			$rez3=mysqli_query($con,$q3)or die(mysqli_error($con));
			$nickOptionLocation++;
		}
	}

	if($oldQuantity > $updatedQuantity){
		if($orderDetailsRow['methodofpayment'] == 1 && $studentDetailsRow['amountpaid'] > 0){
			$checkAlreadyRefund = "select * from refund where student_id='".$uid."' and order_id='".$orderDetailsRow['sdn']."'";
			$checkAlreadyRefundResult = mysqli_query($con,$checkAlreadyRefund)or die(mysqli_error($con));
			$checkAlreadyRefundRow = mysqli_fetch_assoc($checkAlreadyRefundResult);
			if(mysqli_num_rows($checkAlreadyRefundResult) > 0){
				$orderId = $orderDetailsRow['sdn'];
				$studentId = $studentDetailsRow['id'];
				$productPrice = $orderDetailsRow['orderval'];
				$pr_qty = $checkAlreadyRefundRow['updt_qty'];
				$updt_qty = $updatedQuantity;
				$pr_price = $checkAlreadyRefundRow['updt_price'];
				$updt_price = $productPrice*$updt_qty;
				$refundede_amt = ($pr_price - $updt_price) + $checkAlreadyRefundRow['refundede_amt'];

				$storeRefund = "update refund set order_id='".$orderId."', student_id='".$studentId."', product_price='".$productPrice."', pr_qty='".$pr_qty."', updt_qty='".$updt_qty."', pr_price='".$pr_price."', updt_price='".$updt_price."', refundede_amt='".$refundede_amt."' where student_id='".$uid."' and order_id='".$orderDetailsRow['sdn']."'";
				$storeRefundResult = mysqli_query($con,$storeRefund)or die(mysqli_error($con));
			}else{
				$orderId = $orderDetailsRow['sdn'];
				$studentId = $studentDetailsRow['id'];
				$productPrice = $orderDetailsRow['orderval'];
				$pr_qty = $oldQuantity;
				$updt_qty = $updatedQuantity;
				$pr_price = $productPrice*$pr_qty;
				$updt_price = $productPrice*$updt_qty;
				$refundede_amt = $pr_price - $updt_price;
		
				$storeRefund = "insert into refund (order_id, student_id, product_price, pr_qty, updt_qty, pr_price, updt_price, refundede_amt) values('".$orderId."','".$studentId."','".$productPrice."','".$pr_qty."','".$updt_qty."','".$pr_price."','".$updt_price."','".$refundede_amt."')";
				$storeRefundResult = mysqli_query($con,$storeRefund)or die(mysqli_error($con));
			}
		}
	}
	print'Information updated successfully!'; 
   	print'<meta http-equiv="refresh" content="2; url=dashboard.php?id='.$_POST['sdn'].'">'; 
  }
  else{
  if(trim($err)!="") print'<div style="color:red">'.$err.'</div>';
?>							
                                <form role="form" action="edit-order.php" method="post" class="form-inline" id="update_order_form">
								<input type="hidden" name="usid" value="<?php print $uid;?>">
								<input type="hidden" name="exisuser" value="<?php print $r2['isactive'];?>">
									<div class="form-group">
										<label>First name </label><br />
										<input class="form-control" value="<?php if(isset($_POST['fname']))print $_POST['fname'];else print $r2['fname'];?>" name="fname" type="text" id="fname" required />
										<br />
										<span class="errors" id="fname_error"></span>
										<br />
										<label>Last name </label><br />
										<input class="form-control" value="<?php if(isset($_POST['lname']))print $_POST['lname'];else print $r2['lname'];?>" name="lname" type="text" id="lname" required />
										<br />
										<span class="errors" id="lname_error"></span>
										<br />

                                        <div id="parent_sizequantity">
											<?php 
												$orderSizes = "select * from order_sizes where student_id = " . $uid;
												$orderSizesResult = mysqli_query($con,$orderSizes);
												$totalOrderSizes = mysqli_num_rows($orderSizesResult);
												$sizeCount = 0;
												$nickNameCount = 0;
												$totalQuantity = 0;
												if($totalOrderSizes > 0){
													while($orderSizesRow = mysqli_fetch_array($orderSizesResult)){
														$sizeCount++;
														$totalQuantity += $orderSizesRow['quantity'];
											?>
											<div id="sizequantity_multiple<?php print $sizeCount;?>" class="sizequantity_multiple">
												<button type="button" class="close_button_multiple <?php if($sizeCount == 1){print 'hidden';}?>" id="close_button_multiple" data-toggle="tooltip" data-placement="top" title="Remove" onclick="removeSize(this);">
													<span aria-hidden="true">&times;</span>
												</button>
												<div class="sizequantity_group_multiple">
													<div class="size_multiple">
														<label>Size</label><br />
														<?php
                                                            $qube="select * from orderrss where sdn=".$_GET['oid'];
                                                            $rezbe=mysqli_query($con,$qube);
                                                            $rbe=mysqli_fetch_array($rezbe);
                                                            $productgroup = $rbe['productgroup'];
                                                        ?>
														<select class="form-control" name="sizes[]" id="sizes_multiple" required />
														<?php
															$qsizes="select * from sizes where product='" . $productgroup . "' order by position";
															$rsizes=mysqli_query($con,$qsizes);
															while($rs=mysqli_fetch_array($rsizes)){
																if($rs['size']==$orderSizesRow['size']){
																	print'<option value="'.$rs['size'].'" selected>'.$rs['size'].'</option>';
																}else{
																	print'<option value="'.$rs['size'].'">'.$rs['size'].'</option>';
																}
															}
														?>
														</select>
													</div>
													<div class="quantity_multiple">
														<label>Quantity</label><br />
														<input class="form-control prod_quantity_multiple" value="<?php print $orderSizesRow['quantity'];?>" name="quantities[]" type="number" min="1" required id="quantity_multiple<?php print $sizeCount;?>" oninput="quantityChange(this, 'add_nickname_multiple<?php print $sizeCount;?>', 'parent_nickoptions_multiple<?php print $sizeCount;?>')" />
														<input type="button" class="btn btn-primary add_nick_btn_multiple add_nickname_multiple<?php print $sizeCount;?> disabled" value="Add Nick Name" id="addnickMultiple" onClick="showNickNameFields('parent_nickoptions_multiple<?php print $sizeCount;?>', 'quantity_multiple<?php print $sizeCount;?>', 'add_nickname_multiple<?php print $sizeCount;?>')" />
														<br /><span style="font-size:12px;">No. of pieces jersey/jacket/polo you are ordering</span><br />
														<span class="errors error_quantity_multiple" id="quantity_error_multiple<?php print $sizeCount;?>"></span>
														<br />
													</div>
												</div>
												<div id="parent_nickoptions_multiple<?php print $sizeCount;?>" class="parent_nickoptions_multiple">
												<?php
													$nickNameQuery = "select * from order_nick_name where order_sizes_id = " . $orderSizesRow['id'];
													$nickNameResult = mysqli_query($con,$nickNameQuery);
													while($nickNameRow = mysqli_fetch_array($nickNameResult)){
														$nickNameCount++;
												?>
												<div class="nickoptions_multiple" id="nickname_field_multiple_<?php print($nickNameCount) ?>">
													<label>Nick name options </label><br />
													<select class="form-control" name="nickoptions[]" id="nickoptions_multiple_<?php print($nickNameCount) ?>" onchange="showNickName(this)" required>
														<option value="">--- please select ---</option>
														<option value="1" <?php if($nickNameRow['nick_name_option']==1) print 'selected'; ?>>Not applicable</option>
														<option value="2" <?php if($nickNameRow['nick_name_option']==2) print 'selected'; ?>>Keep name space blank</option>
														<option value="3" <?php if($nickNameRow['nick_name_option']==3) print 'selected'; ?>>Write a nick name to print</option>
													</select>
													<span class="select_nickname_error_multiple errors" id="select_nickname_error_multiple_<?php print($nickNameCount) ?>"></span>
													<div id="shownick_multiple_<?php print($nickNameCount) ?>" class="write_nick_name_multiple" style="display: <?php if($nickNameRow['nick_name_option']==3) print 'block'; else print 'none'; ?>;">
														<br>
														<label>Nick name to print </label><br />
														<input class="form-control" value="<?php print $nickNameRow['print_nick_name'];?>" name="nickname[]" type="text" />
													</div>
													<span class="nickname_error_multiple errors" id="nickname_error_multiple_<?php print($nickNameCount) ?>"></span>
													<br><br><br>
												</div>
												<?php } ?>
												</div>
											</div>
											<?php
													}
												}else{
													$sizeCount++;
													$totalQuantity += $r2['quantity'];
											?>
											<div id="sizequantity_single<?php print $sizeCount;?>" class="sizequantity_single">
												<button type="button" class="close_button_single <?php if($sizeCount == 1){print 'hidden';}?>" id="close_button_single" data-toggle="tooltip" data-placement="top" title="Remove">
													<span aria-hidden="true">&times;</span>
												</button>
												<div class="sizequantity_group_single">
													<div class="size_single">
														<label>Size</label><br />
														<?php
															$qube="select * from orderrss where sdn=".$_GET['oid'];
															$rezbe=mysqli_query($con,$qube);
															$rbe=mysqli_fetch_array($rezbe);
															$productgroup = $rbe['productgroup'];
														?>
														<select class="form-control" name="sizes[]" id="sizes_single" required />
														<?php
															$qsizes="select * from sizes where product='" . $productgroup . "' order by position";
															$rsizes=mysqli_query($con,$qsizes);
															while($rs=mysqli_fetch_array($rsizes)){
																if($rs['size']==$r2['size']){
																	print'<option value="'.$rs['size'].'" selected>'.$rs['size'].'</option>';
																}else{
																	print'<option value="'.$rs['size'].'">'.$rs['size'].'</option>';
																}
															}
														?>
														</select>
													</div>
													<div class="quantity_single">
														<label>Quantity</label><br />
														<input class="form-control prod_quantity_single" value="<?php print $r2['quantity'];?>" name="quantities[]" type="number" min="1" required id="quantity_single<?php print($sizeCount) ?>" oninput="quantityChange(this, 'add_nick_name_single<?php print $sizeCount;?>', 'parent_nickoptions_single<?php print $sizeCount;?>')" />
														<input type="button" class="btn btn-primary add_nick_btn_single add_nick_name_single<?php print $sizeCount;?> disabled" value="Add Nick Name" id="addnickSingle" onClick="showNickNameFields('parent_nickoptions_single<?php print $sizeCount;?>', 'quantity_single<?php print($sizeCount) ?>', 'add_nick_name_single<?php print $sizeCount;?>')" />
														<br /><span style="font-size:12px;">No. of pieces jersey/jacket/polo you are ordering</span><br />
														<span class="errors error_quantity_single" id="quantity_error_single<?php print $sizeCount;?>"></span>
														<br />
													</div>
												</div>
												<div id="parent_nickoptions_single<?php print($sizeCount) ?>" class="parent_nickoptions_single">
													<?php
														$nickNameSingleCount = 0;
														for($i=1; $i<=$r2['quantity']; $i++){
															$nickNameSingleCount++;
													?>
													<div class="nickoptions_single" id="nickname_field_single_1">
														<label>Nick name options </label><br />
														<select class="form-control" name="nickoptions[]" id="nickoptions_single_<?php print($nickNameSingleCount) ?>" onchange="showNickName(this)" required>
															<option value="">--- please select ---</option>
															<option value="1" <?php if($r2['nickname']=='(NA)') print 'selected'; ?>>Not applicable</option>
															<option value="2" <?php if($r2['nickname']=='(Blank)') print 'selected'; ?>>Keep name space blank</option>
															<option value="3" <?php if($r2['nickname']!='(NA)' && $r2['nickname']!='(Blank)') print 'selected'; ?>>Write a nick name to print</option>
														</select>
														<span class="select_nickname_error_single errors" id="select_nickname_error_single_<?php print($nickNameSingleCount) ?>"></span>
														<div id="shownick_single_<?php print($nickNameSingleCount) ?>" class="write_nick_name_single" style="display: <?php if($r2['nickname']!='(NA)' && $r2['nickname']!='(Blank)') print 'block'; else print 'none'; ?>;">
															<br>
															<label>Nick name to print </label><br />
															<input class="form-control" value="<?php if($r2['nickname']!='(NA)' && $r2['nickname']!='(Blank)') print $r2['nickname']; ?>" name="nickname[]" type="text" />
														</div>
														<span class="nickname_error_single errors" id="nickname_error_single_<?php print($nickNameSingleCount) ?>"></span>
														<br><br><br>	
													</div>
													<?php } ?>
												</div>
											</div>
											<?php } ?>											
										</div>
										<div class="add_size_button">
											<input type="button" class="btn btn-primary" value="Add Another Size" id="addsize" onClick="addSize()" />
										</div>


                                        <label>Payment made? </label><br />
										<select class="form-control" name="paym">
										  <option value="1" <? if($r2['paidd']==1) { ?> selected="selected"<? } ?>>Yes</option>
										  <option value="0" <? if($r2['paidd']==0) { ?> selected="selected"<? } ?>>No</option>
                                        </select><br /><br />
                                        <input type="hidden" name="sdn" value="<? print $_GET['oid'] ?>" />
										<input type="hidden" class="btn btn-primary pink" name="trimi" value="Save">
										<input type="button" class="btn btn-primary pink" value="Submit" onClick="updateOrder()">
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
		
	$totalSizez = document.getElementById('parent_sizequantity').children.length;

	function addSize() {
		$totalSizez++;
		var orderSizesLength = <?php echo $totalOrderSizes ?>;

		// if orderSizesLength greater than 0 then make a clone of multiple_sizequantity else make a clone of single_sizequantity
		if(orderSizesLength > 0){
			var parent_sizequantity = document.getElementById('parent_sizequantity');
			var sizequantity = document.getElementById('sizequantity_multiple1');
			var parentNickOptions = document.getElementById('parent_nickoptions_multiple1');
			var quantity = document.getElementById('quantity_multiple');
			var clone = sizequantity.cloneNode(true);
			clone.id = "sizequantity_multiple" + $totalSizez;

			let ifNickName = <?php echo($ifnick<>'no') ? 'true' : 'false' ?>;
			if(ifNickName){
				clone.getElementsByClassName('parent_nickoptions_multiple')[0].id = "parent_nickoptions_multiple" + $totalSizez;
				clone.getElementsByClassName('parent_nickoptions_multiple')[0].innerHTML = "";
			}
			clone.getElementsByClassName('prod_quantity_multiple')[0].id = "quantity_multiple" + $totalSizez;
			clone.getElementsByClassName('close_button_multiple')[0].className = "close_button_multiple";
			clone.getElementsByClassName('close_button_multiple')[0].setAttribute('onClick', 'removeSize(this)');
			clone.getElementsByClassName('prod_quantity_multiple')[0].value = "";
			clone.getElementsByClassName('prod_quantity_multiple')[0].setAttribute('oninput', 'quantityChange(this, "add_nickname_multiple'+$totalSizez+'", "parent_nickoptions_multiple'+$totalSizez+'")');
			clone.getElementsByClassName('error_quantity_multiple')[0].id = "quantity_error_multiple" + $totalSizez;
			clone.getElementsByClassName('error_quantity_multiple')[0].innerHTML = "";
			clone.getElementsByClassName('add_nick_btn_multiple')[0].setAttribute("onclick", "showNickNameFields('parent_nickoptions_multiple" + $totalSizez + "', 'quantity_multiple" + $totalSizez + "', 'addNickNameBtn" + $totalSizez + "')");
			clone.getElementsByClassName('add_nick_btn_multiple')[0].className = "btn btn-primary add_nick_btn_multiple add_nickname_multiple" + $totalSizez + " disabled";
			parent_sizequantity.appendChild(clone);
		}else{
			var parent_sizequantity = document.getElementById('parent_sizequantity');
			var sizequantity = document.getElementById('sizequantity_single1');
			var parentNickOptions = document.getElementById('parent_nickoptions_single1');
			var quantity = document.getElementById('quantity_single');
			var clone = sizequantity.cloneNode(true);
			clone.id = "sizequantity_single" + $totalSizez;

			let ifNickName = <?php echo($ifnick<>'no') ? 'true' : 'false' ?>;
			if(ifNickName){
				clone.getElementsByClassName('parent_nickoptions_single')[0].id = "parent_nickoptions_single" + $totalSizez;
				clone.getElementsByClassName('parent_nickoptions_single')[0].innerHTML = "";
			}

			clone.getElementsByClassName('prod_quantity_single')[0].id = "quantity_single" + $totalSizez;
			clone.getElementsByClassName('close_button_single')[0].className = "close_button_single";
			clone.getElementsByClassName('close_button_single')[0].setAttribute('onClick', 'removeSize(this)');
			clone.getElementsByClassName('prod_quantity_single')[0].value = "";
			clone.getElementsByClassName('prod_quantity_single')[0].setAttribute('oninput', 'quantityChange(this, "add_nickname_single'+$totalSizez+'", "parent_nickoptions_single'+$totalSizez+'")');
			clone.getElementsByClassName('error_quantity_single')[0].id = "quantity_error_single" + $totalSizez;
			clone.getElementsByClassName('error_quantity_single')[0].innerHTML = "";
			clone.getElementsByClassName('add_nick_btn_single')[0].setAttribute("onclick", "showNickNameFields('parent_nickoptions_single" + $totalSizez + "', 'quantity_single" + $totalSizez + "', 'addNickNameBtn" + $totalSizez + "')");
			clone.getElementsByClassName('add_nick_btn_single')[0].className = "btn btn-primary add_nick_btn_single add_nickname_single" + $totalSizez + " disabled";
			parent_sizequantity.appendChild(clone);
		}
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

	var id = <?php echo $totalQuantity ?>;
	function addNickNameFields(fieldId, quantity){
		id++;
		var orderSizesLength = <?php echo $totalOrderSizes ?>;
		var checkSizes = 'multiple';
		if(orderSizesLength == 0){
			checkSizes = 'single';
		}

		let html = '<div class="nickoptions_'+checkSizes+'" id="nickname_field_'+checkSizes+'_'+id+'"><label>Nick name options </label><br /><select class="form-control" name="nickoptions[]" id="nickoptions_'+checkSizes+'_'+id+'" onchange="showNickName(this)" required><option value="">--- please select ---</option><option value="1">Not applicable</option><option value="2">Keep name space blank</option><option value="3">Write a nick name to print</option></select><span class="select_nickname_error errors" id="select_nickname_error_'+checkSizes+'_'+id+'"></span><div id="shownick_'+checkSizes+'_'+id+'" class="write_nick_name" style="display:none;"><br><label>Nick name to print </label><br /><input class="form-control" value="<?php if(isset($_POST['nickname']))print $_POST['nickname'];?>" name="nickname[]" type="text" /></div><span class="nickname_error errors" id="nickname_error_'+checkSizes+'_'+id+'"></span><br<br /><br /></div>';


		if(quantity < $('#'+fieldId).find('.nickoptions_'+checkSizes).length){
			var diff = $('#'+fieldId).find('.nickoptions_'+checkSizes).length - quantity;
			for(var i = 0; i < diff; i++){
				$('#'+fieldId).find('.nickoptions_'+checkSizes).last().remove();
			}
		}else{
			var diff = quantity - $('#'+fieldId).find('.nickoptions_'+checkSizes).length;
			if(diff > 0){
				$('#'+fieldId).append(html);
			}
		}
	}

	function showNickName(elem){
		var id = elem.parentNode.id.split('_')[3];
		var orderSizesLength = <?php echo $totalOrderSizes ?>;
		var checkSizes = 'multiple';
		if(orderSizesLength == 0){
			checkSizes = 'single';
		}
		if(elem.value == 3){
			$('#shownick_'+checkSizes+'_'+id).show();
		}else{
			$('#shownick_'+checkSizes+'_'+id).hide();
		}
	}

	function updateOrder(){
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
		var orderSizesLength = <?php echo $totalOrderSizes ?>;
		var checkSizes = 'multiple';
		if(orderSizesLength == 0){
			checkSizes = 'single';
		}

		var parentSizeQuantity = document.getElementById('parent_sizequantity').children.length;
		for(var i = 0; i < parentSizeQuantity; i++){
			var id = document.getElementById('parent_sizequantity').children[i].id;
			var position = id.substr(id.length - 1);
			var quantity = document.getElementById('quantity_'+checkSizes+''+position).value;			
			if(quantity == ""){
				document.getElementById('quantity_error_'+checkSizes+''+position).innerHTML = "Please enter quantity";
				document.getElementById('quantity_'+checkSizes+''+position).scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
				return false;
			}else{
				document.getElementById('quantity_error_'+checkSizes+''+position).innerHTML = "";
			}
			var parentNickOptions = document.getElementById('parent_nickoptions_'+checkSizes+''+position).children.length;
			if(quantity > parentNickOptions){
				document.getElementById('quantity_error_'+checkSizes+''+position).innerHTML = "Please click on add nick name button";
				document.getElementById('quantity_'+checkSizes+''+position).scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
				return false;
			}else if(quantity < parentNickOptions){
				document.getElementById('quantity_error_'+checkSizes+''+position).innerHTML = "Please click on remove nick name button";
				document.getElementById('quantity_'+checkSizes+''+position).scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
				return false;
			}else{
				document.getElementById('quantity_error_'+checkSizes+''+position).innerHTML = "";
			}

			var totalNickName = document.getElementById('parent_nickoptions_'+checkSizes+''+position).children;


			for(var j = 0; j < parentNickOptions; j++){
				var nickOptions = totalNickName[j].children[2].value;
				var nickErrorId = totalNickName[j].children[3].id;
				if(nickOptions == ""){
					document.getElementById(nickErrorId).innerHTML = "Please select nick name options";
					document.getElementById(nickErrorId).scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
					return false;
				}else{
					document.getElementById(nickErrorId).innerHTML = "";
				}

				if(nickOptions == 3){
					var writeNickName = totalNickName[j].children[4];
					var nickNameId = writeNickName.id.substr(writeNickName.id.length - 1);
					var nickNameValue = writeNickName.getElementsByTagName('input')[0].value;
					if(nickNameValue == ""){
						document.getElementById('nickname_error_'+checkSizes+'_'+nickNameId).innerHTML = "Please enter nick name";
						document.getElementById('nickname_error_'+checkSizes+'_'+nickNameId).scrollIntoView({behavior: "smooth", block: "center", inline: "nearest"});
						return false;
					}else{
						document.getElementById('nickname_error_'+checkSizes+'_'+nickNameId).innerHTML = "";
					}
				}
			}
		}


		var totalQuantity = <?php echo $totalQuantity ?>;
		var updatedOrderQuantity = 0;


		var prodQuantityMultiple = document.getElementsByClassName('prod_quantity_'+checkSizes);
		for(var i = 0; i < prodQuantityMultiple.length; i++){
			updatedOrderQuantity += parseInt(prodQuantityMultiple[i].value);
		}
		if(updatedOrderQuantity > totalQuantity){
			alert("You are not allowed to increase the quantity. Kindly place a new order.");
			return false;
		}else if(updatedOrderQuantity == totalQuantity){
			var input = document.createElement('input');
			input.type = 'hidden';
			input.name = 'old_quantity';
			input.value = totalQuantity;
			document.getElementById('update_order_form').appendChild(input);
			var input = document.createElement('input');
			input.type = 'hidden';
			input.name = 'updated_quantity';
			input.value = updatedOrderQuantity;
			document.getElementById('update_order_form').appendChild(input);
			var input = document.createElement('input');
			input.type = 'hidden';
			input.name = 'checkSizes';
			input.value = checkSizes;
			document.getElementById('update_order_form').appendChild(input);
			document.getElementById('update_order_form').submit();
		}else{
			var input = document.createElement('input');
			input.type = 'hidden';
			input.name = 'old_quantity';
			input.value = totalQuantity;
			document.getElementById('update_order_form').appendChild(input);
			var input = document.createElement('input');
			input.type = 'hidden';
			input.name = 'updated_quantity';
			input.value = updatedOrderQuantity;
			document.getElementById('update_order_form').appendChild(input);
			var input = document.createElement('input');
			input.type = 'hidden';
			input.name = 'checkSizes';
			input.value = checkSizes;
			document.getElementById('update_order_form').appendChild(input);
			document.getElementById('update_order_form').submit();
		}
		
	}
	</script>

</body>

</html>
<?php }mysqli_close($con);}}?>