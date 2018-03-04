<?php

include 'config.php';

$data = $_POST['data'];
$ssn = $data["ssn"];
$firstname = $data["firstname"];
$lastname = $data["lastname"];
$email = $data["email"];
$address = $data["address"];
$city = $data["city"];
$state = $data["state"];
$phone = $data["phone"];
$loanID = 0;

$result = mysqli_query($con,"SELECT count(*) AS countssn FROM borrower where ssn = $ssn");
$countSsnRow =  mysqli_fetch_array($result);
$countSsn = $countSsnRow['countssn'];
$data = "";

if ($countSsn == 1){
	$data = "There is an active account with this SSN. New account creation Rejected!";
}else{
	$sql = mysqli_query($con,"INSERT INTO borrower(ssn, firstname, lastname, email, address, city, state, phone) VALUES ($ssn,'$firstname','$lastname','$email','$address','$city','$state','$phone')");
	
	if($sql)
	{
		$data = "New borrower account created!";
	}
	else
	{
		$data = "Borrower account creation failed! Please check the data.";
	}
}

echo json_encode($data);