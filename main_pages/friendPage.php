<?php 
require '../models/user.php'; 
require '../models/friendClasses.php'; 
//require 'getFriends.php'; 
require '../models/wallClasses.php';
session_start();
$user=User::getUser($_SESSION['user_id']);
$wallUser=User::getUser($_POST['wall_id']);
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
function addPostToFriend(userid,wallid)
{
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
        	
        	post_id=parseInt(xmlhttp.responseText.split(",")[0]);
        	
			var newPost='<div>';
			newPost+= '<h4><img src="uploads/'+userid+'.jpg" alt="Profile Photo" width="50" height="65" > &nbsp &nbsp';
			newPost+= "Post by :"+ xmlhttp.responseText.split(",")[1];
			newPost+= CKEDITOR.instances['new_post'].getData();
			newPost+="<br> <hr> <br>";
			newPost+= '</div>';
	
        	$( "#content" ).prepend(newPost);
			$.toaster({ priority : 'success', title : 'TP', message : "The Post has been added."});
			CKEDITOR.instances['new_post'].setData(" ");
			
			alert(xmlhttp.responseText);
        }
    }
    xmlhttp.open("GET", "addPostToFriend.php?q=" + userid.toString() +"&r=" + CKEDITOR.instances['new_post'].getData() +"&s=" + wallid, true);
    xmlhttp.send();
   
}
</script>
</head>

<body style="background-color:white">

<!--Navbar-->
<?php include 'sidebar_navbar/navbar.php'; ?>

<!--BOOTSTRAP COLUMN LAYOUT-->
<div class="row">
		 <div class="col-lg-3" style="color:black">
		 	<!--Sidebar-->
		 	<?php include 'sidebar_navbar/friendPost_sidebar.php'; ?>		 	
		</div>

		<div class="col-lg-9">
				<h3 id="heading"> POSTS </h3>
				<div style="margin-left:30px;margin-right:30px;">
						<textarea id="new_post" name="new_post" placeholder="Enter text for the post"> </textarea> 
						<button class="btn btn-md btn-primary" onclick="addPostToFriend(<?php echo $user->userId.','.$_POST['wall_id'] ?>)">Post to <?php echo $wallUser->name ?>'s Wall</button>
						<br>
				</div>
				<div id="content" style="margin-left:30px;margin-right:30px;">
				
				
					<?php
						$posts=$wallUser->getPosts();
						//echo implode(" ",$posts);
						$size=count($posts);
						for ($i=0;$i<$size;$i++)
						{
							$temp=$posts[$size-$i-1];
							//Enclose the Post in a div which has id as its post_id.
							echo '<div>';
							echo '<h4><img src="uploads/'.$temp["poster_id"].'.jpg" alt="Profile Photo" width="50" height="65" > &nbsp &nbsp';
							echo "Post by :". User::getUser($temp['poster_id'])->name;
							echo $temp['Text'];
							
							$comments=Post::getComments($temp['post_id']);
							$size2=count($comments);
							for ($j=0;$j<$size2;$j++)
							{
								$temp2=$comments[$j];
								echo "<h6> Comment by :". User::getUser($temp2['commentor_id'])->name."</h6>";
								echo $temp2['text']."<br>";								
							}
							echo "<br> <hr> <br>";
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
