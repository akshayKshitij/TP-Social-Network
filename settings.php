<?php
 
class Database
{
	public static $username = "";
	public static $password = "";
	public static $servername = "localhost";

	public static connect()
	{
		// Create connection
		$conn = new mysqli($servername, $username, $password);

		// Check connection
		if ($conn->connect_error) 
		{
			die("Connection failed: " . $conn->connect_error);
		}
		else
		{
			return $conn;
		}
	} 
}


?>
