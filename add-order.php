<?php session_start();
      include("../conc.php");
	  
	  // new sdn ----------
	  
	  $qsdn="select id, sdn from orderrss ORDER BY id DESC LIMIT 1";
	  $rsdn=mysqli_query($con,$qsdn);
	  $r2sdn=mysqli_fetch_array($rsdn);
	  $newsdn = $r2sdn['sdn'] + 1;
	  
	  // ------------------
	  
	  
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
							else{include("functions.php");
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
	
	<style>
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
                    <h1 class="page-header">Add Order</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add new order
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
<?
$isok=0;
  $err="";
  if(isset($_POST['trimi']))
  {$isok=1;
   if((!is_numeric($_POST['sdn']))||(strlen($_POST['sdn'])!=6)){$isok=0;$err.="Six digit number incorrectly formatted!<br/>";}
   else{$qxv="select * from orderrss where sdn='".$_POST['sdn']."'";
        $rezxv=mysqli_query($con,$qxv);
        if(mysqli_num_rows($rezxv)>0){$isok=0;$err.="Six digit number already allocated to another order!<br/>";}
	   }
   //if((!is_numeric($_POST['orderval']))||($_POST['orderval']<=0)){$isok=0;$err.="Order value must be a positive number!<br/>";}	
   if(trim($_POST['orddate'])==""){$isok=0;$err.="Order date can not be empty!<br/>";}
   if(trim($_POST['dline'])==""){$isok=0;$err.="Deadline can not be empty!<br/>";}
  }
  if($isok==1)
  {
   $qmax="select max(id) as lemax from orderrss";
   $rezmax=mysqli_query($con,$qmax);
   $rmax=mysqli_fetch_array($rezmax);
   $maxuid=$rmax['lemax'];$maxuid++;
   $orderval=textbun($_POST['orderval']);
	  
   $q1="insert into orderrss (id,orderval,sdn,orddate,deadline,ordname,belto,methodofpayment,productgroup,nickname)values('".$maxuid."','".$orderval."','".$_POST['sdn']."','".$_POST['orddate']."','".$_POST['dline']."','".$_POST['deadline']."','".$_POST['belto']."','".$_POST['methodofpayment']."','".$_POST['pgroup']."','".$_POST['nickname']."')";
   $rez1=mysqli_query($con,$q1)or die(mysqli_error($con));
   print'Information added successfully!'; 
   print'<meta http-equiv="refresh" content="2; url=add-order.php">';   
  }
  else{
  if(trim($err)!="") print'<div style="color:red">'.$err.'</div>';
?>							
                                <form role="form" action="add-order.php" enctype="multipart/form-data" method="post" class="form-inline">
									<div class="form-group">
										<label>Method of payment </label><br />
										<select class="form-control" name="methodofpayment" id="methodofpayment">
											<option value="0">Group invoice</option>
											<option value="1">Individual e-payment</option>
										</select><br /><br />
										<label id="valuelab">Order value </label><br />
										<div class="input-group" id="valueinp">
										  <span class="input-group-addon">$</span>
										  <input class="form-control" value="<?php if(isset($_POST['orderval']))print $_POST['orderval'];?>" name="orderval" id="orderval" type="number" size="30" step=".01" placeholder="0.00" disabled />
										</div>
										<br /><br />
										<label>Six digit number </label><br />
										<input class="form-control" value="<?php if(isset($_POST['sdn']))print $_POST['sdn'];else print $newsdn;?>" name="sdn" type="text" size="30"/><br /><br />
                                        <label>Order name</label><br />
										<input class="form-control" value="<?php if(isset($_POST['deadline']))print $_POST['deadline'];?>" name="deadline" type="text" size="30"/><br /><br />
										<label>Nickname option</label><br />
										<select class="form-control" name="nickname" id="nickname" required <? if($nickname<>''){ ?>disabled<? } ?>/>
										  <option selected value="">--- please select ---</option>
                                          <option value="yes" <? if($_POST['nickname']=='yes'){ ?>selected<? } ?> >Show</option>
                                            <option value="no" <? if($_POST['nickname']=='no'){ ?>selected<? } ?>>Don't show</option>
                                        </select><br /><br />
										<label>Product group </label><br />
										<select class="form-control" name="pgroup" id="pgroup" required <? if($productgroup<>''){ ?>disabled<? } ?>/>
										  <option selected value="">--- please select ---</option>
                                          <option value="polos" <? if($_POST['pgroup']=='polos'){ ?>selected<? } ?> >Polos & Tees</option>
                                            <option value="jerseys" <? if($_POST['pgroup']=='jerseys'){ ?>selected<? } ?>>Jerseys, Jumpers & Jackets</option>
                                            <option value="sportswear" <? if($_POST['pgroup']=='sportswear'){ ?>selected<? } ?>>Sportswear</option>
                                        </select><br /><br />
										<label>Order date </label><br />
										<input class="form-control" value="<?php if(isset($_POST['orddate'])) { print $_POST['orddate'];}else { print date("Y-m-d");} ?>" name="orddate" type="date" style="line-height: 18px" size="30"/><br /><br />
										<label>Deadline </label><br />
										<input class="form-control" value="<?php if(isset($_POST['dline'])) { print $_POST['dline'];}else { print date("Y-m-d");} ?>" name="dline" type="date" style="line-height: 18px" size="30"/><br /><br />
										
                                        
										<label>For customer </label><br />
										<select class="form-control" name="belto">
										<?php $qcu="select * from customers order by dateacc desc";
										      $rezcu=mysqli_query($con,$qcu);
											  while($rcu=mysqli_fetch_array($rezcu))
											  {print'<option value="'.$rcu['id'].'"';
											   if(isset($_POST['belto']))
											     if($_POST['belto']==$rcu['id'])
												    print' selected="true"';
											   print'>'.$rcu['custname'];
											   print'</option>';
											  }
										?>
										</select><br /><br />

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
	
	<script type="text/javascript">
		
		document.getElementById('methodofpayment').addEventListener('change', function() {
			if (this.value == 1) {
				document.getElementById('orderval').disabled = false;
			} else {
				document.getElementById('orderval').disabled = true;
			}
		});
		
        
	</script>

</body>

</html>
<?php }mysqli_close($con);}?>