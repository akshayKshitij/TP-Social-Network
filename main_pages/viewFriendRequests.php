<?php 
require '../models/user.php'; 
require '../models/friendClasses.php'; 
//require 'getFriends.php'; 
require '../models/wallClasses.php';
session_start();
$user=User::getUser($_SESSION['user_id']);
?>

<!DOCTYPE html>
<html>

<head>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<link href="../css/bootstrap.min.css" rel="stylesheet">
<link href="../css/select2.css" rel="stylesheet">
<script src="../js/bootstrap.min.js"></script>
<script src="../js/select2.js"></script>
<script src="../js/jquery.toaster.js"></script>
<script src="../js/ckeditor/ckeditor.js"></script>


<!--JAVASCRIPT-->
<script>
function addFriend(requesterId,userId,requesterName)
{
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
			var parent = document.getElementById("content");
			var child = document.getElementById("friendRequesterNo"+requesterId);
			parent.removeChild(child);
			$.toaster({ priority : 'success', title : 'TP', message : requesterName + "'s friend request has been accepted"});
        }
    }
    xmlhttp.open("GET", "../ajax/addFriend.php?receiverId=" + userId.toString() + "&senderId=" +requesterId.toString(), true);
    xmlhttp.send();

}

function deleteRequest(requesterId,userId,requesterName)
{
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
			var parent = document.getElementById("content");
			var child = document.getElementById("friendRequesterNo"+requesterId);
			parent.removeChild(child);
			$.toaster({ priority : 'info', title : 'TP', message : requesterName + "'s friend request has been rejected"});
        }
    }
    xmlhttp.open("GET", "../ajax/deleteRequest.php?receiverId=" + userId.toString() + "&senderId=" +requesterId.toString(), true);
    xmlhttp.send();
    
}
</script>
</head>

<body style="background-color:white">

<!--Navbar-->
<?php include 'sidebar_navbar/navbar.php'; ?>

<!--BOOTSTRAP COLUMN LAYOUT-->
<div class="row">
		 <div class="col-lg-3" style="color:black;background-color:#F2F2EB;">
		 	<!--Sidebar-->
		 	<?php include 'sidebar_navbar/viewFriendRequests_sidebar.php'; ?> 	
		</div>

		<div class="col-lg-6" style="background-color:#FBFBFB;height:700px">
				<h3 id="heading"> FRIEND REQUEST </h3>
				<div id="content" style="margin-left:30px;margin-right:200px;">
					<?php
						$friendRequesters=$user->getFriendRequests();
						$size=count($friendRequesters);
						for ($i=0;$i<$size;$i++)	
						{
							$temp=$friendRequesters[$size-$i-1];
							//Enclose the friend in a div which has id as its post_id.
							echo '<div id="friendRequesterNo'.$temp['user_id'].'">';
							echo '<h4><img src="uploads/'.$temp['user_id'].'.jpg" alt="Profile Photo" width="50" height="65" > &nbsp &nbsp';
							echo $temp['name']."</h4>";
							
							echo '<button class="btn btn-sm btn-success pull-right" onclick="addFriend('.$temp['user_id'].','.$user->userId.',\''.$temp['name'].'\')" style="margin-left:10px">Accept Friend Request</button> ';
							echo '<button class="btn btn-sm btn-danger pull-right" onclick="deleteRequest('.$temp['user_id'].','.$user->userId.',\''.$temp['name'].'\')">Delete Request</button>';
							
							echo '<form style="margin-top:5px" action="friendPage.php" method="POST"><button type="submit" class="btn btn-sm btn-primary ">View Profile</button><input type="hidden" name="wall_id" value="'.$temp['user_id'].'"></form>';
							

							echo '<br> <hr> <br>';
							echo '</div>';
						}
					?>
				</div>
				
		</div>

		<div class="col-lg-3" style="background-color:#F2F2EB;height:700px">
		<!--Rightbar-->
		<?php include 'sidebar_navbar/profile_rightbar.php'; ?>
		</div>
</div>

<script>
CKEDITOR.replace('new_post', {height: 100});

</script>
</body>
</html>
