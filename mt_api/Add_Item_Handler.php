<?php
/*
    Copyright 2016 - 2018 Musto Technologies LLC http://www.mustotechnologies.com
	
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
*/
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
    $QTY = $_POST["QTY"];
	$WHSLER = $_POST["WHSLER"];
    $TAXABLE = $_POST["TAXABLE"];
    $DEPT = $_POST["DEPT"];
	$LOCATION = $_POST["LOCATION"];
	$CLERK = $_POST["CLERK"];

    // $connect to our DB
	$connect = mysqli_connect($db_host_name, $db_user_name, $db_password, $database);

	if (mysqli_connect_errno()) {
		die('<p>Failed to connect to MySQL, send this message to support: '.mysqli_connect_error().'</p>');
	} 
	
	// Check to see no entry for that UPC at that location already exists for this addition
	$sql = "SELECT * FROM `product` WHERE `UPC`=$UPC AND `LOCATION`=$LOCATION";
	if (!$result = $connect->query($sql)) {
    // Oh no! The query failed. 
    echo "Sorry, the website is experiencing problems.";

    // Again, do not do this on a public site, but we'll show you how
    // to get the error information
    echo "Error: Our query failed to execute and here is why: \n";
    echo "Query: " . $sql . "\n";
    echo "Errno: " . $connect->errno . "\n";
    echo "Error: " . $connect->error . "\n";
    exit;
	}

	if (mysqli_num_rows($result)!=0) { 
	$result->free();
	$connect->close();
	die("UPC " . $UPC . " for location " . $LOCATION . " already exists. 
	It may be named, " . $NAME . ". Please restock instead of adding new item.");
	} else {
		$sql = "INSERT INTO `product` (
                $LOCAL_PRODUCT_TABLE
            )
            VALUES (
                $UPC,
                '$NAME',
                '$DESC',
				$PRICE,
                $LOCATION,
                $QTY,
				'Y',
                $DEPT,
                '$TAXABLE'
            )";
		if (!$result = $connect->query($sql)) {
			echo "Sorry, the website is experiencing problems.";
			echo "Error: Our query failed to execute and here is why: \n";
			echo "Query: " . $sql . "\n";
			echo "Errno: " . $connect->errno . "\n";
			echo "Error: " . $connect->error . "\n";
			exit;
		}
	
		$sql = "INSERT INTO `txn` (
                $LOCAL_TXN_TABLE
            )
            VALUES (
                $UPC,
				'ADDSTK',
                $COST,
                $QTY,
				'$TIME',
                '$CLERK',
                $LOCATION,
				'$WHSLER',
                $PRICE,
                '$TAXABLE',
				$DEPT)";
		if (!$result = $connect->query($sql)) {
			echo "Sorry, the website is experiencing problems.";
			echo "Error: Our query failed to execute and here is why: \n";
			echo "Query: " . $sql . "\n";
			echo "Errno: " . $connect->errno . "\n";
			echo "Error: " . $connect->error . "\n";
			exit;
		}
	}

	// Put useful stuff on the page
	echo "<br><br><a href='../{$CONSTANT('ADD_ITEM_URL')}'>Click here to add another item.</a><br>";
	echo "</body>";
	
	// The script will automatically free the result and close the MySQL
	// $connection when it exits, but let's just do it anyways
	$connect->close();

?>
