<?php
    //require '../settings.php';
    require '../models/user.php';
    function checkpass($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    $new=new User();
    $new->name=$_POST['name'];
    $new->password=$_POST['pass'];
    $new->password=checkpass($new->password);
    $new->username=$_POST['username'];
    $new->email=$_POST['mail'];
    $new->age=$_POST['age'];
    $new->country=$_POST['country'];
    $gender=$_POST['sex'];
    $new->date=$_POST['dob'];
    if($gender=="male")
        $new->gender=0;
    else
        $new->gender=1;
    $new->register();
?>

