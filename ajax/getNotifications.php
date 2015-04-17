<?php 
require '../models/wallClasses.php'; 
require '../models/user.php'; 
$userId = intval($_GET['userId']);
$user=User::getUser($userId);

echo "POST NOTIFICATIONS <br><hr>";
$newPosts=$user->getPostNotifications();
$size=count($newPosts);
for ($i=0;$i<$size;$i++)	
{
	$temp=$newPosts[$size-$i-1];
	//Enclose the friend in a div which has id as its post_id.
	echo '<li>';
	echo '<h4><img src="uploads/'.$temp['posted_by_id'].'.jpg" alt="Profile Photo" width="50" height="65" > &nbsp &nbsp';
	echo User::getUser($temp['posted_by_id'])->name."</h4> has posted to your wall";			
	echo '<form style="margin-top:5px" action="friendPage.php" method="POST"><button type="submit" class="btn btn-sm btn-primary ">View Profile</button><input type="hidden" name="wall_id" value="'.$temp['posted_by_id'].'"></form>';
	echo '</li>';
}

echo "<br><hr><br>";

echo "FRIEND REQUESTS <br><hr>";
$friendRequesters=$user->getFriendRequests();
$size=count($friendRequesters);
for ($i=0;$i<$size;$i++)	
{
	$temp=$friendRequesters[$size-$i-1];
	//Enclose the friend in a div which has id as its post_id.
	echo '<li>';
	echo '<h4><img src="uploads/'.$temp['user_id'].'.jpg" alt="Profile Photo" width="50" height="65" > &nbsp &nbsp';
	echo $temp['name'];			
	echo '<form style="margin-top:5px" action="friendPage.php" method="POST"><button type="submit" class="btn btn-sm btn-primary ">View Profile</button><input type="hidden" name="wall_id" value="'.$temp['user_id'].'"></form>';
	echo '</li>';
}						
?>
