<?php 
require '../models/user.php'; 
$q = intval($_GET['q']);
$friends=User::getUser($q)->getFriends();

$size=count($friends);
for ($i=0;$i<$size;$i++)
{
	echo $friends[$i]['name'];
	echo "<br><hr>";
}	
echo $i
?>
