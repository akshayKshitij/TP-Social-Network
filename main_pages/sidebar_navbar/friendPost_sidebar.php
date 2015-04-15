<div style="margin-left:30px;">
			 	<h3> <?php echo $wallUser->name ?> </h3>
			 	<img src="uploads/<?php echo $wallUser->userId.'.jpg' ?>" alt="Profile Photo" width="200" height="280" >
				<br>
			 
				<ul class="nav nav-pills nav-stacked">
				<li class="active" onclick=" window.location.assign('profile_page.php')"><a href="#">View Posts</a></li>
				<li><a href="#" onclick=" window.location.assign('viewFriends.php')">View Friends</a></li>
				<li><a href="#">View Friend Requests</a></li>
				<li><a href="#">Post a new Question</a></li>
				</ul>	
		    </div>
