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
<script src="js/price_helper.js"></script>

	<h2>Add Item to Inventory:</h2>
	
	<form id="add_item" name="add_item" method="POST" action="mt_api/Add_Item_Handler.php">
        <table>
            <tr>
                <td>
                    UPC:
                </td>
                <td>
                    <input type="text" id="UPC" name="UPC" required autofocus />
                </td>
            </tr>
            <tr>
                <td>
                    Name:
                </td>
                <td>
                    <input type="text" id="NAME" name="NAME" size="25" required/>
                </td>
            </tr>
			<tr>
                <td>
                    Description:
                </td>
                <td>
                    <input type="text" id="DESC" name="DESC" size="95" required/>
                </td>
            </tr>
			<tr>
                <td>
                    Cost:
                </td>
                <td>
                    <input type="number" min="0" step="0.01" id="COST" name="COST" required/>
					<input type="checkbox" name="price_helper1" onclick="price35(this.form)"><em>35% price</em>
                </td>
            </tr>
			<tr>
                <td>
                    Price:
                </td>
                <td>
                    <input type="number" min="0" step="0.01" id="PRICE" name="PRICE" required/>
					<input type="checkbox" name="price_helper2" onclick="pricen30(this.form)"><em>-30% cost estimator</em>
                </td>
            </tr>
			<tr>
                <td>
                    Quantity:
                </td>
                <td>
                    <input type="text" id="QTY" name="QTY" required/>
                </td>
            </tr>
			<tr>
                <td>
                    Wholesaler:
                </td>
                <td>
                    <input type="text" id="WHSLER" name="WHSLER" required/>
                </td>
            </tr>
			<tr>
                <td>
                    Taxable:
                </td>
                <td>
                    <select id="TAXABLE" name="TAXABLE" required>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select>
                </td>
            </tr>
			<tr>
                <td>
                    Department:
                </td>
                <td>
                    <select id="DEPT" name="DEPT" required>
                        <option value="">Choose Department</option>
						<option value="1">1 - Ammunition</option>
                        <option value="2">2 - Accessories</option>
						<option value="3">3 - Food</option>
                        <option value="7">7 - Firearms</option>
                    </select>
                </td>
            </tr>
			<tr>
                <td>
                    Location:
                </td>
                <td>
                    <select id="LOCATION" name="LOCATION" required>
                        <option value="1">1 - 1593 Central Ave</option>
                        <option value="2">2 - Store 2 TDB</option>
                    </select>
                </td>
            </tr>
			<tr>
                <td>
                    User:
                </td>
                <td>
                    <input type="text" id="CLERK" name="CLERK" value=<?php echo $_SESSION['username'] ?> readonly required/>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <input type="submit" id="submit" value="Add Stock" />
                    <input type="reset" id="reset" value="Clear" />
                </td>
            </tr>
        </table>
    </form>