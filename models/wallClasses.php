<?php

public Class Post
{
	public $postId;
	//The person who made the post.
 	public $posterId;
 	//The person who's wall the post has been made on
 	public $userId;
 	public $text;
}
 

public Class Comment
{
	public $commentId;
	//The person who made the comment.
 	public $commenterId;
 	//The person who's wall the post has been made on
 	public $userId;
 	//The post to which this comment corresponds to.
 	public $postId
 	public $text;
}

?>
