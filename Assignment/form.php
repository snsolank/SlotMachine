
<html>
<head>
<title></title>
</head>
<body>

<?php

$player = "Samarth";
$coinswon = "";
$coinsbet = "";
$password = "";
$password = "thisisatest12345678123";

$credits = "";
$credit = 0;
$playerid= "";
$conn = new mysqli("localhost","root","sam","Spin");
if ($conn -> connect_error) 
{
	die("Connection failed: " .$conn -> connect_error);
}
if(array_key_exists('PlayerID', $_POST)) {
	$playerid = $_POST['PlayerID'];
	
}
if(array_key_exists('credits', $_POST)) {
	$credit = $_POST['credits'];
	
}

if($playerid != null && $playerid != "")
{
	if($credit == 0 || $credit == null)
	{
		   // connecting to database
		
		
		$sqlquery = "Select * from Players where PlayerID = '".$playerid."'";
		
		$resultset = $conn->query($sqlquery);
		if($resultset->num_rows > 0)
		{
			while($row = $resultset->fetch_assoc())
			{
				$credits = $row["Credits"];		
			}
		}
	}
	if($credits == 0 && $credit == 0)
	{
?>
<h4>Your Total Credits are 0. Please Add Some Credits</h4>
<form name = "creditsinsert" method = "POST" action = "form.php">
<Label>Credits</label><input type = "text" name="credits"><br>
<input type = "hidden" name="PlayerID" value="<?php echo $playerid; ?>">
<input type = "submit" value = "Add Credits"> 
</form>
<?php
	}
	else
	{
		if($credit > 0)
		{
?>
			<h4>Your Total Credits: <?php echo $credit; ?></h4>
<?php
		}
		elseif($credits > 0)
		{
?>
			<h4>Your Total Credits: <?php echo $credits; ?></h4>
<?php
		}
?>
<form name = "slotform" method = "POST" action = "db.php">
<Label>Coins Won</label><input type = "text" name="coinswon"><br>
<Label>Coins Bet</label><input type = "text" name="coinsbet"><br>
<input type = "hidden" name="PlayerID" value="<?php echo $playerid; ?>">
<Label>Your Salt Value</label><input type = "text" name="hashedvalue" value = "<?php echo $password;?>"><br>
<input type = "submit" value = "submit"> 
</form>
<?php
	}
	if($credit != null && $credit > 0)
	{ 
		$sqlquerys = "UPDATE Players SET Credits=".$credit." where PlayerID='".$playerid."'";
		//echo $sqlquerys;
		if($conn->query($sqlquerys) === TRUE)
		{
?>



<?php
		}
	}
}
else
{
?>
<form name = "creditsform" method = "POST" action = "form.php">
<Label>Player ID</label><input type = "text" name="PlayerID"><br>
<input type = "submit" value = "View Your Total Credits"> 
</form>
<?php
}
?>

</body>
</html>
