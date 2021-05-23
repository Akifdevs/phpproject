<?php
$term=$_GET['term'];
require_once "pdo.php";
session_start();
$query=$pdo->query('SELECT * FROM Institution where name LIKE "%'.$term.'%"');
if($query->rowCount()){
  foreach($query as $row){
    $data[]=array(
      'value'=>$row['name'],
      'name'=>$row['name']
    );
  }
  echo json_encode($data);
}


 ?>
