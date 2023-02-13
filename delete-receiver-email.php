<?php session_start();
      include("../conc.php");
	if((!isset($_SESSION['admid']))||(!isset($_SESSION['unam']))||(!isset($_SESSION['pass'])))
	{print'<h3>Incorrect login information</h3>';
                                   print'<meta http-equiv="refresh" content="2; url=index.php">';
    }else{
        $id = $_POST['id'];
        $q1 = "select * from emails where id = '".$id."'";
        $rez1=mysqli_query($con,$q1);
        if(mysqli_num_rows($rez1)==0){
            return "Something went wrong";
        }else{
            $q2="delete from emails where id=".$id;
            $rez2=mysqli_query($con,$q2);
            if($rez2){
                return "Size deleted successfully";
            }else{
                return "Something went wrong";
            }
        }
    }
?>