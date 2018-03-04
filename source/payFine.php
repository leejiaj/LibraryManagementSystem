<?php

include 'config.php';

$loanid = $_POST['data'];
$sel = mysqli_query($con,"update fines set paid = 1 where loanid = $loanid");
if($sel){
	$data = "Fine paid successfully!";
}
else{
	$data = "Payment of fine failed";
}


echo json_encode($data);