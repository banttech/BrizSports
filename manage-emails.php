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
                    <h1 class="page-header">Manage Emails</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Manage Emails
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <?php
                                    $sender_email_query = "select * from emails where type='sender'";
                                    $sender_email_result = mysqli_query($con,$sender_email_query);
                                    $sender_email_row = mysqli_fetch_array($sender_email_result);
                                    $sender_email = $sender_email_row['email'] ? $sender_email_row['email'] : '';
                                ?>
                                <form role="form" action="" method="post" enctype="multipart/form-data">
									<div class="form-group">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Sender Email</label><br />
                                                <div class="sender_email_sec">
                                                    <?php
                                                        if($sender_email_row['email'] == ''){ ?>
                                                            <a href="manage-sender-email.php" class="btn btn-primary pink">Add</a>
                                                    <?php }else{ ?>
                                                            <input class="form-control" id="sender_email" value="<?php echo $sender_email ?>" name="email" type="email" size="30" readonly required />
                                                            <a href="manage-sender-email.php" class="btn btn-primary pink">Edit</a>
                                                    <?php } ?>
                                                </div>
                                                <span id="email_message"></span>
                                            </div>
                                        </div>
									</div>	
								</form>

                                <br /><br />
                                <div class="receiver_sec">
                                    <label>Receiver Emails</label>
                                    <a href="add-receiver-email.php" class="btn btn-primary pink pull-right">Add Receiver Email</a>
                                </div>
                                <br />
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" autosize="1" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;"><small>Email</small></th>
											<div class="not-to-print"><th class="not-to-print"><small>Edit</small></th></div>
                                            <div class="not-to-print"><th class="not-to-print"><small>Delete</small></th></div>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $receivers = "select * from emails where type='receiver'";
                                            $receivers_result = mysqli_query($con,$receivers);
                                            while($row = mysqli_fetch_array($receivers_result)){ 
                                        ?>
                                        <tr class="odd gradeX">
                                            <td style="text-align:center;"><?php echo $row['email'];?></td>
                                            <td class="not-to-print"><a href="edit-receiver-email.php?id=<?php echo $row['id'];?>"><i class="fa fa-edit"></i></a></td>
                                            <td class="not-to-print"><a onClick="deleteReceiver(<?php echo $row['id'];?>)" class="link"><i class="fa fa-trash-o"></i></a></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
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

    <script>
        function deleteReceiver(id){
            if(confirm("Are you sure you want to delete this email?")){
                $.ajax({
                    url: 'delete-receiver-email.php',
                    type: 'POST',
                    data: {id: id},
                    success: function(response){
                        alert("Email deleted successfully");
                        setTimeout(function(){
                            window.location.reload();
                        }, 500);
                    },
                });
            }
        }
    </script>

</body>

</html>
<?php }?>

<?php 
    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $q1="select * from emails where type='sender'";
        $rez1=mysqli_query($con,$q1);
        if(mysqli_num_rows($rez1)>0){
            $q2="update emails set email='".$email."' where type='sender'";
            $rez2=mysqli_query($con,$q2);
            if($rez2){
                echo "<script>
                document.getElementById('email_message').innerHTML = 'Email updated successfully!';
                </script>";
                echo "<script>setTimeout(function(){document.getElementById('email_message').innerHTML = '';}, 3000);</script>";
            }else{
                echo "<script>
                document.getElementById('email_message').innerHTML = 'Email not updated!';
                </script>";
                echo "<script>setTimeout(function(){document.getElementById('email_message').innerHTML = '';}, 3000);</script>";
            }
        }else{
            $q2="insert into emails (email, type) values ('".$email."', 'sender')";
            $rez2=mysqli_query($con,$q2);
            if($rez2){
                echo "<script>
                document.getElementById('email_message').innerHTML = 'Email added successfully!';
                </script>";
                echo "<script>setTimeout(function(){
                    document.getElementById('email_message').innerHTML = '';
                    location.reload();
                }, 3000);</script>";
            }else{
                echo "<script>
                document.getElementById('email_message').innerHTML = 'Email not added!';
                </script>";
                echo "<script>setTimeout(function(){
                    document.getElementById('email_message').innerHTML = '';
                }, 3000);</script>";
            }
        }
    }

?>