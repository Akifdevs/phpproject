<?php
session_start();
require "pdo.php";

if(isset($_POST['cancel'])){
  header("Location:index.php");
  exit;
}





if(isset($_POST['first_name'])||isset($_POST['last_name'])||isset($_POST['email'])||isset($_POST['headline'])||
isset($_POST['summary'])){
  if(isset($_SESSION['error'])||isset($_SESSION['error1'])){}
  elseif(!isset($_POST['first_name'])||strlen($_POST['first_name'])<1||!isset($_POST['last_name'])||strlen($_POST['last_name'])<1||
  !isset($_POST['email'])||strlen($_POST['email'])<1||!isset($_POST['headline'])||strlen($_POST['headline'])<1||
  !isset($_POST['summary'])||strlen($_POST['summary'])<1){
    $_SESSION['error']="All fields are required";
    header("Location:add.php");
    exit();

  }else{//bir varsa bunları yap
      $ikivar=false;
      $ucvar=false;
      for($i=1;$i<10;$i++){//ikinciformvarmıbak
      $yr="year".$i;
      $dc="desc".$i;
      $eyr="edu_year".$i;
      $eschl="edu_school".$i;
      if(isset($_POST[$yr])||isset($_POST[$dc])){
          if(!isset($_POST[$yr])||strlen($_POST[$yr])<1||!isset($_POST[$dc])||strlen($_POST[$dc])<1) {
          $_SESSION['error1']="All fields are required123";
          header("Location:add.php");
          exit;
          }
          elseif(isset($_POST[$yr])&&strlen($_POST[$yr])>0&&isset($_POST[$dc])&&strlen($_POST[$dc])>0){

            if(!is_numeric($_POST[$yr])){$_SESSION['error1']="Year must be numeric";
              header("Location:add.php");
              exit;}
          //iki varsa bunu yap
            else{$ikivar=true;}
          }

        }if(isset($_POST[$eyr])||isset($_POST[$eschl])){
            if(!isset($_POST[$eyr])||strlen($_POST[$eyr])<1||!isset($_POST[$eschl])||strlen($_POST[$eschl])<1) {
            $_SESSION['error1']="All fields are required123";
            header("Location:add.php");
            exit;
            }
            elseif(isset($_POST[$eyr])&&strlen($_POST[$eyr])>0&&isset($_POST[$eschl])&&strlen($_POST[$eschl])>0){

              if(!is_numeric($_POST[$eyr])){$_SESSION['error1']="Year must be numeric";
                header("Location:add.php");
                exit;}
            //iki varsa bunu yap
              else{$ucvar=true;}
            }

          }


      }

      if(!$ikivar&&!$ucvar){//bir var iki yok uc yok
        $stmt=$pdo->prepare("INSERT INTO profile set user_id=:ui,first_name=:fn,last_name=:ln,email=:em,headline=:hl,summary=:sm");
        $stmt->execute(array(
          ':ui'=>$_SESSION['user_id'],
          ':fn'=>$_POST['first_name'],
          ':ln'=>$_POST['last_name'],
          ':em'=>$_POST['email'],
          ':hl'=>$_POST['headline'],
          ':sm'=>$_POST['summary']
        ));
  $_SESSION['success']="Record added";
  header("Location:index.php");
  exit;
      }
      elseif($ikivar&&!$ucvar){//bit var iki de var uc yok
        $stmt=$pdo->prepare("INSERT INTO profile set user_id=:ui,first_name=:fn,last_name=:ln,email=:em,headline=:hl,summary=:sm");
        $stmt->execute(array(
          ':ui'=>$_SESSION['user_id'],
          ':fn'=>$_POST['first_name'],
          ':ln'=>$_POST['last_name'],
          ':em'=>$_POST['email'],
          ':hl'=>$_POST['headline'],
          ':sm'=>$_POST['summary']
        ));
        $profile_id=$pdo->lastInsertId();
        for($i=1;$i<10;$i++){
          $yr="year".$i;
          $dc="desc".$i;
          if(isset($_POST[$yr])&&strlen($_POST[$yr])>0&&isset($_POST[$dc])&&strlen($_POST[$dc])>0){
            $stmt=$pdo->prepare("INSERT INTO position set profile_id=:pid,rank=:rnk,year=:yr,description=:dc");
            $stmt->execute(array(
              ":pid"=>$profile_id,
              ":rnk"=>$i,
              ":yr"=>$_POST[$yr],
              ":dc"=>$_POST[$dc]

            ));
          }


      }
          $_SESSION['success']="Records added".$profile_id;
          header("Location:index.php");
          exit;
      }
      elseif(!$ikivar&&$ucvar){//bir var uc var iki yok
        $stmt=$pdo->prepare("INSERT INTO profile set user_id=:ui,first_name=:fn,last_name=:ln,email=:em,headline=:hl,summary=:sm");
        $stmt->execute(array(
          ':ui'=>$_SESSION['user_id'],
          ':fn'=>$_POST['first_name'],
          ':ln'=>$_POST['last_name'],
          ':em'=>$_POST['email'],
          ':hl'=>$_POST['headline'],
          ':sm'=>$_POST['summary']
        ));
        $profile_id=$pdo->lastInsertId();
        for($i=1;$i<10;$i++){;
          $eyr="edu_year".$i;
          $esl="edu_school".$i;
          print $_POST[$eyr].$_POST[$esl];
          $stmt=$pdo->query("SELECT institution_id FROM institution where name='".$_POST[$esl]."'");
          foreach($stmt as $row){
            $data=array(
              'name'=>$row['institution_id']
            );
          }
          $eschl=$data['name'];
          if(isset($_POST[$eyr])&&strlen($_POST[$eyr])>0&&isset($_POST[$esl])&&strlen($_POST[$esl])>0){
            $stmt=$pdo->prepare("INSERT INTO education set profile_id=:pid,rank=:rnk,year=:yr,institution_id=:iid");
            $stmt->execute(array(
              ":pid"=>$profile_id,
              ":rnk"=>$i,
              ":yr"=>$_POST[$eyr],
              ":iid"=>$eschl
            ));
          }


      }
          $_SESSION['success']="Records added13";
          header("Location:index.php");
          exit;

      }
      elseif($ikivar&&$ucvar){//hepsi var
        $stmt=$pdo->prepare("INSERT INTO profile set user_id=:ui,first_name=:fn,last_name=:ln,email=:em,headline=:hl,summary=:sm");
        $stmt->execute(array(
          ':ui'=>$_SESSION['user_id'],
          ':fn'=>$_POST['first_name'],
          ':ln'=>$_POST['last_name'],
          ':em'=>$_POST['email'],
          ':hl'=>$_POST['headline'],
          ':sm'=>$_POST['summary']
        ));
        $profile_id=$pdo->lastInsertId();
        for($i=1;$i<10;$i++){
          $yr="year".$i;
          $dc="desc".$i;
          if(isset($_POST[$yr])&&strlen($_POST[$yr])>0&&isset($_POST[$dc])&&strlen($_POST[$dc])>0){
            $stmt=$pdo->prepare("INSERT INTO position set profile_id=:pid,rank=:rnk,year=:yr,description=:dc");
            $stmt->execute(array(
              ":pid"=>$profile_id,
              ":rnk"=>$i,
              ":yr"=>$_POST[$yr],
              ":dc"=>$_POST[$dc]

            ));
          }


      }
      for($i=1;$i<10;$i++){
        $count=0;
        $eyr="edu_year".$i;
        $esl="edu_school".$i;
        $stmt=$pdo->query("SELECT institution_id FROM institution where name='".$_POST[$esl]."'");
        foreach($stmt as $row){
          $data=array(
            'name'=>$row['institution_id']
          );
        }
        $eschl=$data['name'];
        print $count;
        $count++;
        if(isset($_POST[$eyr])&&strlen($_POST[$eyr])>0&&isset($_POST[$esl])&&strlen($_POST[$esl])>0){
          $stmt=$pdo->prepare("INSERT INTO education set profile_id=:pid,rank=:rnk,year=:yr,institution_id=:iid");
          $stmt->execute(array(
            ":pid"=>$profile_id,
            ":rnk"=>$i,
            ":yr"=>$_POST[$eyr],
            ":iid"=>$eschl
          ));
        }


    }
        $_SESSION['success']="Records added123";
        header("Location:index.php");
        exit;

      }
    }

}






?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Mehmet Akif Yanılmaz</title>
    <link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
    crossorigin="anonymous">

<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
    crossorigin="anonymous">

<link rel="stylesheet"
    href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"
    integrity="sha384-xewr6kSkq3dBbEtB6Z/3oFZmknWn7nHqhLVLrYgzEFRbU/DHSxW7K3B44yWUN60D"
    crossorigin="anonymous">

<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>

<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous"></script>
  </head>
  <body>
    <h1>Editing Profile for UMSI</h1>
    <?php
    if(isset($_SESSION['error'])){

      echo "<p style='color:red;'>".htmlentities($_SESSION['error'])."</p>";
      unset($_SESSION['error']);
    }  if(isset($_SESSION['error1'])){

        echo "<p style='color:red;'>".htmlentities($_SESSION['error1'])."</p>";
        unset($_SESSION['error1']);
      }
     ?>
    <form method="post" action="add.php">
    <p>First Name:
    <input type="text" name="first_name" size="60"

    /></p>
    <p>Last Name:
    <input type="text" name="last_name" size="60"

    /></p>
    <p>Email:
    <input type="text" name="email" size="30"

    /></p>
    <p>Headline:<br/>
    <input type="text" name="headline" size="80"

    /></p>
    <p>Summary:<br/>
    <textarea name="summary" rows="8" cols="80"></textarea>
    <p>
    <input type="hidden" name="profile_id"
    value=""
    />
    </p>
    <p>
    Education: <input type="submit" id="addEdu" value="+">
    <div id="edu_fields">

    </div>
    </p>
    <label for="">Positions</label>
    <input type="submit" id="addPos" value="+">
    <div id="position_fields">

    </div>
    <input type="submit" value="Add">
    <input type="submit" name="cancel" value="Cancel">
    </p>
    </form>



<script type="text/javascript">
countPos = 0;
countEdu = 0;
  $(document).ready(function(){
  window.console && console.log('Document ready called');
  $('#addPos').click(function(event){
      // http://api.jquery.com/event.preventdefault/
      event.preventDefault();
      if ( countPos >= 9 ) {
          alert("Maximum of nine position entries exceeded");
          return;
      }
      countPos++;
      window.console && console.log("Adding position "+countPos);
      $('#position_fields').append(
        '<div id="position'+countPos+'"> \
          <p>Year: <input type="text" name="year'+countPos+'" value="" /> \
          <input type="button" value="-" \
              onclick="$(\'#position'+countPos+'\').remove();return false;"></p> \
          <textarea name="desc'+countPos+'" rows="8" cols="80"></textarea>\
          </div>');
  });
  $('#addEdu').click(function(event){
        event.preventDefault();
        if ( countEdu >= 9 ) {
            alert("Maximum of nine education entries exceeded");
            return;
        }
        countEdu++;
        window.console && console.log("Adding education "+countEdu);

        $('#edu_fields').append(
            '<div id="edu'+countEdu+'"> \
            <p>Year: <input type="text" name="edu_year'+countEdu+'" value="" /> \
            <input type="button" value="-" onclick="$(\'#edu'+countEdu+'\').remove();return false;"><br>\
            <p>School: <input type="text" size="80" name="edu_school'+countEdu+'" class="school" value="" />\
            </p></div>'
        );

        $('.school').autocomplete({
            source: "school.php"
        });

    });
});
    </script>


  </body>
</html>
