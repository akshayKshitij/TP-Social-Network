<?php 
require '../models/friendClasses.php'; 
require '../settings.php';
$id1 = intval($_GET['q']);
$id2 = intval($_GET['r']);
$friendship=new Friends($id1,$id2);
$friendship->unfriend();
unset($friendship);
?>
