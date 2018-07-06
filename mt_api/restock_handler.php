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
    echo "<title>Add Item Results</title>";
	echo "</head>";
	echo "<body>";
	
	//Local variables
	$UTC_TIME = date('Y-m-d G:i:s');
	$TIME = date('Y-m-d G:i:s', strtotime(UTC_OFFSET));
	$LOCAL_PRODUCT_TABLE = PRODUCT_TABLE;
	$LOCAL_TXN_TABLE = TXN_TABLE;
	$CONSTANT = 'constant';
	
	// Grab our POSTed form values
    // Note that whatever is enclosed by $_POST[""] matches the form input elements
    $UPC = $_POST["UPC"];
    $NAME = $_POST["NAME"];
    $DESC = $_POST["DESC"];
	$COST = $_POST["COST"];
    $PRICE = $_POST["PRICE"];
    $ADD_QTY = $_POST["ADD_QTY"];
	$OLD_QTY = $_POST["OLD_QTY"];
	$WHSLER = $_POST["WHSLER"];
    $TAXABLE = $_POST["TAXABLE"];
    $DEPT = $_POST["DEPT"];
	$LOCATION = $_POST["LOCATION"];
	$CLERK = $_POST["CLERK"];
	$QTY = $OLD_QTY + $ADD_QTY;

    // $connect to our DB
	$connect = mysqli_connect($db_host_name, $db_user_name, $db_password, $database);

	if (mysqli_connect_errno()) {
		die('<p>Failed to connect to MySQL, send this message to support: '.mysqli_connect_error().'</p>');
	} 
	
	// Run query to get the field that is going to be updated.
	$sql = "SELECT * FROM `product` WHERE `UPC`=$UPC AND `LOCATION`=$LOCATION";
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

	if (mysqli_num_rows($result)!=1) { 
	$result->free();
	$mysqli->close();
	die("UPC " . $UPC . " for location " . $LOCATION . " returned " . mysqli_num_rows($result) . " records and should only have one.  Contact support.");
	} 
	else {
		$sql = "UPDATE `product` SET `UPC`=$UPC,`NAME`='$NAME',`DESC`='$DESC',`PRICE`=$PRICE,`LOCATION`=$LOCATION,`QTY`=$QTY,`ACTIVE`='Y',`DEPT`=$DEPT,`TAXABLE`='$TAXABLE' WHERE `UPC`=$UPC AND `LOCATION`=$LOCATION";
		if (!$result = $mysqli->query($sql)) {
			echo "Sorry, the website is experiencing problems.";
			echo "Error: Our query failed to execute and here is why: \n";
			echo "Query: " . $sql . "\n";
			echo "Errno: " . $mysqli->errno . "\n";
			echo "Error: " . $mysqli->error . "\n";
			exit;
		}
	
		$sql = "INSERT INTO `txn` (
                $LOCAL_TXN_TABLE
            )
            VALUES (
                $UPC,
				'ADDSTK',
                $COST,
                $ADD_QTY,
				'$TIME',
                '$CLERK',
                $LOCATION,
				'$WHSLER',
                $PRICE,
                '$TAXABLE',
				$DEPT)";
		if (!$result = $mysqli->query($sql)) {
			echo "Sorry, the website is experiencing problems.";
			echo "Error: Our query failed to execute and here is why: \n";
			echo "Query: " . $sql . "\n";
			echo "Errno: " . $mysqli->errno . "\n";
			echo "Error: " . $mysqli->error . "\n";
			exit;
		}
	}

	// Put useful stuff on the page
	echo "<br><br><a href='../{$CONSTANT('RESTOCK_URL')}'>Click here to add another item.</a><br>";
	echo "</body>";
	
	// The script will automatically free the result and close the MySQL
	// $connection when it exits, but let's just do it anyways
	$mysqli->close();

?>
