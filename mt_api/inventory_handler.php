<!-- 
    Copyright 2016, 2017 Musto Technologies LLC http://www.mustotechnologies.com
	
	-- GPLv3 License --
	This file is part of MT Kestrel.

    MT Kestrel is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    any later version.

    MT Kestrel is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with MT Kestrel as the COPYING.txt file.  If not, 
	see <http://www.gnu.org/licenses/>.
-->
<?php
	//Important includes
	include("$_SERVER[DOCUMENT_ROOT]/MT-Kestrel/mt_api/config.php");
	date_default_timezone_set('UTC');
	
	//Format output as an html5 webpage
	echo "<!DOCTYPE html>";
	echo "<html>";
	echo "<head>";
	echo "<meta charset=\"UTF-8\">";
    echo "<title>QTY OK</title>";
	echo "</head>";
	echo "<body>";
	
	//Local variables
	$UTC_TIME = date('Y-m-d G:i:s');
	$TIME = date('Y-m-d G:i:s', strtotime(UTC_OFFSET));
	$LOCAL_TXN_TABLE = TXN_TABLE;
	$CONSTANT = 'constant';
	
	// Grab our POSTed form values
    // Note that whatever is enclosed by $_POST[""] matches the form input elements
    $UPC = $_POST["UPC"];
    $NAME = $_POST["NAME"];
    $DESC = $_POST["DESC"];
    $PRICE = $_POST["PRICE"];
    $INV_QTY = $_POST["INV_QTY"];
	$OLD_QTY = $_POST["OLD_QTY"];
	$LOCATION = $_POST["LOCATION"];
	$CLERK = $_POST["CLERK"];
	$NOTE = $_POST["NOTE"];

    // Connect to our DB
	$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check connection
	if ($mysqli->connect_errno) {
		echo "Error: Failed to make a MySQL connection, here is why: \n";
		echo "Errno: " . $mysqli->connect_errno . "\n";
		echo "Error: " . $mysqli->connect_error . "\n";
		
		// You might want to show them something nice, but we will simply exit
		exit;
	}
	
	//Code to run if inventory is OK and approved.
	if(isset($_POST["approve"])){
		// Run query to duplicate last txn entry as that has most up to date values
		$sql = "INSERT INTO `txn` ( $LOCAL_TXN_TABLE ) SELECT * FROM `txn` WHERE `UPC`=$UPC AND `LOCATION`=$LOCATION ORDER BY `TXN_TIME` DESC LIMIT 1";
		if (!$result = $mysqli->query($sql)) {
		// Oh no! The query failed. 
		echo "Sorry, the website is experiencing problems.";

		// Again, do not do this on a public site, but we'll show you how
		// to get the error information
		echo "Error: Our query failed to execute and here is why: \n";
		echo "Query: " . $sql . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
		}else{echo "Ran OK.";}
	
		// Run query to update QTY, transaction type and user making inventory report
		$sql = "UPDATE `txn` SET `TYPE`='INV', `QTY`=$OLD_QTY, `TXN_TIME`='$TIME', `CLERK`='$CLERK', `WHSLER`='INV', `PRICE`='$PRICE', `COST`='0.00' WHERE `UPC`=$UPC AND `LOCATION`=$LOCATION ORDER BY `TXN_TIME` DESC LIMIT 1";
		if (!$result = $mysqli->query($sql)) {
		// Oh no! The query failed. 
		echo "Sorry, the website is experiencing problems.";

		// Again, do not do this on a public site, but we'll show you how
		// to get the error information
		echo "Error: Our query failed to execute and here is why: \n";
		echo "Query: " . $sql . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
		}
	
		// Run query to update QTY, NAME, DESC, and PRICE in product table
		$sql = "UPDATE `product` SET `QTY`=$OLD_QTY, `NAME`='$NAME', `DESC`='$DESC', `PRICE`='$PRICE' WHERE `UPC`=$UPC AND `LOCATION`=$LOCATION";
		if (!$result = $mysqli->query($sql)) {
		// Oh no! The query failed. 
		echo "Sorry, the website is experiencing problems.";

		// Again, do not do this on a public site, but we'll show you how
		// to get the error information
		echo "Error: Our query failed to execute and here is why: \n";
		echo "Query: " . $sql . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
		}

		// Put useful stuff on the page
		echo "<br><br><a href='../{$CONSTANT('INVENTORY_URL')}'>Click here to inventory another item.</a><br>";
		echo "</body>";
	
		// The script will automatically free the result and close the MySQL
		// connection when it exits, but let's just do it anyways
		$mysqli->close();
	}
	
	//Code to run if inventory is OK and approved.
	if(isset($_POST["change"])){
		
		//check INV_QTY is set
		if(!ctype_digit($INV_QTY)){
			echo "You did not enter a new inventory quantity.";
			exit;
		}
		// Run query to duplicate last txn entry as that has most up to date values
		$sql = "INSERT INTO `txn` ( $LOCAL_TXN_TABLE ) SELECT * FROM `txn` WHERE `UPC`=$UPC AND `LOCATION`=$LOCATION ORDER BY `TXN_TIME` DESC LIMIT 1";
		if (!$result = $mysqli->query($sql)) {
		// Oh no! The query failed. 
		echo "Sorry, the website is experiencing problems.";

		// Again, do not do this on a public site, but we'll show you how
		// to get the error information
		echo "Error: Our query failed to execute and here is why: \n";
		echo "Query: " . $sql . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
		}else{echo "Ran OK.";}
	
		// Run query to update QTY, transaction type and user making inventory report
		$sql = "UPDATE `txn` SET `TYPE`='INV', `QTY`=$INV_QTY, `TXN_TIME`='$TIME', `CLERK`='$CLERK', `WHSLER`='INV', `PRICE`='$PRICE', `COST`='0.00' WHERE `UPC`=$UPC AND `LOCATION`=$LOCATION ORDER BY `TXN_TIME` DESC LIMIT 1";
		if (!$result = $mysqli->query($sql)) {
		// Oh no! The query failed. 
		echo "Sorry, the website is experiencing problems.";

		// Again, do not do this on a public site, but we'll show you how
		// to get the error information
		echo "Error: Our query failed to execute and here is why: \n";
		echo "Query: " . $sql . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
		}
	
		// Run query to update QTY, NAME, DESC, and PRICE in product table
		$sql = "UPDATE `product` SET `QTY`=$INV_QTY, `NAME`='$NAME', `DESC`='$DESC', `PRICE`='$PRICE' WHERE `UPC`=$UPC AND `LOCATION`=$LOCATION";
		if (!$result = $mysqli->query($sql)) {
		// Oh no! The query failed. 
		echo "Sorry, the website is experiencing problems.";

		// Again, do not do this on a public site, but we'll show you how
		// to get the error information
		echo "Error: Our query failed to execute and here is why: \n";
		echo "Query: " . $sql . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
		}
		
		// Calculate and run query to INSERT LOSS table record
		$QTY_DELTA = $OLD_QTY - $INV_QTY;
		$RETAIL_LOSS = round($QTY_DELTA * $PRICE, 2);
		$sql = "INSERT INTO `loss`(`UPC`, `TXN_TIME`, `QTY_DELTA`, `CLERK`, `LOCATION`, `RETAIL_LOSS`, `NOTE`) VALUES ($UPC, '$TIME', $QTY_DELTA, '$CLERK', $LOCATION, $RETAIL_LOSS, '$NOTE')";
		if (!$result = $mysqli->query($sql)) {
		// Oh no! The query failed. 
		echo "Sorry, the website is experiencing problems.";

		// Again, do not do this on a public site, but we'll show you how
		// to get the error information
		echo "Error: Our query failed to execute and here is why: \n";
		echo "Query: " . $sql . "\n";
		echo "Errno: " . $mysqli->errno . "\n";
		echo "Error: " . $mysqli->error . "\n";
		exit;
		}
		

		// Put useful stuff on the page
		echo "<br><br><a href='../{$CONSTANT('INVENTORY_URL')}'>Click here to inventory another item.</a><br>";
		echo "</body>";
	
		// The script will automatically free the result and close the MySQL
		// connection when it exits, but let's just do it anyways
		$mysqli->close();
	}

?>
