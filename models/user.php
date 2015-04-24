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
  
  public function suggestions($id)
  { 
    $conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql="CREATE VIEW level1 AS SELECT id1 'i1',id2 'i2' FROM Friends WHERE id1='$id'";
    mysqli_query($conn,$sql);
    $sql1="CREATE VIEW level2 AS SELECT Friends.id1,Friends.id2 FROM Friends INNER JOIN level1 ON Friends.id1=level1.i2 WHERE Friends.id2!='$id'";
    mysqli_query($conn,$sql1);
    $sql2="SELECT * FROM level2";
    $result=mysqli_query($conn,$sql2);
    $i=0;
    $row=mysqli_fetch_assoc($result);
    if($row!=null)
    {
        $temp=$row["id1"];
        $temp1=$row["id2"];
        $row1["$temp1"]=1;
    }
    while($row=mysqli_fetch_assoc($result))
    {       
            $temp=$row["id1"];
            $temp1=$row["id2"];
            $t1=$this->check($row1,$temp1);
            if($t1==-1)
                $row1["$temp1"]=1;
            else
                $row1["$temp1"]++;
            
    }
    arsort($row1);
    $sql1="DROP VIEW level1";
    $sql2="DROP VIEW level2";
    mysqli_query($conn,$sql1);
    mysqli_query($conn,$sql2);
    return $row1;
    /*foreach($row1 as $x => $x_value) 
     {
       echo "Key=" . $x . ", Value=" . $x_value;
       echo "<br>";
     } */         
    
  }
  public function check($row1,$id)
  {

     foreach($row1 as $x => $x_value) 
     {
        if($id==$x)
            return 1;
     }
     return -1;
  }
  public function search($id,$search,$a,$b,$c)
  {
    $conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $sql="SELECT * FROM User WHERE name LIKE '%$search%'";
    $result=mysqli_query($conn,$sql);
    $i=0;
    while($row=mysqli_fetch_assoc($result))
    {  
            $id1=$row['user_id'];
            $row1["$id1"][0]=0;
            $row1["$id1"][1]=0;
            $row1["$id1"][2]=0;
            $row1["$id1"][3]=0.0;
            $store[$i]=$id1;
            $i++;
    }
    
     //$this->checkname($store,$id); 
     $this->proximity($id,$search,$row1,$conn,$store);
     $this->interaction($id,$search,$row1,$conn,0.6,0.4,$store);
     $this->similarity($id,$search,$row1,$conn,$store);

     $temp=count($store);
     for($x=0;$x<$temp;$x++)
     {
        $index=$store[$x];
        $t1=(float)($a*$row1["$index"][0]);
        $t2=(float)($b*$row1["$index"][1]);
        $t3=(float)($c*$row1["$index"][2]);
        $row1["$index"][3]=$t1+$t2+$t3;
        $FINAL["$index"]=$row1["$index"][3];
     }
     arsort($FINAL);
     foreach($FINAL as $x => $x_value) 
     {
       echo "Key=" . $x . ", Value=" . $x_value;
       echo "<br>";
     } 
     return $FINAL;

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
        }
    }
    $size=count($store);
    for($x=0;$x<$size;$x++)
    {       
        $index=$store[$x];
        $temp=$rowp["$index"][2];

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
    }
    
  }
  public function similarity($id,$search,&$row1,$conn,$store)
  {
    $rowden=$row1;
    $rownum=$row1;
    $sql="CREATE VIEW tempuser AS SELECT interest_text FROM Interest WHERE user_id='$id'";
    mysqli_query($conn,$sql);
    $sql4="SELECT COUNT(*) AS common FROM tempuser";
    $result=mysqli_query($conn,$sql4);
    $row=mysqli_fetch_assoc($result);
    $user_int=$row['common'];
    
    $size=count($store);
    for($x=0;$x<$size;$x++)
    {       
        $index=$store[$x];
        $sql2="CREATE VIEW temp1 AS SELECT interest_text 'hobby' FROM Interest WHERE user_id='$index'";
        mysqli_query($conn,$sql2);
        
        $sql4="SELECT COUNT(*) AS common FROM temp1";
        $result=mysqli_query($conn,$sql4);
        $row=mysqli_fetch_assoc($result);
        $rowden["$index"][1]=$row['common']+$user_int;
        
        $sql3="CREATE VIEW temp2 AS SELECT interest_text 'hobby2' FROM tempuser INNER JOIN temp1 ON temp1.hobby=tempuser.interest_text";
        mysqli_query($conn,$sql3);
        
        $sql4="SELECT COUNT(*) AS common FROM temp2";
        $result=mysqli_query($conn,$sql4);
        $row=mysqli_fetch_assoc($result);
        $answer=$row['common'];
        $rownum["$index"][1]=$answer;
        $rowden["$index"][1]-=$answer;
        $sql1="DROP VIEW temp1";
        $sql2="DROP VIEW temp2";
        mysqli_query($conn,$sql1);
        mysqli_query($conn,$sql2);
    }
    $sql1="DROP VIEW tempuser";
    mysqli_query($conn,$sql1);
    
    $sql="SELECT country,age FROM User WHERE user_id='$id'";
    $result=mysqli_query($conn,$sql);
    $row=mysqli_fetch_assoc($result);
    $country=$row['country'];
    $age=$row['age'];
    
    $sql="CREATE VIEW temp4 AS SELECT user_id FROM User WHERE country='$country'";
    mysqli_query($conn,$sql);
    $sql2="SELECT * FROM temp4";
    $result=mysqli_query($conn,$sql2);
    while($row=mysqli_fetch_assoc($result))
    {       
            $temp=$row["user_id"];
            $t1=$this->checkname($store,$temp);
            if($t1!=-1)
            {   
                $rownum["$temp"][1]+=2;
            }   
    }
    $sql1="DROP VIEW temp4";
    mysqli_query($conn,$sql1);
    $lower=$age-2;
    $upper=$age+2;
    $sql="CREATE VIEW temp6 AS SELECT user_id FROM User WHERE age BETWEEN '$lower' AND '$upper'";
    mysqli_query($conn,$sql);
    $sql2="SELECT * FROM temp6";
    $result=mysqli_query($conn,$sql2);
    while($row=mysqli_fetch_assoc($result))
    {       
            $temp=$row["user_id"];
            $t1=$this->checkname($store,$temp);
            if($t1!=-1)
            {   
                $rownum["$temp"][1]+=5;
            }   
    }
    $sql1="DROP VIEW temp6";
    mysqli_query($conn,$sql1);
    for($x=0;$x<$size;$x++)
    {
        $index=$store[$x];
        $numerator=$rownum["$index"][1];
        $denominator=$rowden["$index"][1]+7;
        $row1["$index"][1]=$numerator/$denominator;

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
		$sql1="INSERT INTO User (name,username,email,password,age,country,gender,dob,work_college) VALUES ('".$this->name."', '".$this->username."','".$this->email."','".$hash."','".$this->age."','".$this->country."','".$this->gender."','".$this->date."','".$this->workCollege."')";
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
  
  
  public function getInterests()
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
  	$sql = "SELECT interest_text FROM Interest WHERE user_id=$id";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		$interests=array();
		while($row = $result->fetch_assoc()) 
		{
			array_push($interests,$row);
	    }
	} 
	else 
	{
	    $interests=null;
	    echo "No interests found";
	}
	$conn->close();
	return $interests;
  }
  
}

