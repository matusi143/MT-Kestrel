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
	$sql = "SELECT * FROM `departments`;";
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
	
	$array_string = "0, 0";
	
	if (mysqli_num_rows($result)==0)  {
		$result->free();
		$mysqli->close();
		die("Zero (0) records returned.");
	} else{
		while( $row = mysqli_fetch_array($result)){
		//print_r ($row); //debug
		if (isset($row['dept_name'])){
			$array_string = $array_string . ", '" . $row['dept_name'] . "', 0";
		}
		else{
			//echo "Not set. <br>";
		}
		}
	}

	//$total = array($array_string); //to do, need to insert this string into the array...
	$total = array(0, 0, 'AMMO', 0, 'ACCESSORIES', 0, 'FOOD', 0, 'TRANSFERS', 0, 'LABOR', 0, 'CLOTHING', 0, 'FIREARMS', 0);
	
	// Check to see no entry for that UPC at that location already exists for this addition
	$sql = "SELECT `product`.`UPC`, GROUP_CONCAT(`product`.`QTY`, '¦', `product`.`DEPT`, '¦', `product`.`PRICE`, '¦', `txn`.`QTY`, '¦', `txn`.`COST` ORDER BY `txn`.`TXN_TIME` DESC SEPARATOR '~') AS qty_history FROM `product` LEFT JOIN `txn` ON `product`.`UPC`=`txn`.`UPC` and `txn`.`TYPE`='ADDSTK' GROUP BY `product`.`UPC`;";
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
	
	if (mysqli_num_rows($result)==0)  {
		$result->free();
		$mysqli->close();
		die("Zero (0) records returned.");
	} 
	else{
		while( $row = mysqli_fetch_array($result)){
			//QTY_in_stock¦DEPT¦PRICE¦QTY¦COST~QTY_in_stock¦DEPT¦PRICE¦QTY¦COST
			//print_r ($row); //debug
			if (isset($row['qty_history'])){
				$record_sum = 0;
				$row_entries = explode("~", $row['qty_history']);
				//print_r ($row_entries); //debug
				foreach($row_entries as $item){
					$data = explode("¦", $item);
					if (($record_sum + $data[3]) <= $data[0]){
						$total[$data[1]*2+1] = $total[$data[1]*2+1] + $data[3] * $data[4];
						$record_sum = $record_sum + $data[3];
						//echo $total[$data[1]] . " subtotal for department: " . $data[1] . " current record sum: " . $record_sum . "<br>"; //debug
					}
					else if (($record_sum + $data[3]) > $data[0] && $record_sum < $data[0]){
						$total[$data[1]*2+1] = $total[$data[1]*2+1] + ($data[0] - $record_sum) * $data[4];
						$record_sum = $record_sum + ($data[0] - $record_sum);
						//echo $total[$data[1]] . " subtotal for department: " . $data[1] . " current record sum: " . $record_sum . "<br>"; //debug
					}
					else{
						//do nothing
					}
				}
			}
			else{
				//echo "Not set. <br>";
			}
		}
		print_r($total);
	}
	// The script will automatically free the result and close the MySQL
	// connection when it exits, but let's just do it anyways
	$mysqli->close();
?>