<?php

Class Friends
{
	public $id1;
 	public $id2;
 	
 	public function __construct($a1,$a2)
  	{
      	$this->id1=$a1;
      	$this->id2=$a2;
  	}
  	
  	public function __destruct()
  	{
  	}
  
 	public function unfriend()
 	{
 		// Create connection
		$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
		// Check connection
		if ($conn->connect_error) 
		{
			die("Connection failed: " . $conn->connect_error);
		}
		$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
		// sql to delete a record
		$a1=$this->id1;
		$a2=$this->id2;
		$sql = "DELETE FROM Friends WHERE (id1=$a1 AND id2=$a2) OR (id1=$a2 AND id2=$a1);";

		if ($conn->query($sql) === TRUE) {}
		else 
		{
			echo "Error deleting record: " . $conn->error;
		}
		$conn->close();
		return null; 
 	}
 	
 	public function save()
 	{
 		// Create connection
		$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
		// Check connection
		if ($conn->connect_error) 
		{
			die("Connection failed: " . $conn->connect_error);
		}
		$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
		// sql to delete a record
		$a1=$this->id1;
		$a2=$this->id2;
		$sql ="INSERT INTO Friends (id1,id2) VALUES ($a1,$a2);";

		if ($conn->query($sql) === TRUE) 
		{
			$sql="INSERT INTO Friends (id1,id2) VALUES ($a2,$a1);";
			if ($conn->query($sql) === TRUE){}
			else 
			{
				echo "Error inserting record: " . $conn->error;
			}
		}
		else 
		{
			echo "Error inserting record: " . $conn->error;
		}
		$conn->close();
		return null; 
 	}
 	
 	public static function areFriends($user1,$user2)
 	{
 		// Create connection
		$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
		// Check connection
		if ($conn->connect_error) 
		{
			die("Connection failed: " . $conn->connect_error);
		}
		$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
		// sql to delete a record
		$a1=$user1->userId;
		$a2=$user2->userId;
		$sql = "Select * FROM Friends WHERE id1=$a1 AND id2=$a2";
		$result = $conn->query($sql);
		if ($result->num_rows == 1)
		{
			$areFriends=true;
		}
		else 
		{
			$areFriends=false;
		}
		$conn->close();
		return $areFriends;
 	}

}
 

Class FriendRequests
{
	public $senderId;
	//The person who made the friend request.
 	public $receiverId;
 	
 	public function __construct($a1,$a2)
  	{
      	$this->senderId=$a1;
      	$this->receiverId=$a2;
  	}
  	
  	public function __destruct()
  	{
  	}
  	
  	public function delete()
 	{
 		// Create connection
		$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
		// Check connection
		if ($conn->connect_error) 
		{
			die("Connection failed: " . $conn->connect_error);
		}
		$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
		// sql to delete a record
		$a1=$this->senderId;
		$a2=$this->receiverId;
		$sql = "DELETE FROM Friend_Requests WHERE sender_id=$a1 AND receiver_id=$a2";

		if ($conn->query($sql) === TRUE) {}
		else 
		{
			echo "Error deleting record: " . $conn->error;
		}
		$conn->close();
		return null; 
 	}
 	
 	public static function sentRequest($sender,$receiver)
 	{
 		// Create connection
		$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
		// Check connection
		if ($conn->connect_error) 
		{
			die("Connection failed: " . $conn->connect_error);
		}
		$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
		// sql to delete a record
		$a1=$sender->userId;
		$a2=$receiver->userId;
		$sql = "Select * FROM Friend_Requests WHERE sender_id=$a1 AND receiver_id=$a2";
		$result = $conn->query($sql);
		if ($result->num_rows == 1)
		{
			$requestSent=true;
		}
		else 
		{
			$requestSent=false;
		}
		$conn->close();
		return $requestSent;
 	}
 	
 	public function add()
 	{
 		// Create connection
		$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
		// Check connection
		if ($conn->connect_error) 
		{
			die("Connection failed: " . $conn->connect_error);
		}
		$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
		// sql to delete a record
		$a1=$this->senderId;
		$a2=$this->receiverId;
		$sql ="INSERT INTO Friend_Requests (sender_id,receiver_id) VALUES ($a1,$a2);";

		if ($conn->query($sql) === TRUE) {}
		else 
		{
			echo "Error deleting record: " . $conn->error;
		}
		$conn->close();
		return null; 
 	}
}

Class Interest
{
	//just a primary key. 
	public $entryId;
	//The person who the interest is for
 	public $userId;
 	public $interestText;
}

?>
