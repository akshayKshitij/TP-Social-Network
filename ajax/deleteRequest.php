<?php 
require '../models/friendClasses.php'; 
require '../settings.php';
$senderId = intval($_GET['senderId']);
$receiverId = intval($_GET['receiverId']);
$friendReq=new FriendRequests($senderId,$receiverId);
$friendReq->delete();
unset($friendReq);
?>
