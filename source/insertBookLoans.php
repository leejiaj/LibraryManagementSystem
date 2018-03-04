<?php

include 'config.php';

$data = $_POST['data'];
$isbn = $data["isbn"];
$cardid = $data["cardid"];
$loanID = 0;

$result = mysqli_query($con,"SELECT count(*) AS countLoanBooks FROM bookloans");
$countLoanBooksRow =  mysqli_fetch_array($result);
$countLoanBooks = $countLoanBooksRow['countLoanBooks'];

if ($countLoanBooks == 0){
	$loanID = 10000;
}else{
	$result = mysqli_query($con,"SELECT max(loanid) AS maxLoanID FROM bookloans");
	$maxLoanIDRow =  mysqli_fetch_array($result);
	$maxLoanID = $maxLoanIDRow['maxLoanID'];
	$loanID = $maxLoanID + 1;
}

$sql = mysqli_query($con,"INSERT INTO bookloans VALUES ($loanID,'$isbn',$cardid,NOW(),DATE_ADD(NOW(), INTERVAL 14 DAY),null)");

if($sql)
{
	$data = "Book checked out successfully!";
}
else
{
	$data = "Book check out failed!";
}

echo json_encode($data);