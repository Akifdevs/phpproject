<?php
session_start();
require_once "pdo.php";
if(!isset($_GET['profile_id'])){
  die("Parameter missing");
}
$stmt=$pdo->prepare("SELECT first_name,last_name,email,headline,summary FROM profile where profile_id=:zip");
$stmt->execute(array(
':zip'=>$_GET['profile_id']

));
 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Mehmet Akif Yanılmaz</title>
  </head>
  <body>
  <h1>Profile Information</h1>
<?php
$row=$stmt->fetch(PDO::FETCH_ASSOC);
echo '
<p>First Name:
'.$row['first_name'].'</p>
<p>Last Name:
'.$row['last_name'].'</p>
<p>Email:
'.$row['email'].'</p>
<p>Headline:<br/>
'.$row['headline'].'</p>
<p>Summary:<br/>
'.$row['summary'];

$stmt=$pdo->prepare("SELECT rank,year,description FROM position where profile_id=:zip");
$stmt->execute(array(
':zip'=>$_GET['profile_id']
));
while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
  echo "<p>Position</p>";
  echo "<ul>";
  echo "<li>".$row['year']."</li><br>";
  echo "<li>".$row['description']."</li><br>";
  echo "</ul>";
}
$stmt=$pdo->prepare("SELECT rank,year,institution_id FROM education where profile_id=:zip");
$stmt->execute(array(
':zip'=>$_GET['profile_id']
));
while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
  echo "<p>Education</p>";
  echo "<ul>";
  echo "<li>".$row['year']."</li><br>";
  $stt=$pdo->query("SELECT name FROM institution where institution_id='".$row['institution_id']."'");
  foreach($stt as $row){
    echo "<li>".$row['name']."</li><br>";
  }
  echo "</ul>";
}

 ?>
 <a href="index.php">Done</a>

  </body>
</html>
