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


<!--JAVASCRIPT-->
<script>
function deletePost(postid)
{
	
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
			var parent = document.getElementById("content");
			var child = document.getElementById("postNo"+postid);
			parent.removeChild(child);
			$.toaster({ priority : 'info', title : 'TP', message : "The Post has been deleted."});
        }
    }
    xmlhttp.open("GET", "../ajax/deletePost.php?q=" + postid.toString(), true);
    xmlhttp.send();
   
}

function addPost(userid)
{
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
        	
        	post_id=parseInt(xmlhttp.responseText.split(",")[0]);
			var newPost='<div id="postNo'+post_id+'">';
			newPost+= '<h4><img src="uploads/'+userid+'.jpg" alt="Profile Photo" width="50" height="65" > &nbsp &nbsp';
			newPost+= "Post by :"+ xmlhttp.responseText.split(",")[1];
			newPost+= '<button class="btn btn-sm btn-danger pull-right" onclick="deletePost('+post_id+')">Delete Post</button></h4>';
			newPost+= CKEDITOR.instances['new_post'].getData();
			newPost+="<br> <hr> <br>";
			newPost+= '</div>';
	
        	$( "#content" ).prepend(newPost);
			$.toaster({ priority : 'info', title : 'TP', message : "The Post has been added."});
			CKEDITOR.instances['new_post'].setData(" ");
			alert(xmlhttp.responseText);
        }
    }
    xmlhttp.open("GET", "../ajax/addPost.php?q=" + userid.toString() +"&r=" + CKEDITOR.instances['new_post'].getData(), true);
    xmlhttp.send();
   
}

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
<div class="row" >
		 <div class="col-lg-3" style="color:black;background-color:#F2F2EB;">
		 	<!--Sidebar-->
		 	<?php include 'sidebar_navbar/profile_sidebar.php'; ?>		 	
		</div>

		<div class="col-lg-6" style="background-color:#FBFBFB;height:700px">
				<h3 id="heading"> POSTS </h3>
				<div style="margin-left:30px;margin-right:30px;">
						<textarea id="new_post" name="new_post" placeholder="Enter text for the post"> </textarea> 
						<button class="btn btn-md btn-primary" style="margin-top:5px;" onclick="addPost(<?php echo $user->userId ?>)">Add Post</button>
						<br><hr><br>
				</div>
				<div id="content" style="margin-left:30px;margin-right:30px;">
				
				
					<?php
						$posts=$user->getPosts();
						//echo implode(" ",$posts);
						$size=count($posts);
						for ($i=0;$i<$size;$i++)
						{
							$temp=$posts[$size-$i-1];
							//Enclose the Post in a div which has id as its post_id.
							echo '<div id="postNo'.$temp['post_id'].'">';
							echo '<h4><img src="uploads/'.$temp["poster_id"].'.jpg" alt="Profile Photo" width="50" height="65" > &nbsp &nbsp';
							echo "Post by :". User::getUser($temp['poster_id'])->name;
							echo '<button class="btn btn-sm btn-danger pull-right" onclick="deletePost('.$temp['post_id'].')">Delete Post</button></h4>';
							echo $temp['Text'];
							echo "<br>";
						
							//echo '<div style="background-color:#A6B8ED">';
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
							echo '<button class="btn btn-xs" onclick="addComment('.$temp['post_id'].','.$user->userId.','.$user->userId.')">Add Comment</button></h4>';
							echo "<br> <hr> <br>";							
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
