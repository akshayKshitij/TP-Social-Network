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
  public function search($id,$search)
  {
    $conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql="SELECT * FROM User WHERE name='$search'";
    $result=mysqli_query($conn,$sql);
    $i=0;
    while($row=mysqli_fetch_assoc($result))
    {  
            $id1=$row['user_id'];
            $row1["$id1"][0]=0;
            $row1["$id1"][1]=0;
            $row1["$id1"][2]=0;
            $store[$i]=$id1;
            $i++;
            //echo $id;
    }
    
     $this->checkname($store,$id); 
     echo "START NOW<br>";
     $this->proximity($id,$search,$row1,$conn,$store);
     $this->interaction($id,$search,$row1,$conn,0.6,0.4,$store);
     foreach($row1 as $x ) 
     {
         echo $x[2] . "\n";
         echo "<br>";
     }


  }
  public function checkname($store,$id)
  {
    $temp=count($store);
    for($x=0;$x<$temp;$x++)
    {   

        if($store[$x]==$id)
            return $store[$x];
    }
    return -1;
  }
public function proximity($id,$search,&$row1,$conn,$store)
  {
 
    $sql="CREATE VIEW level1 AS SELECT id1 'i1',id2 'i2' FROM Friends WHERE id1='$id'";
    mysqli_query($conn,$sql);
    $sql2="SELECT * FROM level1";
    $result=mysqli_query($conn,$sql2);
    while($row=mysqli_fetch_assoc($result))
    {       
            $temp=$row["i2"];
            $t1=$this->checkname($store,$temp);
            if($t1!=-1)
            {
                $row1["$temp"][0]=1;
                echo $temp;
                echo "KSHIIJ<br>";
            }
                
    }
    $sql1="CREATE VIEW level2 AS SELECT Friends.id1,Friends.id2 FROM Friends INNER JOIN level1 ON Friends.id1=level1.i2";
    mysqli_query($conn,$sql1);
    $sql2="SELECT * FROM try";
    $result=mysqli_query($conn,$sql2);
    while($row=mysqli_fetch_assoc($result))
    {       
            $temp=$row["id2"];
            $t1=$this->checkname($store,$temp);
            if($t1!=-1 && $row1["$temp"][0]==0)
            {   
                $row1["$temp"][0]=1/2;
                echo $temp;
                echo "KSHIIJ 2<br>";
            }   
    }
    $sql1="CREATE VIEW level3 AS SELECT Friends.id1,Friends.id2 FROM Friends INNER JOIN level2 ON Friends.id1=level2.id2";
    mysqli_query($conn,$sql1);
    $sql2="SELECT * FROM level3";
    $result=mysqli_query($conn,$sql2);
    while($row=mysqli_fetch_assoc($result))
    {       
            $temp=$row["id2"];
            $t1=$this->checkname($store,$temp);
            if($t1!=-1 && $row1["$temp"][0]==0)
            {   
                $row1["$temp"][0]=1/3;
                echo $temp;
                echo "KSHIIJ 3<br>";
            }
    }
    $sql1="DROP VIEW level1";
    $sql2="DROP VIEW level2";
    $sql3="DROP VIEW level3";
    mysqli_query($conn,$sql1);
    mysqli_query($conn,$sql2);
    mysqli_query($conn,$sql3);
  }
  public function interaction($id,$search,&$row1,$conn,$a,$b,$store)
  {
    $rowc=$row1;
    $rowp=$row1;
    $sql="Select poster_id,user_id FROM Post WHERE user_id='$id'";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result))
    {
        $temp=$row["poster_id"];
        $t1=$this->checkname($store,$temp);
        if($t1!=-1)
        {   
                $rowp["$temp"][2]++;
                echo $temp;
                echo "TOMAE<br>";
        }
    }
    
    $sql="Select poster_id,user_id FROM Post WHERE poster_id='$id'";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result))
    {
        $temp=$row["user_id"];
        $t1=$this->checkname($store,$temp);
        if($t1!=-1)
        {   
                $rowp["$temp"][2]++;
                echo $temp;
                echo "TOMAr 1<br>";
        }
    } 
    
    $sql="Select commentor_id,user_id FROM comment WHERE user_id='$id'";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result))
    {
        $temp=$row["commentor_id"];
        $t1=$this->checkname($store,$temp);
        if($t1!=-1)
        {   
                $rowc["$temp"][2]++;
                echo $temp;
                echo "TOMAR 2<br>";
        }
    }
    $sql="Select commentor_id,user_id FROM comment WHERE commentor_id='$id'";
    $result=mysqli_query($conn,$sql);
    while($row=mysqli_fetch_assoc($result))
    {
        $temp=$row["user_id"];
        $t1=$this->checkname($store,$temp);
        if($t1!=-1)
        {   
                $rowc["$temp"][2]++;
                echo $temp;
                echo "TOMAR 3<br>";
        }
    }
    $size=count($store);
    for($x=0;$x<$size;$x++)
    {       
        $index=$store[$x];
        $temp=$rowp["$index"][2];
        echo $temp;
        if($temp!=0)
            $temp=(float)(1-1/$temp);
        else
            $temp=0;
        $temp1=$rowc["$index"][2];
        
        if($temp1!=0)
            $temp1=(float)(1-1/$temp1);
        else
            $temp1=0;
        $temp2=$a*$temp+$b*$temp1;
        $row1["$index"][2]=$temp2;
        echo $row1["$index"][2];
        echo "answer<br>";
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
    	$mess="USERNAME IS ALREADY IN USE PLEASE GO BACK AND CHOOSE ANOTHER <br><a href='register.html'>CLICK HERE TO TRY AGAIN</a><br>";
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
  
}

