<?php
  include("../conc.php");
  $order = $_POST['order'];

  // Update the database with the new order
  for ($i = 0; $i < count($order); $i++) {
    $id = $order[$i];
    $position = $i + 1;

    $q1="update sizes  set position='".$position."' where id='".$id."'";
	$rez1=mysqli_query($con,$q1)or die(mysqli_error($con));
  }
  // Return a success message to the AJAX request
  echo "Order updated successfully.";
?>