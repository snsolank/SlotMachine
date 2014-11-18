
<html>
<head>
<title></title>
</head>
<body>
<form name = "slotform" method = "POST" action = "db.php">
<?php

$player = "Samarth";
$coinswon = "";
$coinsbet = "";
$password = "";
$password = "thisisatest12345678123";

?>
<Label>Coins Won</label><input type = "text" name="coinswon"><br>
<Label>Coins Bet</label><input type = "text" name="coinsbet"><br>
<Label>Player ID</label><input type = "text" name="PlayerID"><br>
<Label>Your Salt Value</label><input type = "text" name="hashedvalue" value = "<?php echo $password;?>"><br>
<input type = "submit" value = "submit"> 
</body>
</html>
