<?php
require '../settings.php'; 
class User
{
  public $userId;
  public $username;
  public $name;
  public $email;
  public $password;
  public $age;
  public $country;
  public $gender;
  public $dob;
  public $workCollege;
  
  //Use this while logging in.
  public function save()
  {
    $conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
    if (!$conn) 
    {
        die("Connection failed: " . mysqli_connect_error());
    }
    $namesearch=$this->username;
    $sql="SELECT * FROM User where username='$namesearch'";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);
    $passdb=$row['password'];

    $k=0;
    
    if(password_verify($this->password,$passdb))
    {
        $k=1;
    }
	//If everything is successfull. Send to the profile page.
    if($row['username']==$this->username and $k==1)
    {
    	// Start the session
		session_start();
		$_SESSION["user_id"] = $row['user_id'];
		
		$a=Settings::$mainPageAddress;
		header("Location: $a/main_pages/profile_page.php");
		die();
    }

    else
    {
        echo "INVALID USERNAME OR PASSWORD";
        echo "<br><a href='login.html'>CLICK HERE TO TRY AGAIN</a><br>";
    }

    
  }
  
  public function register()
  {
    $conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $hash=password_hash($this->password, PASSWORD_DEFAULT);
    $sql="SELECT * FROM User where username='$this->username'";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);
    $id=1;
    if($row['username']==$this->username){
    	$mess="USERNAME IS ALREADY IN USE PLEASE GO BACK AND CHOOSE ANOTHER";
    }
    else{
		$sql1="INSERT INTO User (name,username,email,password,age,country,gender,dob) VALUES ('".$this->name."', '".$this->username."','".$this->email."','".$hash."','".$this->age."','".$this->country."','".$this->gender."','".$this->date."')";
		mysqli_query($conn,$sql1);

		$mess="registration successful <br><a href='login.html'>CLICK HERE TO LOGIN</a><br>";
    }
    echo $mess;
  } 

  public static function getUser($id)
  {
  	// Create connection
	$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
	// Check connection
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	}
	$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
  	$sql = "SELECT user_id,username,name,email,password,age,country,gender,dob,work_college FROM User WHERE user_id=$id";
	$result = $conn->query($sql);

	if ($result->num_rows == 1) {
	    $row = $result->fetch_assoc();
	    $user=new User();
	    $user->userId=$row['user_id'];
	    $user->username=$row['username'];
	    $user->name=$row['name'];
	    $user->email=$row['email'];
	    $user->age=$row['age'];
	    $user->gender=$row['gender'];
	    $user->dob=$row['dob'];
	    $user->workCollege=$row['work_college'];
	} 
	else 
	{
	    $user=null;
	    echo "USER NOT FOUND OR MULTIPLE USERS WITH SAME ID.";
	}
	$conn->close();
	return $user;
  }

  public function getPosts()
  {
  	// Create connection
	$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
	// Check connection
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	}
	$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
	$id=$this->userId;
  	$sql = "SELECT post_id,poster_id,user_id,Text FROM Post WHERE user_id=$id";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		$posts=array();
		while($row = $result->fetch_assoc()) 
		{
			array_push($posts,$row);
	    }
	} 
	else 
	{
	    $posts=null;
	    echo "NO POST FOUND";
	}
	$conn->close();
	return $posts;
  }
  
  public function getFriends()
  {
  	// Create connection
	$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
	// Check connection
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	}
	$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
	$id1=$this->userId;
  	$sql = "SELECT id2 FROM Friends WHERE id1=$id1";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		$friends=array();
		while($row = $result->fetch_assoc()) 
		{
			$a=$row['id2'];
			$sql2="SELECT user_id,name FROM User WHERE user_id=$a";
			$result2 = $conn->query($sql2);
			array_push($friends,$result2->fetch_assoc());
	    }
	} 
	else 
	{
	    $friends=null;
	    echo "NO FRIEND FOUND";
	}
	$conn->close();
	return $friends;
  }
  
  public function getFriendRequests()
  {
  	// Create connection
	$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
	// Check connection
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	}
	$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
	$id1=$this->userId;
  	$sql = "SELECT sender_id FROM Friend_Requests WHERE receiver_id=$id1";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		$friendRequesters=array();
		while($row = $result->fetch_assoc()) 
		{
			$a=$row['sender_id'];
			$sql2="SELECT user_id,name FROM User WHERE user_id=$a";
			$result2=$conn->query($sql2);
			array_push($friendRequesters,$result2->fetch_assoc());
	    }
	} 
	else 
	{
	    $friendRequesters=null;
	    echo "No Friend Requests Found.";
	}
	$conn->close();
	return $friendRequesters;
  }
  
  
  
  public function getPostNotifications()
  {
  	// Create connection
	$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
	// Check connection
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	}
	$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
	$id=$this->userId;
  	$sql = "SELECT posted_by_id FROM Post_Notifications WHERE posted_to_id=$id";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		$posts=array();
		while($row = $result->fetch_assoc()) 
		{
			array_push($posts,$row);
	    }
	} 
	else 
	{
	    $posts=null;
	    echo "No Post Notification";
	}
	
	//Now that the notification has been seen - delete it
	$sql = "DELETE FROM Post_Notifications WHERE posted_to_id=$id";
	if ($conn->query($sql) === TRUE) {}
	else 
	{
		echo "Error deleting record: " . $conn->error;
	}
		
	$conn->close();
	return $posts;
  }
  
}
