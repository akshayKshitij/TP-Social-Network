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

</head>

<body style="background-color:white">

<!--Navbar-->
<?php include 'sidebar_navbar/navbar.php'; ?>

<!--BOOTSTRAP COLUMN LAYOUT-->
<div class="row">
		 <div class="col-lg-3" style="color:black">
		 	<!--Sidebar-->
		 	<?php include 'sidebar_navbar/sidebar.php'; ?> 	
		</div>

		<div class="col-lg-9">
				<h3 id="heading"> MAKE A NEW FRIEND </h3>
				<div id="content" style="margin-left:30px;margin-right:200px;">
					<?php
					//edit this to include Kshitij's function
						$friendRecommendations=$user->suggestions($user->userId);
						$size=count($friendRecommendations);
						
						foreach($friendRecommendations as $recomendation => $x) 
						{
							$temp=User::getUser($recomendation);
							//Enclose the friend in a div which has id as its post_id.
							echo '<div>';
							echo '<h4><img src="uploads/'.$temp->userId.'.jpg" alt="Profile Photo" width="50" height="65" > &nbsp &nbsp';
							echo $temp->name;
							echo "(Age ".$temp->age.",".$temp->workCollege.",".$temp->country.")</h4>";
							
							echo '<form style="margin-top:5px" action="friendPage.php" method="POST"><button type="submit" class="btn btn-sm btn-primary ">View Profile</button><input type="hidden" name="wall_id" value="'.$temp->userId.'"></form>';
							echo '<br> <hr> <br>';
							echo '</div>';
						}
					?>
				</div>
				
		</div>

</div>

<script>
CKEDITOR.replace('new_post', {height: 100});

</script>
</body>
</html>
