<?php session_start();
      include("../conc.php");
	if((!isset($_SESSION['admid']))||(!isset($_SESSION['unam']))||(!isset($_SESSION['pass'])))
	{print'<h3>Incorrect login information</h3>';
                                   print'<meta http-equiv="refresh" content="2; url=index.php">';
    }else{
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
                    <h1 class="page-header">Add Receiver Email</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Add Receiver Email
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <?php
                                    $id = $_GET['id'];
                                    $q1 = "select * from emails where id = '".$id."'";
                                    $rez1 = mysqli_query($con, $q1);
                                    $receiverDetail = mysqli_fetch_array($rez1);
                                    $email = '';
                                    if(isset($_POST['submit']) && $_POST['email'] != ''){
                                        $email = $_POST['email'];
                                    }else{
                                        $email = $receiverDetail['email'];
                                    }
                                ?>
                                <form role="form" action="edit-receiver-email.php?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
									<div class="form-group">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <label>Receiver Email</label><br />
                                                <input class="form-control" id="sender_email" value="<?php echo $email ?>" name="email" type="email" size="30" required />
                                                <span id="email_message"></span>
                                                <br /><br />
                                                <input type="submit" class="btn btn-primary pink" name="submit" value="Save" />
                                            </div>
                                        </div>
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
        $('#dataTables-example').dataTable({
            "bLengthChange": false,
            "bPaginate": false,
            "searching": false,
            "ordering": false,
            "bInfo": false,
        });
    });
    </script>

</body>

</html>
<?php }?>



<?php 
    if(isset($_POST['submit'])){
        $id = $_GET['id'];
        $updateQuery = "update emails set email = '".$_POST['email']."' where id = '".$id."'";
        $rez1 = mysqli_query($con, $updateQuery);
        if($rez1){
            echo "<script>
            document.getElementById('email_message').innerHTML = 'Email updated successfully!';
            </script>";
            print'<meta http-equiv="refresh" content="2; url=manage-emails.php">';
        }else{
            echo "<script>
            document.getElementById('email_message').innerHTML = 'Email not updated something went wrong!';
            </script>";
        }
    }

?>