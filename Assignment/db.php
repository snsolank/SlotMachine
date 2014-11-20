<?php

error_reporting(E_ALL ^ E_DEPRECATED);
error_reporting(E_NOTICE ^ E_DEPRECATED);

/*array_key_exists() function checks an array for a specified key.*/
$hashedv = "";
$spins = "";
$pid = ""; 
$svalue="";
$name = "";
$credits = "";

if(array_key_exists('coinswon', $_POST)) {
	$coinswon = $_POST['coinswon'];
	
}
if(array_key_exists('coinsbet', $_POST)) {
	$coinsbet = $_POST['coinsbet'];
	
}
if(array_key_exists('PlayerID', $_POST)) {
	$playerid = $_POST['PlayerID'];
	
}
if(array_key_exists('hashedvalue', $_POST)) {
	$hashedvalue = $_POST['hashedvalue'];
	
	$hashedvalue = "$2a$12$".$hashedvalue;
	
}
/* variable $values is handling the playerid and hashedvalue data submit through client request. */
$values = crypt($playerid,$hashedvalue);


	$conn = new mysqli("localhost","root","sam","Spin");   // connecting to database
	if ($conn -> connect_error) 
	{
		die("Connection failed: " .$conn -> connect_error);
	}
	
	$sqlquery = "Select * from Players where PlayerID = '".$playerid."'";
	
	$resultset = $conn->query($sqlquery);
	
	if($resultset->num_rows > 0)
	{
		while($row = $resultset->fetch_assoc())
		{
			$spins = $row["LifetimeSpins"];
			$credits = $row["Credits"];	
			$svalue = $row["SaltValue"];
			$name = $row["Name"];
			$pid = $row["PlayerID"];	
		}
		$svalue = "$2a$12$".$svalue;
		$credits = $credits - $coinsbet;
		$credits = $credits + $coinswon;
		
		$spins = $spins + 1;
	}
	
	/* variable used to access the hashed value in the database which takes in pid and svalue from database. */
	$hashedv = crypt($pid,$svalue);
	
	$lifeavg = 0;
	
	$lifeavg = $credits/$spins;

	$sqlquery = "Update Players SET Credits = ".$credits.", LifetimeSpins = ".$spins.", LifetimeAvgReturn = ".$lifeavg." where PlayerID = '".$playerid."'";
	if($hashedv == $values)
	{ 
		if($conn->query($sqlquery) === TRUE)
		{
		   
			$jsonfeeds = "{'Player ID':".$playerid.",'Player Name':".$name.",'Credits':".$credits.",'Lifetime Spins':".$spins.",'Lifetime Average Return':".$lifeavg."}";
			header('Content-Type: application/json');
			echo json_encode($jsonfeeds);
		}
		$conn->close();
	}
	else
	{
		echo "Data not Valid";
		$conn->close();
	}

?>
