<?php
#includes database stuff
include("../../../DatabaseStuff/advfinal.php");
#prints out the store items
if(!(isset($_POST['item'])) && !isset($_POST['Buy'])){
	$query = "select itemtitle, itemdesc, itemimage, itemid from items;";
	$sql = $conn->query($query);
	while($row = $sql->fetch_assoc()){
		$image = $row['itemimage'];
		$title = $row['itemtitle'];
		$desc  = $row['itemdesc'];
		$item  = $row['itemid'];
		# prints out the entries in the database.
		$entry = <<< EOT
		<div class="entries">
			<div style="width: 100px; float: left; padding: 10px;">
				<img alt="image" src="$image" height="100"/>
			</div>
			<div>
				<h2>$title</h2>
				<br>
				$desc
			</div>
			<form action="#" method="post">
				<input type="hidden" name="item" value="$item">
				<input type="submit" value="Buy">
			</form>
		
		</div>
		
EOT;
		echo $entry;
	}
}#prints out the selected one
elseif(isset($_POST['item']) && !isset($_POST['Buy'])){
	$query = "select itemtitle, itemdesc, itemimage, itemid from items where itemid='". $_POST['item'] . "';";
	$sql = $conn->query($query);
	while($row = $sql->fetch_assoc()){
		$image = $row['itemimage'];
		$title = $row['itemtitle'];
		$desc  = $row['itemdesc'];
		$item  = $row['itemid'];
		$entry = <<< EOT
		<div class="entries">
			<div style="width: 100px; float: left; padding: 10px;">
				<img alt="image" src="$image" height="100"/>
			</div>
			<div>
				<h2>$title</h2>
				<br>
				$desc
			</div>
			<form action="" method="post">
				<input type="text" name="email">
				<input type="hidden" name="item" value="$item">
				<input type="submit" name="Buy" value="Buy">
			</form>
		
		</div>
		
EOT;
		echo $entry;
	}
}#Enter in your info to be able to buy
elseif(isset($_POST['Buy'])){
	$email = $conn->real_escape_string($_POST['email']);
	if(isset($email)){
		# Here is the insert into the database which has a relationship between users and bought
		$querycount = "select 'TRUE' from users where custemail = '" . $email . "';";
		$result = $conn->query($querycount);
		if (mysqli_num_rows($result)==0) {
			$add = "insert into users(custemail) values ('" . $email . "');";
			$sql = $conn->query($add);
			if($sql === false){
				die("error 1 : " . $conn->connect_errno);
			}
		}
		$query = "insert into bought(custid, itemid) values ((select custid from users where custemail = '" . $email . "'),'" . $_POST['item'] ."');";
		$sql = $conn->query($query);
		if($sql === false){
			die("error did not post. Error code 111");
		}
		$queryresult = "select itemtitle, itemimage from items where itemid = '" . $_POST['item'] . "';";
		$sql2 = $conn->query($queryresult);
		while($bought = $sql2->fetch_assoc()){
			$image = $bought['itemimage'];
			$title = $bought['itemtitle'];
			$entry = <<< EOT
			<div class="entries">
				<div style="width: 100px; float: left; padding: 10px;">
					<img alt="image" src="$image" height="100"/>
				</div>
				<div style="min-height: 120px;">
					Thank you for buying $title 
				</div>
			
			</div>
			
EOT;
			echo $entry;
		}
		/*header("location: store.php");*/
	}
}
?>