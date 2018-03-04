<?php

include 'config.php';


$result1 = mysqli_query($con,"insert into fines(loanid,fineamt) (select loanid, (DATEDIFF(datein,duedate)*0.25) from bookloans bl where datein is not null and datein > duedate and not exists(select f.loanid from fines f where f.loanid = bl.loanid))");

$result2 = mysqli_query($con,"insert into fines(loanid,fineamt) (select loanid, (DATEDIFF(CURDATE(),duedate)*0.25) from bookloans bl where datein is null and duedate < CURDATE() and not exists(select f.loanid from fines f where f.loanid = bl.loanid))");

$result3 = mysqli_query($con,"update fines fo set fineamt = (select (DATEDIFF(datein,duedate)*0.25) from bookloans bl where bl.loanid = fo.loanid and datein is not null and datein > duedate) where fo.paid = 0 and exists (select bl.loanid from bookloans bl where bl.loanid = fo.loanid and datein is not null and datein > duedate)");

$result4 = mysqli_query($con,"update fines fo set fineamt = (select (DATEDIFF(CURDATE(),duedate)*0.25) from bookloans bl where bl.loanid = fo.loanid and datein is null and duedate < CURDATE()) where fo.paid = 0 and exists (select bl.loanid from bookloans bl where bl.loanid = fo.loanid and datein is null and duedate < CURDATE())");

if($result1 && $result2 && $result3 && $result4){
	$data = "Entries in Fines table are Refreshed/Updated!";
}
else{
	$data = "Refresh/Update of Fines table failed!";
}


echo json_encode($data);