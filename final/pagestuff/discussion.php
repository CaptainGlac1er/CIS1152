<?php
echo "<div id=\"content\">";
$rowquery = "select commentText as ctext from comments;";
#imports the database info to connect
include("../../../DatabaseStuff/advfinal.php");
$results = $conn->query($rowquery);
#I found this cool how this works but prints out the comments that people have made
while($row = $results->fetch_assoc()){
	echo "<div class=\"entries\">" . $row['ctext'] . "</div>";
}
#Allows people to comment
$submission= <<< EOT
<div id="addentry" style="margin-bottom: 20px; margin-top: 20px;">
	<form name = "blogpost" method="post" action="#">
	<div style="height: 150px;">
		<div style="float: left; width: 100%;">
			Add discussion post:
		</div>	
		<div style="float: left; width: 100%;">
			<textarea name="entry" rows="9" style="width: 100%;"></textarea>
		</div>	
		<div style="float: right; width: 50%; text-align: right; margin-top: 10px;">
			Enter Email:   
			<input type="text" name="email">
			<input type="submit" name="submit" value="Post" style="">
		</div>	
	</div>	
	<br>
	</form>
</div>
</div>

EOT;

echo $submission;
#code to insert data into the database
if(isset($_POST['submit'])){
	$post = $conn->real_escape_string($_POST['entry']);
	$email = $conn->real_escape_string($_POST['email']);
	if($post != null && $email != null){
		$query = "insert into comments(commentText, email) values ('". $post . "','" . $email ."');";
		$sql = $conn->query($query);
		if($sql === false){
			die("error did not post. Error code 111");
		}
		header("location: discussion.php");
	}
}

?>