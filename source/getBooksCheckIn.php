<?php

include 'config.php';

$searchquery = $_POST['data'];
$searchquery1 = strtolower($searchquery);
$sel = mysqli_query($con,"select loanid, isbn, bl.cardid, dateout, duedate, datein, firstname, lastname from bookloans bl, borrower b where bl.cardid = b.cardid and ((bl.cardid like '%$searchquery1%') or (bl.isbn like '%$searchquery1%') or (LOWER(b.firstname) like '%$searchquery1%') or (LOWER(b.lastname) like '%$searchquery1%'))");
$data = array();

while ($row = mysqli_fetch_array($sel)) {


    $data[] = array("loanid"=>$row['loanid'],"isbn"=>$row['isbn'],"cardid"=>$row['cardid'],"dateout"=>$row['dateout'],"duedate"=>$row['duedate'],"datein"=>$row['datein'],"firstname"=>$row['firstname'],"lastname"=>$row['lastname']);

}

echo json_encode($data);