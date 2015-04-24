<?php 
require '../models/user.php'; 
require '../models/friendClasses.php'; 
//require 'getFriends.php'; 
require '../models/wallClasses.php';
session_start();
$user=User::getUser($_SESSION['user_id']);
$wallUser=User::getUser($_SESSION['wall_id']);
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

</script>
</head>

<body style="background-color:white">

<!--Navbar-->
<?php include 'sidebar_navbar/navbar.php'; ?>

<!--BOOTSTRAP COLUMN LAYOUT-->
<div class="row">
		 <div class="col-lg-3" style="color:black;background-color:#F2F2EB;">
		 	<!--Sidebar-->
		 	<?php include 'sidebar_navbar/friendViewFriends_sidebar .php'; ?> 	
		</div>

		<div class="col-lg-6" style="background-color:#FBFBFB;height:700px">
				<h3 id="heading"> <?php echo $wallUser->name ?>'s FRIENDS </h3>
				<div id="content" style="margin-left:30px;margin-right:30px;">
					<?php
						$friends=User::getUser($wallUser->userId)->getFriends();
						$size=count($friends);
						for ($i=0;$i<$size;$i++)	
						{
							$temp=$friends[$size-$i-1];
							//Should you try to access your name in the list of your Friend's friends
							if ($temp['user_id']==$user->userId)
							{
								continue;
							}
							//Enclose the Post in a div which has id as its post_id.
							echo '<div id="friendNo'.$temp['user_id'].'">';
							echo '<h4><img src="uploads/'.$temp['user_id'].'.jpg" alt="Profile Photo" width="50" height="65" > &nbsp &nbsp';
							echo $temp['name'];
							
							echo '<form style="margin-top:5px" action="friendPage.php" method="POST"><button type="submit" class="btn btn-sm btn-primary ">View Profile</button><input type="hidden" name="wall_id" value="'.$temp['user_id'].'"></form></h4>';

							echo "<br> <hr> <br>";
							echo '</div>';
						}
					?>
				</div>
				
		</div>

		<div class="col-lg-3" style="background-color:#F2F2EB;height:700px">
		 	<!--Sidebar-->
		 	<?php include 'sidebar_navbar/friend_rightbar.php'; ?>		 	
		</div>
</div>

<script>
CKEDITOR.replace('new_post', {height: 100});

</script>
</body>
</html>
