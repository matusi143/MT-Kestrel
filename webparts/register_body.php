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
<div id="register">
  <div id="ticket">
    <h1>Thank You!</h1>
    <table>
      <tbody id="entries">
      </tbody>
      <tfoot>
        <tr>
          <th>Subtotal</th>
          <th id="subtotal">$0.00</th>
        </tr>
		<tr>
          <th>Tax</th>
          <th id="tax">$0.00</th>
        </tr>
		<tr>
          <th>Total</th>
          <th id="total">$0.00</th>
        </tr>
      </tfoot>
    </table>
  </div>
  <form id="entry">
    <input id="newEntry" autofocus placeholder="Scan or type UPC here...">
  </form>
</div>

<script src="js/jquery-3.1.1.min.js"></script>  
<script src="js/register.js"></script>
