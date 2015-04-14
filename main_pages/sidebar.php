<div style="margin-left:30px;">
			 	<h3> <?php echo $user->name ?> </h3>
			 	<img src="uploads/<?php echo $user->userId.'.jpg' ?>" alt="Profile Photo" width="200" height="280" >
				<br><br>
					 
				<ul class="nav nav-pills nav-stacked">
				<li class="active"><a href="#">View POSTS</a></li>
				<li><a href="#" onclick="showFriends(<?php echo $user->userId ?>)">View Friends</a></li>
				<li><a href="#">View Friend Requests</a></li>
				<li><a href="#">Post a new Question</a></li>
				</ul>	
		    </div>
