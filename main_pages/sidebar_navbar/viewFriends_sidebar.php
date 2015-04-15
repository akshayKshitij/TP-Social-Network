<div style="margin-left:30px;">
			 	<h3> <?php echo $user->name ?> </h3>
			 	<img src="uploads/<?php echo $user->userId.'.jpg' ?>" alt="Profile Photo" width="200" height="280" >
				<br>
				<form action="upload.php" method="post" enctype="multipart/form-data">
				<input type="file" name="fileToUpload" id="fileToUpload">
				<input type="hidden" name="userid" value="<?php echo $user->userId ?>">
				<input type="submit" value="Upload Image" name="submit">
				</form>
				<br>
									 
				<ul class="nav nav-pills nav-stacked">
				<li><a href="#" onclick=" window.location.assign('profile_page.php')">View Posts</a></li>
				<li class="active"><a href="#" >View Friends</a></li>
				<li><a href="#">View Friend Requests</a></li>
				<li><a href="#">Post a new Question</a></li>
				</ul>	
		    </div>
