<!--To ensure that the person is logged in-->
<?php
if (!isset($_SESSION['user_id']))
{
	header("Location: ../main_pages/login.html");
	die();
}
?>

<script>
function getNotifications(userId)
{
	var myNode = document.getElementById("notifications");
	while (myNode.firstChild) 
	{
    	myNode.removeChild(myNode.firstChild);
	}
	var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function() 
    {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
        {
			$("#notifications").prepend(xmlhttp.responseText);
        }
    }
    xmlhttp.open("GET", "../ajax/getNotifications.php?userId=" + userId.toString(), true);
    xmlhttp.send();
}
</script>

<!--NAVBAR-->
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">TP-Social-Network</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="../main_pages/profile_page.php">Profile Page<span class="sr-only">(current)</span></a></li>
        <li><a href="../main_pages/make_new_friends.php">Make new Friends</a></li>
        <li class="dropdown" style="width:200px">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" onclick="getNotifications(<?php echo $_SESSION['user_id']; ?>)">Notifications <span class="caret"></span></a>
          <ul class="dropdown-menu" role="menu" id="notifications">
      
          </ul>
        </li>
      </ul>
      <form class="navbar-form navbar-left" role="search" method="post" action="search_people.php">
        <div class="form-group">
          <input name="search_query" type="text" class="form-control" placeholder="Search People">
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#" onclick=" window.location.assign('logout.php')">Logout</a></li>
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Settings<span class="caret"></span></a>
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
