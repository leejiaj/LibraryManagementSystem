<?php

include 'config.php';

$sel = mysqli_query($con,"select * from book limit 500");
$data = array();

while ($row = mysqli_fetch_array($sel)) {

    $data[] = array("isbn"=>$row['isbn'],"title"=>$row['title']);

}

echo json_encode($data);

