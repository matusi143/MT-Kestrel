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
<script src="js/JsBarcode.ean-upc.min.js"></script>

<h2>Barcode Generator:</h2><br>
	
<svg class="barcode"
	jsbarcode-format="upc"
	jsbarcode-value="123456789012"
	jsbarcode-textmargin="0"
	jsbarcode-fontoptions="bold">
</svg>

<script> JsBarcode(".barcode").init(); </script>

</body>

</html>