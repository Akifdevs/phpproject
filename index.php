<?php
session_start();
require_once "pdo.php";

?>
<!DOCTYPE html>
<html lang='en' dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Mehmet Akif Yanılmaz</title>
  </head>
  <body>
    <h1>Mehmet Akif Yanılmaz's Resume Registry</h1>
    <?php
    if(!isset($_SESSION['name'])){
      echo "<a href='login.php'>Please log in</a>";
      $stmt=$pdo->query("SELECT profile_id,first_name,headline from profile ");
      echo "<table border='1'>";
      echo "<tr>
        <td><b>Name</b></td>
        <td><b>Headline</b></td>
      </tr>";
      while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
          echo "<tr><td>";
          echo("<a href='view.php?profile_id=".$row['profile_id']."'>".htmlentities($row['first_name']));
          echo("</td><td>");
          echo(htmlentities($row['headline']));
          echo("</td></tr>\n");
      }
      echo "</table>";

    }
    else{

      echo '<a href="logout.php">Logout</a>';
      echo "<br>";
      if(isset($_SESSION['success'])){
        echo "<p style='color:green;'><b>".$_SESSION['success']."</p>";
        unset($_SESSION['success']);
      }
      $stmt=$pdo->query("SELECT profile_id,first_name,headline from profile ");
      echo "<table border='1'>";
      echo "<tr>
        <td><b>Name</b></td>
        <td><b>Headline</b></td>
        <td><b>Action</b></td>
      </tr>";
      while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
          echo "<tr><td>";
          echo("<a href='view.php?profile_id=".$row['profile_id']."'>".htmlentities($row['first_name']));
          echo("</td><td>");
          echo(htmlentities($row['headline']));
          echo("</td><td>");
          echo('<a href="edit.php?profile_id='.$row['profile_id'].'">Edit</a> / ');
          echo('<a href="delete.php?profile_id='.$row['profile_id'].'">Delete</a>');
          echo("</td></tr>\n");
      }
      echo "</table>";
      echo '<a href="add.php">Add New Entry</a>';
    }


    ?>




  </body>
</html>
