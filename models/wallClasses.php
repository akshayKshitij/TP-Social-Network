<?php

Class Post
{
	public $postId;
	//The person who made the post.
 	public $posterId;
 	//The person who's wall the post has been made on
 	public $userId;
 	public $text;
 	
 	public static function getComments($id)
 	{
		  	// Create connection
			$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
			// Check connection
			if ($conn->connect_error) 
			{
				die("Connection failed: " . $conn->connect_error);
			}
			$conn = new mysqli(Database::$servername, Database::$username,Database::$password,Database::$db);
		  	$sql = "SELECT comment_id,post_id,commentor_id,user_id,text FROM comment WHERE post_id=$id";
			$result = $conn->query($sql);

			if ($result->num_rows > 0) {
				$comments=array();
				while($row = $result->fetch_assoc()) 
				{
					array_push($comments,$row);
				}
			} 
			else 
			{
				$comments=null;
				//echo "No Comments Found";
			}
			$conn->close();
			return $comments;
	}
	
	public static function deletePost($id)
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
		$sql = "DELETE FROM Post WHERE post_id=$id";

		if ($conn->query($sql) === TRUE) {}
		else 
		{
			echo "Error deleting record: " . $conn->error;
		}
		$conn->close();
		return null;
	}
	
	public static function addPost($id,$text)
	{
		// Create connection
		$conn = mysqli_connect(Database::$servername, Database::$username,Database::$password,Database::$db);
		// Check connection
		if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
  		}
		// sql to delete a record
		$sql = "INSERT INTO Post (poster_id,user_id,Text) VALUES ($id,$id,'$text');";
		if (mysqli_query($conn, $sql)) {}
		else 
		{
			echo "Error deleting record: " . $conn->error;
		}
		$post_id=mysqli_insert_id($conn);
		mysqli_close($conn);
		return $post_id;
	}
	
	public static function addPostToFriend($poster_id,$text,$wall_id)
	{
		// Create connection
		$conn = mysqli_connect(Database::$servername, Database::$username,Database::$password,Database::$db);
		// Check connection
		if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
  		}
		// sql to delete a record
		$sql = "INSERT INTO Post (poster_id,user_id,Text) VALUES ($poster_id,$wall_id,'$text');";
		if (mysqli_query($conn, $sql)) {}
		else 
		{
			echo "Error deleting record: " . $conn->error;
		}
		$post_id=mysqli_insert_id($conn);
		//Adding the notification
		$sql = "INSERT INTO Post_Notifications (posted_to_id,posted_by_id) VALUES ($wall_id,$poster_id);";
		if (mysqli_query($conn, $sql)) {}
		else 
		{
			echo "Error deleting record: " . $conn->error;
		}
		
		mysqli_close($conn);
		return $post_id;
	}
}
 

Class Comment
{
	public $commentId;
	//The person who made the comment.
 	public $commenterId;
 	//The person who's wall the post has been made on
 	public $userId;
 	//The post to which this comment corresponds to.
 	public $postId;
 	public $text;
 	
 	public static function addComment($postId,$commentorId,$userId,$commentText)
	{
		// Create connection
		$conn = mysqli_connect(Database::$servername, Database::$username,Database::$password,Database::$db);
		// Check connection
		if (mysqli_connect_errno())
  		{
  			echo "Failed to connect to MySQL: " . mysqli_connect_error();
  		}
		// sql to delete a record
		$sql = "INSERT INTO comment (post_id,commentor_id,user_id,text) VALUES ($postId,$commentorId,$userId,'$commentText');";
		if (mysqli_query($conn, $sql)) {}
		else 
		{
			echo "Error deleting record: " . $conn->error;
		}
		mysqli_close($conn);

	}
}

?>
