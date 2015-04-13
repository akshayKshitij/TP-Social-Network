<?php
    require '../models/user.php';

    function checkpass($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
    $new=new User();
    $new->username=$_POST['user'];
    $new->password=$_POST['pass'];
    $new->password=checkpass($new->password);
    $new->save();

?>
