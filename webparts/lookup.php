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

	<h2>Product Details:</h2>
	
	<!-- form to get key detail of record in database -->
	<form id="UPC_form" name="UPC_form" method="POST" action="mt_api/upc_lookup.php">
	<td>
                    UPC:
                </td>
                <td>
					<input type="text" name="UPC" autofocus>
				</td>
	<td>
                    Location:
                </td>
                <td>
                    <select id="LOCATION" name="LOCATION">
                        <option value="1">1 - 1593 Central Ave</option>
                        <option value="2">2 - Store 2 TDB</option>
                    </select>
                </td>
	<input type="submit"  value="Search">
	</form>
	<br>
	<div id="product_detail"></div>

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
			 var form_text = encodeURI('<table><tr><th>UPC</th><td>') + encodeURI(record_array[1].split("  ")[0]) +  encodeURI('</td></tr><tr><th>Name</th><td>') + encodeURI(record_array[2].split("  ")[0]) +  encodeURI('</td></tr><tr><th>Description</th><td>') + encodeURI(record_array[3].split("  ")[0]) +  encodeURI('</td></tr><tr><th>Price</th><td>$') + encodeURI(record_array[4].split(" ")[0]) +  encodeURI('</td></tr><tr><th>QTY</th><td>') + encodeURI(record_array[6].split(" ")[0]) +  encodeURI('</td></tr><tr><th>Taxable</th><td>') + encodeURI(record_array[9].split("")[0]) +  encodeURI('</td></tr><tr><th>Department</th><td>') + encodeURI(record_array[8].split(" ")[0]) +  encodeURI('</td></tr>');
             $( "#product_detail" ).html(decodeURIComponent(form_text));
			 
         });
    });
	</script>


</body>

</html>