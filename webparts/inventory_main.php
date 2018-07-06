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
<script src="js/jquery-3.3.1.min.js"></script>

	<h2>Inventory:</h2>
	
	<!-- form to get key detail of record in database -->
	<form id="UPC_form" name="UPC_form" method="POST" action="mt_api/upc_lookup.php">
	<td>
                    UPC:
                </td>
                <td>
					<input type="text" name="UPC"  autofocus required>
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
	<br><br>
	<div id="inventory_detail"></div>

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
             var record_array = data.split(" => ");
			 var form_text = encodeURI('<form name="inventory_form" action="mt_api/inventory_handler.php" method="post"><table><tr><td><h2>Current System Qty:</td><td><input type="text" id="OLD_QTY" name="OLD_QTY" value=') + encodeURI(record_array[6].split(" ")[0]) +  encodeURI(' readonly /></h2></td></tr><tr><td colspan="2" style="text-align: center;"><input type="submit" value="QTY OK" name="approve" style="width:100px; height:75px;" /></td></tr><tr><td>UPC:</td><td><input type="text" id="UPC" name="UPC" value="') + encodeURI(record_array[1].split("  ")[0]) +  encodeURI('" readonly required/></td></tr><tr><td>Name:</td><td><input type="text" id="NAME" name="NAME" value ="') + encodeURI(record_array[2].split("  ")[0]) +  encodeURI('" size="25" required/></td></tr><tr><td>Description:</td><td><input type="text" id="DESC" name="DESC" value="') + encodeURI(record_array[3].split("  ")[0]) +  encodeURI('" size="35" required/></td></tr><tr><td>Price:</td><td><input type="number" min="0" step="0.01" id="PRICE" name="PRICE" required value=') + encodeURI(record_array[4].split(" ")[0]) +  encodeURI(' /></td></tr><tr><td>Location:</td><td><select id="LOCATION" name="LOCATION"><option value="1">1 - 1593 Central Ave</option><option value="2">2 - Store 2 TDB</option></select></td></tr><tr><td>User:</td><td><input type="text" id="CLERK" name="CLERK" value=<?php echo $_SESSION['username'] ?> readonly/></td></tr><tr><td><h2>Inventoried QTY:</td><td><input type="number" min="0" id="INV_QTY" name="INV_QTY"/></h2></td></tr><tr><td>Note:</td><td><input type="text" id="NOTE" name="NOTE" size="40"/></td></tr><tr><td colspan="2" style="text-align: center;"><input type="submit" value="Report Change" name="change" style="width:100px; height:75px;"/></td></tr></table></form>');
             $( "#inventory_detail" ).html(decodeURIComponent(form_text));
         });
    });
	</script>


</body>

</html>