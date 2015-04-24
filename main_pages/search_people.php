<?php 
require '../models/user.php'; 
require '../models/friendClasses.php'; 
//require 'getFriends.php'; 
require '../models/wallClasses.php';
session_start();
$user=User::getUser($_SESSION['user_id']);
if (isset($_POST['search_query']))
{
	$searchQuery=$_POST['search_query'];
	$_SESSION['search_query']=$_POST['search_query'];
}
else
{
	$searchQuery=$_SESSION['search_query'];
}
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
		 <div class="col-lg-3" style="color:black;background-color:#F2F2EB;">
		 	<!--Sidebar-->
		 	<?php include 'sidebar_navbar/sidebar.php'; ?> 	
		</div>

		<div class="col-lg-6" style="background-color:#FBFBFB;height:700px">
				<h3 id="heading"> SEARCH RESULT </h3>
				<div id="content" style="margin-left:30px;margin-right:200px;">
					<?php
					//edit this to include Kshitij's function
						$personSearch=$user->search($user->userId,$searchQuery,Settings::$proximitiyCoeff,Settings::$interactionCoeff,Settings::$similarityCoeff);
						$size=count($personSearch);
						foreach($personSearch as $person => $x) 
						{
							$temp=User::getUser($person);
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
