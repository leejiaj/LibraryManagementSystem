<?php

include 'config.php';

$sel = mysqli_query($con,"select f.loanid,isbn,cardid,dateout,duedate,datein,fineamt,paid from bookloans bl, fines f where bl.loanid = f.loanid and paid = 0");
$data = array();

while ($row = mysqli_fetch_array($sel)) {

    $data[] = array("loanid"=>$row['loanid'],"isbn"=>$row['isbn'],"cardid"=>$row['cardid'],"dateout"=>$row['dateout'],"duedate"=>$row['duedate'],"datein"=>$row['datein'],"fineamt"=>$row['fineamt'],"paid"=>$row['paid']);

}

echo json_encode($data);