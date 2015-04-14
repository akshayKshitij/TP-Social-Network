<?php 
require '../models/user.php'; 
require '../models/friendClasses.php'; 
//require 'getFriends.php'; 
require '../models/wallClasses.php';
$user=User::getUser($_POST['user_id']);
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


<!--JAVASCRIPT-->
<script>
function showFriends(id)
{
	document.getElementById("heading").innerHTML = "FRIENDS";
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
                document.getElementById("content").innerHTML = xmlhttp.responseText;
        }
    }
    xmlhttp.open("GET", "getFriends.php?q=" + id.toString(), true);
    xmlhttp.send();
    
}

//not implemented yet
function deletePost(postid)
{
	/*
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
			var parent = document.getElementById("content");
			var child = document.getElementById("p1");
			parent.removeChild(child);
        }
    }
    xmlhttp.open("GET", "deletePost.php?q=" + postid.toString(), true);
    xmlhttp.send();
    */
}
</script>
</head>

<body style="background-color:white">

<!--NAVBAR-->
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">TP</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Link <span class="sr-only">(current)</span></a></li>
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
            <li class="divider"></li>
            <li><a href="#">One more separated link</a></li>
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" role="search">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#">Link</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu">
            <li><a href="#">Action</a></li>
            <li><a href="#">Another action</a></li>
            <li><a href="#">Something else here</a></li>
            <li class="divider"></li>
            <li><a href="#">Separated link</a></li>
          </ul>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<!--NAVBAR END-->

<!--BOOTSTRAP COLUMN LAYOUT-->
<div class="row">
		 <div class="col-lg-3" style="color:black">
		 	<div style="margin-left:30px;">
			 	<h3> <?php echo $user->name ?> </h3>
			 	<img src="uploads/<?php echo $user->userId.'.jpg' ?>" alt="Profile Photo" width="200" height="280" >
				<br><br>
					 
				<ul class="nav nav-pills nav-stacked">
				<li class="active"><a href="#">View Profile Page</a></li>
				<li><a href="#" onclick="showFriends(<?php echo $user->userId ?>)">View Friends</a></li>
				<li><a href="#">View Friend Requests</a></li>
				<li><a href="#">Post a new Question</a></li>
				</ul>	
		        </div>
		</div>

		<div class="col-lg-9">
				<h3 id="heading"> POSTS </h3>
				<div id="content" style="margin-left:30px;margin-right:30px;">
					<?php
						$posts=$user->getPosts();
						//echo implode(" ",$posts);
						$size=count($posts);
						for ($i=0;$i<$size;$i++)
						{
							$temp=$posts[$i];
							echo '<div id="postNo'.$temp['post_id'].'">';
							echo '<h4><img src="uploads/'.$temp["poster_id"].'.jpg" alt="Profile Photo" width="50" height="65" > &nbsp &nbsp';
							echo "Post by :". User::getUser($temp['poster_id'])->name;
							echo '<button class="btn btn-xs btn-danger pull-right" onclick="deletePost('.$temp['post_id'].')">Delete Post</button></h4>';
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

</body>
</html>
