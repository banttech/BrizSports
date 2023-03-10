<?php

session_start();
$html=$_SESSION['savepdf'];

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Brizsports Order Management</title>

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
                <a class="navbar-brand" href="dashboard.php"><img src="https://brizsports.com.au/order-management/images/logo.png" alt="Brizsports payment settings management" title="Brizsports payment settings management" /></a>
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
                <?
				
				if(isset($_POST['submit'])){
					
					include("MPDF/mpdf.php");

$mpdf=new mPDF('utf-8', 'A4-l', '10', 'Arial', 10, 10, 10, 10, 5, 5); 
$mpdf->charset_in = 'utf-8';

$mpdf->simpleTables = true;
$mpdf->packTableData = true;
$keep_table_proportions = TRUE;
$mpdf->shrink_tables_to_fit=1;

$mpdf->SetDisplayMode('fullpage');
$mpdf->list_indent_first_level = 0;

$stylesheet = file_get_contents('savepdf.css');

$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML($html,2);

$emailAttachment = $mpdf->Output('brizsports-order.pdf', 'S');

require 'phpmailer/PHPMailerAutoload.php';


$getSenderEmail = "select * from emails where type='sender'";
$rezSenderEmail = mysqli_query($con,$getSenderEmail);
$rSenderEmail = mysqli_fetch_array($rezSenderEmail);
$senderEmail = $rSenderEmail['email'];

$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';
// $mail->SetFrom("sales@brizsports.com.au");
$mail->SetFrom($senderEmail,"Briz Sports");
$mail->Subject  = "Briz Sports Orders";

$mail->AddAddress($_POST['emailaddress']);
$mail->MsgHTML('Hello...');
$mail->AddStringAttachment($emailAttachment, 'brizsports-order.pdf');
$send = $mail->Send();

$mail->ClearAllRecipients();

?>
                    <h1 class="page-header">YOUR ORDER LIST HAS BEEN SENT.</h1><? }else { ?>
                    <h1 class="page-header">Please enter a recepient</h1>
			  <form role="form" action="email.php" method="post" class="form-inline">
                    	<label>Email address </label>
				  <input class="form-control" value="" name="emailaddress" type="email" size="30" />
              <input type="submit" class="btn btn-primary pink" name="submit" value="Send">
                    </form><? } ?>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
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

</body>

</html>