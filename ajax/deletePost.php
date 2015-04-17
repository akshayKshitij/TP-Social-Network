<?php 
require '../models/wallClasses.php'; 
require '../settings.php';
$q = intval($_GET['q']);
$temp=Post::deletePost($q);
?>
