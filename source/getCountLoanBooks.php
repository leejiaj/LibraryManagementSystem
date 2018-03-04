<?php

include 'config.php';

$cardid = $_POST['data'];
$sel = mysqli_query($con,"select count(*) AS countLoanBooks from bookloans bl where bl.cardid = $cardid");
$data = array();

while ($row = mysqli_fetch_array($sel)) {


    $data[] = array("countLoanBooks"=>$row['countLoanBooks']);

}

echo json_encode($data);