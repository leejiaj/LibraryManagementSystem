<?php

include 'config.php';

$loanid = $_POST['data'];
$sel = mysqli_query($con,"update bookloans set datein = current_date() where loanid = $loanid");
if($sel){
	$data = "Book successfully Checked In!";
}
else{
	$data = "Check In Failed";
}


echo json_encode($data);