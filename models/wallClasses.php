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
	    echo "NO POST FOUND";
	}
	$conn->close();
	return $comments;
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
}

?>
