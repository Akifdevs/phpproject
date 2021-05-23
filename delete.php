<?php
session_start();
require_once "pdo.php";
if(!isset($_SESSION['name'])){
die("ACCESS DENIED");

}
if(!isset($_GET['profile_id'])){
  die("Parameter missing");
}
if(isset($_POST['cancel'])){
  header("Location:index.php");
  exit;
}
if(isset($_POST['delete'])){
  $stmt=$pdo->prepare("DELETE FROM profile where profile_id=:zip");
  $stmt->execute(array(
    ':zip'=>$_GET['profile_id']

  ));
  $_SESSION['success']="Deleted";
  header("Location:index.php");
  exit;


}


 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Mehmet Akif Yanılmaz</title>
  </head>
  <body>
    <h1>Deleteing Profile</h1>
    <form method="post" action="delete.php?profile_id=<?=htmlentities($_GET['profile_id']) ?>">
    <p>First Name:
    asg</p>
    <p>Last Name:
    There</p>
    <input type="hidden" name="profile_id"
    />
    <input type="submit" name="delete" value="Delete">
    <input type="submit" name="cancel" value="Cancel">
    </p>
    </form>
  </body>
</html>
