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
<div id="left_col">
<form name="register_keypad" >
<input type="button" class="button button_keypad" value="@/for" onClick="document.register_keypad.ans.value+='@'">
<input type="button" class="button button_keypad" value="." onClick="document.register_keypad.ans.value+='.'">
<input type="reset" class="button button_keypad" value="Clear">
<br>
<input type="button" class="button button_keypad" value="7" onClick="document.register_keypad.ans.value+='7'">
<input type="button" class="button button_keypad" value="8" onClick="document.register_keypad.ans.value+='8'">
<input type="button" class="button button_keypad" value="9" onClick="document.register_keypad.ans.value+='9'">
<br>
<input type="button" class="button button_keypad" value="4" onClick="document.register_keypad.ans.value+='4'">
<input type="button" class="button button_keypad" value="5" onClick="document.register_keypad.ans.value+='5'">
<input type="button" class="button button_keypad" value="6" onClick="document.register_keypad.ans.value+='6'">
<br>
<input type="button" class="button button_keypad" value="1" onClick="document.register_keypad.ans.value+='1'">
<input type="button" class="button button_keypad" value="2" onClick="document.register_keypad.ans.value+='2'">
<input type="button" class="button button_keypad" value="3" onClick="document.register_keypad.ans.value+='3'">
<br>
<input type="button" class="button button_keypad" value="0" onClick="document.register_keypad.ans.value+='0'">
<input type="button" class="button button_keypad" value="00" onClick="document.register_keypad.ans.value+='00'">
<input type="button" class="button button_keypad" value="=" onClick="document.register_keypad.ans.value=eval(document.register_keypad.ans.value)">
<br>Solution is <input type="textfield" name="ans" value="">
</form>
</div>
<div id="right_col">
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
</div>

<script src="js/jquery-3.1.1.min.js"></script>  
<script src="js/register.js"></script>
