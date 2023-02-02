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
   $q1="update students  set fname='".$_POST['fname']."',lname='".$_POST['lname']."',nickname='".$_POST['nickname']."',size='".$_POST['size']."',quantity='".$_POST['quantity']."',paidd='".$_POST['paym']."' where id=".$uid;
   $rez1=mysqli_query($con,$q1)or die(mysqli_error($con));
   print'Information updated successfully!'; 
   print'<meta http-equiv="refresh" content="2; url=dashboard.php?id='.$_POST['sdn'].'">';   
  }
  else{
  if(trim($err)!="") print'<div style="color:red">'.$err.'</div>';
?>							
                                <form role="form" action="edit-order.php" method="post" class="form-inline">
								<input type="hidden" name="usid" value="<?php print $uid;?>">
								<input type="hidden" name="exisuser" value="<?php print $r2['isactive'];?>">
									<div class="form-group">
										<label>First name </label><br />
										<input class="form-control" value="<?php if(isset($_POST['fname']))print $_POST['fname'];else print $r2['fname'];?>" name="fname" type="text" required /><br /><br />
										<label>Last name </label><br />
										<input class="form-control" value="<?php if(isset($_POST['lname']))print $_POST['lname'];else print $r2['lname'];?>" name="lname" type="text" required /><br /><br />
										<label>Nick name to print </label><br />
										<input class="form-control" value="<?php if(isset($_POST['nickname']))print $_POST['nickname'];else print $r2['nickname'];?>" name="nickname" id="nickname" type="text" required />
                                        <br /><br />
                                        <label>Size </label><br />
                                        <?
                                            $qube="select * from orderrss where sdn=".$_GET['oid'];
                                            $rezbe=mysqli_query($con,$qube);
                                            $rbe=mysqli_fetch_array($rezbe);
                                            $productgroup = $rbe['productgroup'];
                                        ?>
                                        <select class="form-control" name="size" id="sizes" required />
										<? if($productgroup<>''){ 
											$qsizes="select * from sizes where product='" . $productgroup . "'";
											$rsizes=mysqli_query($con,$qsizes);
											while($rowsize=mysqli_fetch_array($rsizes)){
									    ?>
											<option value="<? echo $rowsize['size'] ?>" <? if($r2['size']==$rowsize['size']){ ?> selected <? } ?>><? echo $rowsize['size'] ?></option>
											<? } ?>
										<? } else { ?>}
										  <option value="">--- Please choose from above ---</option>
										<? } ?>
                                        </select><br /><br />


                                        <!-- <input class="form-control" value="<?php if(isset($_POST['size']))print $_POST['size'];else print $r2['size'];?>" name="size" type="text" required /><br /><br /> -->

										<label>Quantity </label><br />
										<input class="form-control" value="<?php if(isset($_POST['quantity']))print $_POST['quantity'];else print $r2['quantity'];?>" name="quantity" type="text" required /><br /><br />
                                        <label>Payment made? </label><br />
										<select class="form-control" name="paym">
										  <option value="1" <? if($r2['paidd']==1) { ?> selected="selected"<? } ?>>Yes</option>
										  <option value="0" <? if($r2['paidd']==0) { ?> selected="selected"<? } ?>>No</option>
                                        </select><br /><br />
                                        <input type="hidden" name="sdn" value="<? print $_GET['oid'] ?>" />
										<input type="submit" class="btn btn-primary pink" name="trimi" value="Save">
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

</body>

</html>
<?php }mysqli_close($con);}}?>