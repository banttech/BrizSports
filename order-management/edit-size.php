<?php session_start();
      include("../conc.php");
	if((!isset($_SESSION['admid']))||(!isset($_SESSION['unam']))||(!isset($_SESSION['pass'])))
	{print'<h3>Incorrect login information</h3>';
                                   print'<meta http-equiv="refresh" content="2; url=index.php">';
    }else{
        $id = $_GET['id'];
        if($id){
            $q1="select * from sizes where id=".$id;
            $rez1=mysqli_query($con,$q1);
            $item = mysqli_fetch_assoc($rez1);
            $prodSize = $item['size'];
        }
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
                    <h1 class="page-header">Edit Size</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Edit size
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <form role="form" action="edit-size.php?group=<?php echo $_GET['group'] ?>&id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
									<div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                            <label>Product group</label><br />
                                            <?php $productHeading = $_GET['group'] == 'polos' ? 'Polos & Tees' : ($_GET['group'] == 'jerseys' ? 'Jerseys, Jumpers & Jackets' : 'Sportswear'); ?>
										    <input class="form-control" value="<?php echo $productHeading?>" name="product" type="text" size="30" readonly/>
                                            </div>
                                        </div>
                                        <br /><br />
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Size</label><br />
                                                <input class="form-control" value="<?php echo isset($_POST['size']) ? $_POST['size'] : $prodSize ?>" name="size" type="text" autofocus required />
                                            </div>
                                        </div>
                                        <span id="errors"></span>
                                        <br /><br />
										<input type="submit" class="btn btn-primary pink" name="submit" value="Update">
									</div>	
								</form>							
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
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
</body>

</html>
<?php }?>

<?php 
    if(isset($_POST['submit'])){
        $size = $_POST['size'];
        $group = $_GET['group'];
        $id = $_GET['id'];
        $q1 = "select * from sizes where size='".$size."' and product='".$group."' and id!='".$id."'";
        $rez1=mysqli_query($con,$q1);
        if(mysqli_num_rows($rez1)>0){
            echo "<script>
            document.getElementById('errors').innerHTML = 'This size is already exist in this product group!';
            setTimeout(function(){document.getElementById('errors').innerHTML = '';}, 5000);
            </script>";
        }else{
            $q2 = "update sizes set size='".$size."' where id='".$id."'";
            $rez2=mysqli_query($con,$q2);
            if($rez2){
                echo "<script>
                document.getElementById('errors').innerHTML = 'Size updated successfully!';
                </script>";
                print'<meta http-equiv="refresh" content="2; url=manage-size.php?group='.$group.'">';
            }else{
                echo "<script>
                document.getElementById('errors').innerHTML = 'Something went wrong!';
                setTimeout(function(){document.getElementById('errors').innerHTML = '';}, 5000);
                </script>";
            }
        }
    }

?>