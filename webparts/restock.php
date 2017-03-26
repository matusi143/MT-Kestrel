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
<script src="js/jquery-3.1.1.min.js"></script>

	<h2>Restock Inventory:</h2>
	
	<!-- form to get key detail of record in database -->
	<form id="UPC_form" name="UPC_form" method="POST" action="mt_api/upc_lookup.php">
	<td>
                    UPC:
                </td>
                <td>
					<input type="text" name="UPC" autofocus required>
				</td>
	<td>
                    Location:
                </td>
                <td>
                    <select id="LOCATION" name="LOCATION" required>
                        <option value="1">1 - 1593 Central Ave</option>
                        <option value="2">2 - Store 2 TDB</option>
                    </select>
                </td>
	<input type="submit"  value="Search">
	</form>
	<br>
	<div id="add_stock_filled"></div>

	<script>
     $("#UPC_form").submit(function(event){
         event.preventDefault();

         /* get some values from elements on the page: */
         var $form = $(this),
             $submit = $form.find( 'button[type="submit"]' ),
             UPC_value = $form.find( 'input[name="UPC"]' ).val(),
             LOCATION_value = $form.find( 'select[name="LOCATION"]' ).val(),
             url = $form.attr('action');

         /* Send the data using post */
         var posting = $.post( url, {UPC: UPC_value, LOCATION: LOCATION_value});

         posting.done(function( data )
         {
             /* Put the results in a div */
			 var record_array = data.split(" => ");
			 var form_text = encodeURI('<form name="restock_form" action="mt_api/restock_handler.php" method="post"><table><tr><td>UPC:</td><td><input type="text" id="UPC" name="UPC" value="') + encodeURI(record_array[1].split("  ")[0]) +  encodeURI('" readonly required/></td></tr><tr><td>Name:</td><td><input type="text" id="NAME" name="NAME" value ="') + encodeURI(record_array[2].split("  ")[0]) +  encodeURI('" size="25" required/></td></tr><tr><td>Description:</td><td><input type="text" id="DESC" name="DESC" value="') + encodeURI(record_array[3].split("  ")[0]) +  encodeURI('" size="95" required/></td></tr><tr><td>Cost:</td><td><input type="number" min="0" step="0.01" id="COST" name="COST" required/><input type="checkbox" name="price_helper1" onclick="price35(this.form)"><em>35% price</em></td></tr><tr><td>Price:</td><td><input type="number" min="0" step="0.01" id="PRICE" name="PRICE" required value=') + encodeURI(record_array[4].split(" ")[0]) +  encodeURI(' /> ($') + encodeURI(record_array[4].split(" ")[0]) +  encodeURI(' current price)<input type="checkbox" name="price_helper2" onclick="pricen30(this.form)"><em>-30% cost estimator</em></td></tr><tr><td>Add Stock:</td><td><input type="number" min="0" id="ADD_QTY" name="ADD_QTY" required/></td><td>Current Qty:</td><td><input type="text" id="OLD_QTY" name="OLD_QTY" value=') + encodeURI(record_array[6].split(" ")[0]) +  encodeURI(' readonly /></td></tr><tr><td>Wholesaler:</td><td><input type="text" id="WHSLER" name="WHSLER" required/></td></tr><tr><td>Taxable:</td><td><select id="TAXABLE" name="TAXABLE" required><option value="Yes">Yes</option><option value="No">No</option></select>(Currently, ') + encodeURI(record_array[9].split(" ")[0]) +  encodeURI('</td></tr><tr><td>Department:</td><td><select id="DEPT" name="DEPT" required><option value="">Choose Department</option><option value="1">1 - Ammunition</option><option value="2">2 - Accessories</option><option value="3">3 - Food</option><option value="7">7 - Firearms</option></select> (Current Department: ') + encodeURI(record_array[8].split(" ")[0]) +  encodeURI(')</td></tr><tr><td>Location:</td><td><select id="LOCATION" name="LOCATION"><option value="1">1 - 1593 Central Ave</option><option value="2">2 - Store 2 TDB</option></select></td></tr><tr><td>User:</td><td><input type="text" id="CLERK" name="CLERK" value=<?php echo $_SESSION['username'] ?> readonly/></td></tr><tr><td colspan="2" style="text-align: center;"><input type="submit" id="submit" value="Add Stock" /><input type="reset" id="reset" value="Clear" /></td></tr></table></form>');
             $( "#add_stock_filled" ).html(decodeURIComponent(form_text));
         });
    });
	</script>


</body>

</html>