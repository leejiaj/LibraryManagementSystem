<?php

include 'config.php';

$searchquery = $_POST['data'];
$searchquery1 = strtolower($searchquery);
$sel = mysqli_query($con,"select b.isbn,title,name,(SELECT (NOT EXISTS (SELECT 1 FROM bookloans bl WHERE bl.isbn = b.isbn and datein is null))) AS availability from book b, bookauthors ba, authors a where b.isbn = ba.isbn and ba.authorid = a.authorid and ((LOWER(title) like '%$searchquery1%') or (LOWER(name) like '%$searchquery1%') or (LOWER(b.isbn) like '%$searchquery1%'))");
$data = array();

while ($row = mysqli_fetch_array($sel)) {


    $data[] = array("isbn"=>$row['isbn'],"title"=>$row['title'],"name"=>$row['name'],"availability"=>$row['availability']);

}

echo json_encode($data);