		<form name="form1">
		  <select name="menu1" onChange="MM_jumpMenu('parent',this,0)">
			<option value="" selected>Go to ...</option>
			<?php
			if ($fname=="") { echo "<option value=\"login.php\">Log in</option>"; }
			else { 
				if ($utype==1) { // show editors only to admin
					echo "<option value=\"editors.php\">Manage Editors</option>";
				}
				elseif ($utype==2) { // editors
					echo "<option value=\"edit_list.php\">Editable Pages</option>";
				}
				echo "<option value=\"login.php?man_logout=1\">Log out</option>"; 
			}
			?>
		  </select>
		  <input type="button" name="Button1" value="Go" onClick="MM_jumpMenuGo('menu1','parent',0)">
		</form>