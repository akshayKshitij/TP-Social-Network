<?php 
require '../models/wallClasses.php'; 
require '../models/user.php'; 
$q = intval($_GET['q']);
$text=$_GET['r'];
$post_id=Post::addPost($q,$text);
echo $post_id.",".User::getUser($q)->name;
?>
