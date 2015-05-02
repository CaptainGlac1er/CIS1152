<?php
$header = <<<EOT
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>guestbook</title>
	</head>
	<body>
EOT;
$guest_form = <<<EOT
<h1>Guest Books</h1><br>
<form name = "guestbook" method="post" action=""><br>
<label>Name: </label><br>
<input name="name" type="text"><br>
<label>Email: </label><br>
<input name ="email" type="text"><br>
<label>Comment: </label><br>
<textarea name ="comment" type="text"></textarea><br>
<input type="submit" name="submit" value="Submit"><br>
</form><br>
EOT;

$footer = <<<EOT
	</body>
</html>
EOT;


echo $header;
echo $guest_form;
echo $footer;
include("../../DatabaseStuff/lab9user.php");
$conn = new mysqli ($DBserver, $DBuser, $DBpass, $DBname);
unset($DBserver, $DBuser, $DBpass, $DBname);
if($conn->connect_error){
	die('Error ' . $conn->connect_errno);
}
$results = $conn->query("SELECT name, email,comment, comment_timestamp from guestbook;");
if(isset($_POST['submit'])){
	$name = "'" . $conn->real_escape_string($_POST['name']) . "'";
	$email = "'" . $conn->real_escape_string($_POST['email']) . "'";
	$comment = "'" . $conn->real_escape_string($_POST['comment']) . "'";	
	$sql = $conn->query("INSERT INTO guestbook(name, email, comment) VALUES($name, $email, $comment);");
	if($sql === false){
		die("error : " . $conn->connect_errno);
	}
}
else{
	while($row = $results->fetch_assoc()){
		echo $row['name'] . "&nbsp;" . $row['email'] . "&nbsp" . $row['comment'] . "&nbsp" . $row['comment_timestamp'] . "<br>" ;
	}
}
?>