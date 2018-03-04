<?php

include 'config.php';

$isbn = $_POST['data'];
$sel = mysqli_query($con,"select count(*) AS countBooks from bookloans bl where bl.isbn = $isbn and datein is null");
$data = array();

while ($row = mysqli_fetch_array($sel)) {


    $data[] = array("countBooks"=>$row['countBooks']);

}

echo json_encode($data);