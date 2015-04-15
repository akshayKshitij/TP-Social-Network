<div style="margin-left:30px;">
			 	<h3> <?php echo $wallUser->name ?> </h3>
			 	<img src="uploads/<?php echo $wallUser->userId.'.jpg' ?>" alt="Profile Photo" width="200" height="280" >
				<br><br>
			 
				<ul class="nav nav-pills nav-stacked">
				<li ><a href="#" onclick=" window.location.assign('friendPage.php')">View <?php echo $wallUser->name ?>'s Posts</a></li>
				<li class="active"><a href="#" >View <?php echo $wallUser->name ?>'s Friends</a></li>
				</ul>	
		    </div>
