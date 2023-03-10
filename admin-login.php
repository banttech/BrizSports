<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin Login | Brizsports order management</title>

    <!-- Bootstrap Core CSS -->
    <link href="https://brizsports.com.au/order-management/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="https://brizsports.com.au/order-management/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://brizsports.com.au/order-management/css/plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="https://bsworkcopy.banttechenergies.com/order-management/css/orders.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://brizsports.com.au/order-management/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<div id="wrapper">
<div id="header">
<a class="navbar-brand" href="index.php"><img src="https://brizsports.com.au/order-management/images/logo.png" alt="Brizsports orders management" title="Brizsports orders management"><img src="https://brizsports.com.au/order-management/images/briz-leavers-logo.png" alt="Brizsports orders management" title="Brizsports orders management" style="margin-left:25px;"></a>
</div>
<div id="main"><form role="form" action="logging.php" method="post">
<div id="MainAdminLogin">
<div class="userIcon"><img src="https://brizsports.com.au/order-management/images/user-login-icon.png"></div>
<div class="loginTitle">Admin Login</div>
<div class="loginDesc">Sign in bellow using your email address and the password provided by Briz Sports.</div>
<div class="formElements">
<input class="form-control" placeholder="Email" name="user" type="text" style="display:inline;width:auto;float:left;height:28px;margin:8px 8px 0px 0px;font-size:12px;" size="25" autofocus>

<input class="form-control" placeholder="Password" id="password" name="pass" type="password" value="" style="display:inline;width:auto;float:left;height:28px;margin:8px 8px 0px 0px;font-size:12px;" size="25">
<div class="show_hide_pass">
    <i class="fa fa-eye-slash" aria-hidden="true" onclick="showHidePassword()" id="show_hide_pass"></i>
</div>

<!-- <i class="fa fa-eye" aria-hidden="true" onclick="hidePassword()" style="cursor: pointer"></i> -->



<input type="submit" class="form-control" value="Sign In" style="display:inline;width:auto;float:left;height:28px;margin:8px 8px 0px 0px;font-size:12px;background-color:#007bfd;color:white;border-color:transparent;">
</div>
<div class="loginDesc"></div>
</div>
</form>
<div class="push"></div>
</div>
<div id="footer">
<div class="copyright">Copyright © 2020 Briz Sports. All Rights Reserved. ABN 27605249723</div>
</div>
</div>

<script>
    function showHidePassword() {
        var passwordField = document.getElementById("password");
        if (passwordField.type === "password") {
            passwordField.type = "text";
        } else {
            passwordField.type = "password";
        }
        var eye = document.getElementById("show_hide_pass");
        if (eye.classList.contains("fa-eye-slash")) {
            eye.classList.remove("fa-eye-slash");
            eye.classList.add("fa-eye");
        } else {
            eye.classList.remove("fa-eye");
            eye.classList.add("fa-eye-slash");
        }
    }
</script>
</body>
</html>
