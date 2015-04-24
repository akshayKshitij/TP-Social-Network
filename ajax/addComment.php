<?php 
require '../models/wallClasses.php'; 
require '../models/user.php'; 
$postId = intval($_GET['postId']);
$commentorId = intval($_GET['commentorId']);
$userId = intval($_GET['userId']);
$commentText=$_GET['commentText'];
Comment::addComment($postId,$commentorId,$userId,$commentText);
echo User::getUser($commentorId)->name;
?>
