<!DOCTYPE html>
<html lang="en"><head>

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
    
    <style type="text/css">

@media print {
  body * {
    visibility: hidden;
  }
  .section-to-print, .section-to-print * {
    visibility: visible;
  }
  .not-to-print, .not-to-print * {
	  display:none;
  }
  .section-to-print {
    position: absolute;
    left: 0;
    top: 0;
  }
  .dataTables_filter, .dataTables_length, .dataTables_paginate { display: none; }
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
<?
session_start();
$html=$_SESSION['savepdf'];

echo $html;

require 'phpmailer/PHPMailerAutoload.php';

$mail = new PHPMailer();
$mail->CharSet = 'UTF-8';
$mail->SetFrom("ageorgievski@gmail.com");
$mail->Subject  = "Briz Sports Orders";

$mail->AddAddress("ageorgievski@gmail.com");
$mail->MsgHTML($html);
$send = $mail->Send();

$mail->ClearAllRecipients();

?>
</body>

</html>