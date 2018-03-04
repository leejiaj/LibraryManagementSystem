<?php

include 'config.php';

$sel = mysqli_query($con,"select b.cardid,firstname,lastname,sum(fineamt) as totalfineamt from bookloans bl, fines f, borrower b where bl.loanid = f.loanid and bl.cardid = b.cardid and paid = 0 group by b.cardid");
$data = array();

while ($row = mysqli_fetch_array($sel)) {

    $data[] = array("cardid"=>$row['cardid'],"firstname"=>$row['firstname'],"lastname"=>$row['lastname'],"totalfineamt"=>$row['totalfineamt']);

}

echo json_encode($data);