<?php 
require '../models/user.php'; 
require '../models/friendClasses.php'; 
//require 'getFriends.php'; 
require '../models/wallClasses.php';
session_start();
$user=User::getUser($_SESSION['user_id']);
if (isset($_POST['wall_id']))
{
	$wallUser=User::getUser($_POST['wall_id']);
}
else
{
	$wallUser=User::getUser($_SESSION['wall_id']);
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


<!--JAVASCRIPT-->
<script>
//Adding a Post on a friend's wall (Syntax taken from W3 schools site)
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
			$.toaster({ priority : 'info', title : 'TP', message : "The Post has been added."});
			CKEDITOR.instances['new_post'].setData(" ");
        }
    }
    xmlhttp.open("GET", "../ajax/addPostToFriend.php?q=" + userid.toString() +"&r=" + CKEDITOR.instances['new_post'].getData() +"&s=" + wallid, true);
    xmlhttp.send();
   
}
//will be called from a line in the sidebar
//sends a request to a person - 
function sendRequest(senderId,receiverId,receiverName)
{
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
			document.getElementById('friendOrNot').innerHTML ='<button class="btn btn-sm btn-info pull-right">You have sent a request</button>';
			$.toaster({ priority : 'info', title : 'TP', message : receiverName + " has receiver your friend request"});
        }
    }
    xmlhttp.open("GET", "../ajax/sendRequest.php?receiverId=" + receiverId.toString() + "&senderId=" +senderId.toString(), true);
    xmlhttp.send();

}

//used to add a comment
function addComment(postId,commentorId,userId)
{
	
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
        	var newComment="";
			newComment+= "<h6>Comment by :"+ xmlhttp.responseText + "</h6>";
			newComment+= document.getElementById("newCommentpostNo"+postId).value + "<br>";
								
        	$("#comments"+postId).append(newComment);
			$.toaster({ priority : 'info', title : 'TP', message : "The Comment has been added."});
			document.getElementById("newCommentpostNo"+postId).value=" ";
        }
    }
    xmlhttp.open("GET", "../ajax/addComment.php?postId=" + postId.toString() + "&commentorId=" + commentorId.toString() + "&userId=" + userId.toString() + "&commentText=" + document.getElementById("newCommentpostNo"+postId).value, true);
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
		 	<?php include 'sidebar_navbar/friendPost_sidebar.php'; ?>		 	
		</div>

		<!--Centre Part-->
		<div class="col-lg-6" style="background-color:#FBFBFB;height:700px">
				<h3 id="heading"> <?php echo $wallUser->name ?>'s POSTS </h3>
				<div style="margin-left:30px;margin-right:30px;">
						<textarea id="new_post" name="new_post" placeholder="Enter text for the post"> </textarea> 
						<button class="btn btn-md btn-primary" onclick="addPostToFriend(<?php echo $user->userId.','.$wallUser->userId ?>)">Post to <?php echo $wallUser->name ?>'s Wall</button>
						<br>
				</div>
				<div id="content" style="margin-left:30px;margin-right:30px;">
				
				
					<?php
						$posts=$wallUser->getPosts();
						$size=count($posts);
						//Iteratively print each post and its comments
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
							echo '<div id="comments'.$temp['post_id'].'" style="background-color:#F0F6FF;padding:10px 10px 10px 10px;">';
							for ($j=0;$j<$size2;$j++)
							{
								$temp2=$comments[$j];
								echo "<h6> Comment by :". User::getUser($temp2['commentor_id'])->name."</h6>";
								echo $temp2['text']."<br>";
							}
							echo '</div>';
							echo '<textarea rows="2" cols="50" id="newCommentpostNo'.$temp['post_id'].'" placeholder="Enter Comment here"> </textarea>';
							echo '<button class="btn btn-xs" onclick="addComment('.$temp['post_id'].','.$user->userId.','.$wallUser->userId.')">Add Comment</button></h4>';
							echo "<br> <hr> <br>";							
							echo '</div>';
						}
					?>
				</div>
				
		</div>
		
		<div class="col-lg-3" style="background-color:#F2F2EB;height:700px">
		 	<!--Rightbar-->
		 	<?php include 'sidebar_navbar/friend_rightbar.php'; ?>		 	
		</div>

</div>

<script>
CKEDITOR.replace('new_post', {height: 100});

</script>
</body>
</html>
