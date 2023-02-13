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
                    <h1 class="page-header">Manage Product Size</h1>
                </div>
                <div class="form-group col-md-4">
                    <label for="product">Product group</label>
                    <select class="form-control" id="product" onchange="window.location='https://bsworkcopy.banttechenergies.com/order-management/manage-size.php?group=' + this.value;">
                        <option value="polos" selected>Polos & Tees</option>
                        <option value="jerseys" <?php if(isset($_GET['group']) && $_GET['group'] == 'jerseys') echo 'selected';?>>Jerseys, Jumpers & Jackets</option>
                        <option value="sportswear" <?php if(isset($_GET['group']) && $_GET['group'] == 'sportswear') echo 'selected';?>>Sportswear</option>
                    </select>
                </div>
            </div>

            <div class="row section-to-print">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading size-heading-panel">
                          <p>Manage Product Size</p>
                            <div class="not-to-print">
                                <button type="button" class="btn btn-primary btn-sm"><a href="add-size.php?group=<?php echo isset($_GET['group']) ? $_GET['group'] : 'polos';?>" style="color:#fff;">Add Size</a></button>
                            </div>
					  </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example" autosize="1" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;"><small>Product Group Name</small></th>
                                            <th style="text-align:center;"><small>Size</small></th>
											<div class="not-to-print"><th class="not-to-print"><small>Edit</small></th></div>
                                            <div class="not-to-print"><th class="not-to-print"><small>Delete</small></th></div>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $productgroup = isset($_GET['group']) ? $_GET['group'] : 'polos';
                                        $qsizes="select * from sizes where product='" . $productgroup . "'";
                                        $rsizes=mysqli_query($con,$qsizes);
                                        $count = 0;
                                        while($row=mysqli_fetch_array($rsizes)){?>
                                        <?php $productHeading = $row['product'] == 'polos' ? 'Polos & Tees' : ($row['product'] == 'jerseys' ? 'Jerseys, Jumpers & Jackets' : 'Sportswear'); ?>
                                        <tr class="odd gradeX">
                                            <td style="text-align:center;"><?php echo $productHeading?></td>
                                            <td style="text-align:center;"><?php echo $row['size'];?></td>
                                            <div class="not-to-print"><td class="not-to-print"><a href="edit-size.php?group=<?php echo isset($_GET['group']) ? $_GET['group'] : 'polos';?>&id=<?php echo $row['id'];?>"><i class="fa fa-edit"></i></a></td></div>
                                            <div class="not-to-print"><td class="not-to-print"><a onClick="deleteSize(<?php echo $row['id'];?>)" class="link"><i class="fa fa-trash-o"></i></a></td></div>
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
            columnDefs: [
                { orderable: false, targets: [0, 2, 3] }
            ]
        });
    });
    </script>

    <script>
        function deleteSize(id){
            if(confirm("Are you sure you want to delete this size?")){
                $.ajax({
                    url: 'delete-size.php',
                    type: 'POST',
                    data: {id: id},
                    success: function(response){
                        alert("Size deleted successfully");
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