<?php

//NOT IMPLEMENTED YET
public Class PollQuestion
{
	//primary key for identification
	public $PollQuestionId;
	//The person who asked the question
 	public $userAskedId;
 	public $pollQuestionText;
 	//options (text)
 	public $option1;
 	public $option2;
 	public $option3;
 	public $option4;
 	
 	//count of votes
 	public $count1;
 	public $count2;
 	public $count3;
 	public $count4;
}
 

public Class PollAnswer
{
	//primary key for identification
	public $pollAnswerId;
	//The optionSelected by the person
 	public $optionSelected;
 	//The person whose answer this is
 	public $userAnsweredId;
}

?>
