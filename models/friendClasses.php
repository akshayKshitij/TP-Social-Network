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
