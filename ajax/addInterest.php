<?php 
require '../models/wallClasses.php'; 
require '../models/user.php'; 
$userId = intval($_GET['userId']);
$interestText=$_GET['interestText'];
User::addInterest($userId,$interestText);
?>
