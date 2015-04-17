<?php 
require '../models/wallClasses.php'; 
require '../models/user.php'; 
$q = intval($_GET['q']);
$text=$_GET['r'];
$s=intval($_GET['s']);
$post_id=Post::addPostToFriend($q,$text,$s);
echo $post_id.",".User::getUser($q)->name;
?>
