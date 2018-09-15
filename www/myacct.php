<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>QR Code</title>

<style>
	
	#container {
		width: 80%;
		margin-left: auto;
		margin-right: auto;
		font-size: 2em;
		padding-left:10%;
	}
	p {
		font-size:1.2em;
	}
	td {
		margin: 10px;
		padding: 20px;
		background-color:#69D1E1;
	}

</style>
</head>

<body>

<div id="container">

<?php

	$host = 'localhost';
	$user = 'id5796749_test';
	$password = 'test123';
	$db = 'id5796749_pgform';

	$link = mysqli_connect($host, $user, $password, $db);
	
	/* check connection */
	if (mysqli_connect_errno()) {
		echo "Failed to connect to MySQL " . mysqli_connect_error();
	} else {
		
		$value = $_POST['qrvalue'];
		$filename = $value.".png";
		$username = $_POST['username'];
		$date = date("m-d-Y");
		
		
		$query = "SELECT username,stamps from passbook where username='$username'";
		
		if ($result = mysqli_query($link, $query)) {
			if (mysqli_num_rows($result) == 0) {
				echo "<h3>Sorry, wrong username.</h3>";
				echo "<a href=\"test1.html\">Try Again</a>\n";
			} else {
				$row=mysqli_fetch_array($result, MYSQLI_ASSOC);
				$username = $row['username'];
				$stamps = $row['stamps'];
				$stamps = $stamps+1;
				
				$host = 'localhost';
				$user = 'id5796749_test';
				$password = 'test123';
				$db = 'id5796749_pgform';
				
				$link = mysqli_connect($host, $user, $password, $db);
				
				$query = "UPDATE passbook SET stamps=$stamps where username='$username'";
				if ($result = mysqli_query($link, $query)) {
					//echo "<p>Stamps updated</p>\n";
					echo "<h2>Welcome " . $username . "!</h2>";
					echo "<p>As of " . $date ." you have collected " . $stamps . " stamps.
					</p>"; /*File Name: " . $filename . "*/
				} else {
					echo "<h3>Update Failed</h3>";	
				}
				
				
				
				$numpics = $stamps;
				
				function createTD($trow) {
					//$nrow = $trow;
					$count =1;
					$tcol = 4;
					$num = 1;
					global $numpics;
					$picsadded = 0;
					$picsleft = $numpics;
					$pic = 1;
					
					while ($num<=$trow) {
					//for ($num=1; $num<=$trow; $num++) {
						//echo $num;
						echo "<tr>\n";
						if ($picsleft >= $tcol) {
							for ($count=1; $count <= $tcol; $count++) {
								echo "<td><img src=\"images/stamp.png\"><br>Stamp #" . $pic . "</td>\n";
								$pic=$pic+1;
							}
						} else {
							for ($count=1; $count <= $picsleft; $count++) {
								echo "<td><img src=\"images/stamp.png\"><br>Stamp #" . $pic . "</td>\n";
								$pic=$pic+1;
							}
						}
						echo "</tr>\n";
						$picsadded = $picsadded+$tcol;
						$picsleft = $numpics-$picsadded;
						$num++;
					}
				}

				echo "<table id=\"stamps\">\n";
				
				if ($numpics <= 4) {
					
					createTD(1);
				} else if ($numpics <= 8) {
					
					createTD(2);
				} else if ($numpics <= 12) {
					
					createTD(3);
				} else if ($numpics <= 16) {
					
					createTD(4);
				} else if ($numpics <= 20) {
					
					createTD(5);
				} else if ($numpics <= 24) {
					
					createTD(6);
				} else if ($numpics <= 28) {
					
					createTD(7);
				} else if ($numpics <= 32) {
					
					createTD(8);
				} 
				
				echo "</table>\n";
				
				

			}
		}

	}


?>
</div>
</body>
</html>