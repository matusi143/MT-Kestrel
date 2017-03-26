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
	include("$_SERVER[DOCUMENT_ROOT]/MT_Kestrel/mt_api/config.php");
		
	//Local variables
	$LOCAL_PRODUCT_TABLE = PRODUCT_TABLE;
	$LOCAL_TXN_TABLE = TXN_TABLE;
		
	// Grab our POSTed form values
    // Note that whatever is enclosed by $_POST[""] matches the form input elements
    $UPC = $_POST["UPC"];
	$LOCATION = $_POST["LOCATION"];

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
	
	// Check to see no entry for that UPC at that location already exists for this addition
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

	if (mysqli_num_rows($result)>=2) { 
		$result->free();
		$mysqli->close();
		die("UPC " . $UPC . " for location " . $LOCATION . " contains more than one entry, please contact support.");
	} else if (mysqli_num_rows($result)==0)  {
		$result->free();
		$mysqli->close();
		die("UPC " . $UPC . " for location " . $LOCATION . " contains zero (0) records, please add item instead.");
	} else{
		$upc_record = $result->fetch_array(MYSQLI_ASSOC);
		print_r($upc_record);
	}
		
	// The script will automatically free the result and close the MySQL
	// connection when it exits, but let's just do it anyways
	$mysqli->close();
?>
