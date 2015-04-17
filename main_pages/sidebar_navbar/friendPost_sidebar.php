<div style="margin-left:30px;">

			 	<h3> 
			 	<?php echo $wallUser->name;
			 	echo '<span id="friendOrNot">';
			 	if (Friends::areFriends($wallUser,$user))
			 	{
			 		echo '<button class="btn btn-sm btn-success pull-right">Friend</button>';
			 	}
			 	else if (FriendRequests::sentRequest($wallUser,$user))
			 	{
			 		echo '<button class="btn btn-sm btn-info pull-right">Has sent you a request</button>';
			 	}
			 	else if (FriendRequests::sentRequest($user,$wallUser))
			 	{
			 		echo '<button class="btn btn-sm btn-info pull-right">You have sent a request</button>';
			 	}
			 	else
			 	{
			 		echo '<button class="btn btn-sm btn-warning pull-right" onclick="sendRequest('.$user->userId.','.$wallUser->userId.',\''.$wallUser->name.'\');">Send Friend Request</button>';
			 	}
				 ?> 
				 </span></h3>
				 
			 	<img src="uploads/<?php echo $wallUser->userId.'.jpg' ?>" alt="Profile Photo" width="200" height="280" >
				<br><br>
				<?php 
				//necessary since the view_friends_friends.php doesnt know the wall_id
				$_SESSION['wall_id']=$wallUser->userId;
				?>
				<ul class="nav nav-pills nav-stacked">
				<li class="active"><a href="#">View <?php echo $wallUser->name ?>'s Posts</a></li>
				<li><a href="#" onclick=" window.location.assign('view_friends_friends.php')">View <?php echo $wallUser->name ?>'s Friends</a></li>
				</ul>	
		    </div>
