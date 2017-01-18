<?php
/**
 * @return void
 * @param $fieldname string
 * @param $default_option string[optional]
 * @param $style string[optional]
 * @param $empty_option_text string[optional]
 * @param $params string[optional]
 * @param $other bool[optional]
 * @desc output select box named $fieldname with products as options
 */
function showProductSelect ($fieldname, $default_option='', $style='', $empty_option_text='Choose a Product', $params = '',$other=false) {
	global $PRODUCT_ARRAY;
	if ($style !== '') {
		$class = "class=\"$style\"";
	} else {
		$class = "";
	}
	print "<select name=\"$fieldname\" id=\"$fieldname\" $class $params>\n";
	print "<option value=\"\"";
	if ($default_option === "")
		print " selected";
	print ">$empty_option_text</option>\n";
	foreach ($PRODUCT_ARRAY as $value) {
        print "<option value=\"$value\"";
        if ($default_option === $value)
        	print " selected";
        print ">$value</option>\n";
	}
	if ($other) print "<option value=\"Other\">Other</option>\n";
	print "</select>";
}
function showProductSelectFiltered ($fieldname, $default_option='', $style='', $empty_option_text='Choose a Product', $params = '',$other=false,$filterlist) {
	global $PRODUCT_ARRAY;
	if ($style !== '') {
		$class = "class=\"$style\"";
	} else {
		$class = "";
	}
	print "<select name=\"$fieldname\" id=\"$fieldname\" $class $params>\n";
	print "<option value=\"\"";
	if ($default_option === "")
		print " selected";
	print ">$empty_option_text</option>\n";
	foreach ($PRODUCT_ARRAY as $value) {
	    if (!in_array($value,$filterlist)){
        	print "<option value=\"$value\"";
        	if ($default_option === $value)
        		print " selected";
        	print ">$value</option>\n";
        }
	}
	if ($other) print "<option value=\"Other\">Other</option>\n";
	print "</select>";
}
/**
 * @return void
 * @param $fieldname string
 * @param $default_option string[optional]
 * @param $style string[optional]
 * @param $empty_option_text string[optional]
 * @param $params string[optional]
 * @desc output select box named $fieldname with products as options
 */
function showStateSelect ($fieldname, $default_option='', $style='', $empty_option_text='Choose a State', $params = '') {
	global $PRODUCT_ARRAY;
	if ($style !== '') {
		$class = "class=\"$style\"";
	} else {
		$class = "";
	}
	print "<select name=\"$fieldname\" id=\"$fieldname\" $class $params>\n";
	print "<option value=\"\"";
	if ($default_option === "")
		print " selected";
	print ">$empty_option_text</option>\n";
?>
  <option value="AL"<?php if ($default_option === "AL") print " selected"; ?>>Alabama</option>
  <option value="AK"<?php if ($default_option === "AK") print " selected"; ?>>Alaska</option>
  <option value="AZ"<?php if ($default_option === "AZ") print " selected"; ?>>Arizona</option>
  <option value="AR"<?php if ($default_option === "AR") print " selected"; ?>>Arkansas</option>
  <option value="CA"<?php if ($default_option === "CA") print " selected"; ?>>California</option>
  <option value="CO"<?php if ($default_option === "CO") print " selected"; ?>>Colorado</option>
  <option value="CT"<?php if ($default_option === "CT") print " selected"; ?>>Connecticut</option>
  <option value="DE"<?php if ($default_option === "DE") print " selected"; ?>>Delaware</option>
  <option value="DC"<?php if ($default_option === "DC") print " selected"; ?>>District of Columbia</option>
  <option value="FL"<?php if ($default_option === "FL") print " selected"; ?>>Florida</option>
  <option value="GA"<?php if ($default_option === "GA") print " selected"; ?>>Georgia</option>
  <option value="HI"<?php if ($default_option === "HI") print " selected"; ?>>Hawaii</option>
  <option value="ID"<?php if ($default_option === "ID") print " selected"; ?>>Idaho</option>
  <option value="IL"<?php if ($default_option === "IL") print " selected"; ?>>Illinois</option>
  <option value="IN"<?php if ($default_option === "IN") print " selected"; ?>>Indiana</option>
  <option value="IA"<?php if ($default_option === "IA") print " selected"; ?>>Iowa</option>
  <option value="KS"<?php if ($default_option === "KS") print " selected"; ?>>Kansas</option>
  <option value="KY"<?php if ($default_option === "KY") print " selected"; ?>>Kentucky</option>
  <option value="LA"<?php if ($default_option === "LA") print " selected"; ?>>Louisiana</option>
  <option value="ME"<?php if ($default_option === "ME") print " selected"; ?>>Maine</option>
  <option value="MD"<?php if ($default_option === "MD") print " selected"; ?>>Maryland</option>
  <option value="MA"<?php if ($default_option === "MA") print " selected"; ?>>Massachusetts</option>
  <option value="MI"<?php if ($default_option === "MI") print " selected"; ?>>Michigan</option>
  <option value="MN"<?php if ($default_option === "MN") print " selected"; ?>>Minnesota</option>
  <option value="MS"<?php if ($default_option === "MS") print " selected"; ?>>Mississippi</option>
  <option value="MO"<?php if ($default_option === "MO") print " selected"; ?>>Missouri</option>
  <option value="MT"<?php if ($default_option === "MT") print " selected"; ?>>Montana</option>
  <option value="NE"<?php if ($default_option === "NE") print " selected"; ?>>Nebraska</option>
  <option value="NV"<?php if ($default_option === "NV") print " selected"; ?>>Nevada</option>
  <option value="NH"<?php if ($default_option === "NH") print " selected"; ?>>New Hampshire</option>
  <option value="NJ"<?php if ($default_option === "NJ") print " selected"; ?>>New Jersey</option>
  <option value="NM"<?php if ($default_option === "NM") print " selected"; ?>>New Mexico</option>
  <option value="NY"<?php if ($default_option === "NY") print " selected"; ?>>New York</option>
  <option value="NC"<?php if ($default_option === "NC") print " selected"; ?>>North Carolina</option>
  <option value="ND"<?php if ($default_option === "ND") print " selected"; ?>>North Dakota</option>
  <option value="OH"<?php if ($default_option === "OH") print " selected"; ?>>Ohio</option>
  <option value="OK"<?php if ($default_option === "OK") print " selected"; ?>>Oklahoma</option>
  <option value="OR"<?php if ($default_option === "OR") print " selected"; ?>>Oregon</option>
  <option value="PA"<?php if ($default_option === "PA") print " selected"; ?>>Pennsylvania</option>
  <option value="RI"<?php if ($default_option === "RI") print " selected"; ?>>Rhode Island</option>
  <option value="SC"<?php if ($default_option === "SC") print " selected"; ?>>South Carolina</option>
  <option value="SD"<?php if ($default_option === "SD") print " selected"; ?>>South Dakota</option>
  <option value="TN"<?php if ($default_option === "TN") print " selected"; ?>>Tennessee</option>
  <option value="TX"<?php if ($default_option === "TX") print " selected"; ?>>Texas</option>
  <option value="UT"<?php if ($default_option === "UT") print " selected"; ?>>Utah</option>
  <option value="VT"<?php if ($default_option === "VT") print " selected"; ?>>Vermont</option>
  <option value="VA"<?php if ($default_option === "VA") print " selected"; ?>>Virginia</option>
  <option value="WA"<?php if ($default_option === "WA") print " selected"; ?>>Washington</option>
  <option value="WV"<?php if ($default_option === "WV") print " selected"; ?>>West Virginia</option>
  <option value="WI"<?php if ($default_option === "WI") print " selected"; ?>>Wisconsin</option>
  <option value="WY"<?php if ($default_option === "WY") print " selected"; ?>>Wyoming</option>
</select>
<?php
	print "</select>";
}
/**
 * @return void
 * @param action string
 * @param method string[optional]
 * @param forgot_password_target string[optional]
 * @desc output login form
 */

function form_login_sso ($action, $method='POST', $forgot_password_target='') {

    if(isset($_COOKIE['ftp'])){
	  	$rememberemail  	= $_COOKIE['ftp'];
	  	$rememberpassword = '';
    }


?>
<table width="189" cellspacing="0" cellpadding="0" class="loginForm">
	<tr>
		<td valign="top"><img src="/images/header_signin.gif" /></td>
	</tr>
	<tr>
		<td class="content">
			<?php print "<form name=\"login\" method=\"$method\" action=\"$action\">"; ?>
			Email Address<br />
			<input name="email" type="text" size="25" class="textField" value="<?=$rememberemail;?>" /><br />
			MySMS Password<br />
			<input name="password" type="password" size="25" class="textField" value="<?=$rememberpassword;?>" /><br />
			<div class="remember"><input name="remeberme" type="checkbox" <?if(isset($_COOKIE['ftp'])) echo'checked="checked"';?> />&nbsp;Remember Me</div> <input name="login" type="hidden" size="18" value="login"> <a href="javascript:document.login.submit();"><img src="/images/btn_go.gif" class="goBtn" border="0" /></a><input type="image" src="/images/spacer.gif">
			<br /><br />
			<a href="<?php print $forgot_password_target ?>" class="forgot">Forgot password?</a>
			</form>
		</td>
	</tr>
	<tr>
		<td valign="bottom"><a href="https://cms.external.smscorp.com/MySMS_Registration.aspx"><img src="/images/btn_register.gif" border="0" /></a></td>
	</tr>
</table>

<?php
}

/**
 * @return void
 * @param action string
 * @param method string[optional]
 * @param forgot_password_target string[optional]
 * @desc output login form
 */

function form_login_test ($action, $method='POST', $forgot_password_target='') {

    if(isset($_COOKIE['ftp'])){
      //echo $_COOKIE['ftp'];
	  db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	  $sql 		= "SELECT email, DECODE(password,'".SALT."') as password FROM users where id = '".$_COOKIE['ftp']."'";
	  $rs 	= mysql_query($sql);
	  if(@$count = mysql_num_rows($rs)){
	  	$rec 				= mysql_fetch_array($rs);
	  	$rememberemail  	= $rec['email'];
	  	// 2011-01-13 - Update ÔMySMS PasswordÕ login cookie to retain the UserÕs ÔEmail AddressÕ only when the ÒRemember MeÓ checkbox is checked
	  	//$rememberpassword  	= $rec['password'];
	  	$rememberpassword = '';
	  	mysql_free_result($rs);
	  }
    }


?>
<table width="189" cellspacing="0" cellpadding="0" class="loginForm">
	<tr>
		<td valign="top"><img src="/images/header_signin.gif" /></td>
	</tr>
	<tr>
		<td class="content">
			<?php print "<form name=\"login\" method=\"$method\" action=\"$action\">"; ?>
			Email Address<br />
			<input name="email" type="text" size="25" class="textField" value="<?=$rememberemail;?>" /><br />
			MySMS Password<br />
			<input name="password" type="password" size="25" class="textField" value="<?=$rememberpassword;?>" /><br />
			<div class="remember"><input name="remeberme" type="checkbox" <?if(isset($_COOKIE['ftp']))echo'checked';?> />&nbsp;Remember Me</div> <input name="login" type="hidden" size="18" value="login"> <a href="javascript:document.login.submit();"><img src="/images/btn_go.gif" class="goBtn" border="0" /></a><input type="image" src="/images/spacer.gif">
			<br /><br />
			<a href="<?php print $forgot_password_target ?>" class="forgot">Forgot password?</a>
			</form>
		</td>
	</tr>
	<tr>
		<td valign="bottom"><a href="http://cms.beta.smscorp.com/MySMS_Registration.aspx"><img src="/images/btn_register.gif" border="0" /></a></td>
	</tr>
</table>

<?php
}

function form_login ($action, $method='POST', $forgot_password_target='') {

    if(isset($_COOKIE['ftp'])){
      //echo $_COOKIE['ftp'];
	  db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	  $sql 		= "SELECT email, DECODE(password,'".SALT."') as password FROM users where id = '".$_COOKIE['ftp']."'";
	  $rs 	= mysql_query($sql);
	  if(@$count = mysql_num_rows($rs)){
	  	$rec 				= mysql_fetch_array($rs);
	  	$rememberemail  	= $rec['email'];
	  	// 2011-01-13 - Update ÔMySMS PasswordÕ login cookie to retain the UserÕs ÔEmail AddressÕ only when the ÒRemember MeÓ checkbox is checked
	  	//$rememberpassword  	= $rec['password'];
	  	$rememberpassword = '';
	  	mysql_free_result($rs);
	  }
    }


?>
<table width="189" cellspacing="0" cellpadding="0" class="loginForm">
	<tr>
		<td valign="top"><img src="/images/header_signin.gif" /></td>
	</tr>
	<tr>
		<td class="content">
			<?php print "<form name=\"login\" method=\"$method\" action=\"$action\">"; ?>
			Email Address<br />
			<input name="email" type="text" size="25" class="textField" value="<?=$rememberemail;?>" /><br />
			MySMS Password<br />
			<input name="password" type="password" size="25" class="textField" value="<?=$rememberpassword;?>" /><br />
			<div class="remember"><input name="remeberme" type="checkbox" <?if(isset($_COOKIE['ftp']))echo'checked';?> />&nbsp;Remember Me</div> <input name="login" type="hidden" size="18" value="login"> <a href="javascript:document.login.submit();"><img src="/images/btn_go.gif" class="goBtn" border="0" /></a><input type="image" src="/images/spacer.gif">
			<br /><br />
			<a href="<?php print $forgot_password_target ?>" class="forgot">Forgot password?</a>
			</form>
		</td>
	</tr>
	<tr>
		<td valign="bottom"><a href="http://mysms.firstamsms.com/public/register/register.php"><img src="/images/btn_register.gif" border="0" /></a></td>
	</tr>
</table>

<?php
}
/**
 * @return void
 * @param info array
 * @desc output registration form, initialize fields with items from info array
 */
function form_register($info="") {
	global $PRODUCT_ARRAY;
	global $CALIFORNIA_COUNTIES_ARRAY;
	$edit = is_array($info) ? true : false;
?>

<script language="javascript">
function showhideCounties(){
	frm = document.register;
	rw = document.getElementById("countiesrow")
	if(frm.state.options[frm.state.selectedIndex].value == 'CA') {
		rw.style.visibility='visible';
		frm.county.focus();
	} else {
		rw.style.visibility='hidden';
		frm.county.selectedIndex = 0;
		frm.state.focus();
	}
}
</script>
			<form name="register" method="post" action="register_confirm.php">
              <table width="515"  border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Email Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input type="text" name="email" class="uploadinputs" value="<?php print $edit ? $info['email'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Confirm Email Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input type="text" name="email1" class="uploadinputs" value="<?php print $edit ? $info['email1'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1"></td>
                  <td width="365"><span class="text1"><font color="#CC0000"><b>Your MySMS password must follow the guidelines below. These guidelines are being implemented to ensure secure access to the MySMS website.</b></font>
                  <br><br></span>
                  	<table border="0" cellpadding="0" cellspacing="0">
                  		<tr>
                  			<td valign="top" colspan="2" class="text1"><font color="#CC0000"><b>Password Guidelines:</b></font></td>
                  		</tr>
                  		<tr>
                  			<td valign="top" ><img src="/images/bullet2.gif"></td>
                  			<td valign="top" class="text1">Minimum of 8 characters in length </td>
                  		</tr>
                  		<tr>
                  			<td valign="top" ><img src="/images/bullet2.gif"></td>
                  			<td valign="top" class="text1">Must contain at least one letter, at least one number, and one of the following special characters ! @ # $ % ^ & * ( ) _ </td>
                  		</tr>
                  		<tr>
                  			<td valign="top" ><img src="/images/bullet2.gif"></td>
                  			<td valign="top" class="text1">Cannot contain three or more consecutive letters from your email address </td>
                  		</tr>
                  	</table>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Password:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td width="365"><input name="password" type="password" class="uploadinputs" value="<?php print $edit ? $info['password'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Confirm Password:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="password1" type="password" class="uploadinputs" value="<?php print $edit ? $info['password1'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">First Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="firstname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['firstname']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Last Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="lastname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['lastname']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Title:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="title" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['title']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Company:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="company" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['company']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="address" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['address']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">City:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="city" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['city']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">State:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">
                    <select name="state" id="state" onchange="showhideCounties();"><?php $state = $edit ? stripslashes($info['state']) : ""; ?>
						<option value=""<?php if ($state === "") print " selected"; ?>>Select...</option>
						<option value="AL"<?php if ($state === "AL") print " selected"; ?>>Alabama</option>
						<option value="AK"<?php if ($state === "AK") print " selected"; ?>>Alaska</option>
						<option value="AS"<?php if ($state === "AS") print " selected"; ?>>American Samoa</option>
						<option value="AZ"<?php if ($state === "AZ") print " selected"; ?>>Arizona</option>
						<option value="AR"<?php if ($state === "AR") print " selected"; ?>>Arkansas</option>
						<option value="CA"<?php if ($state === "CA") print " selected"; ?>>California</option>
						<option value="CO"<?php if ($state === "CO") print " selected"; ?>>Colorado</option>
						<option value="CT"<?php if ($state === "CT") print " selected"; ?>>Connecticut</option>
						<option value="DE"<?php if ($state === "DE") print " selected"; ?>>Delaware</option>
						<option value="DC"<?php if ($state === "DC") print " selected"; ?>>District of Columbia</option>
						<option value="FM"<?php if ($state === "FM") print " selected"; ?>>Fed. States of Micronesia</option>
						<option value="FL"<?php if ($state === "FL") print " selected"; ?>>Florida</option>
						<option value="GA"<?php if ($state === "GA") print " selected"; ?>>Georgia</option>
						<option value="GU"<?php if ($state === "GU") print " selected"; ?>>Guam</option>
						<option value="HI"<?php if ($state === "HI") print " selected"; ?>>Hawaii</option>
						<option value="ID"<?php if ($state === "ID") print " selected"; ?>>Idaho</option>
						<option value="IL"<?php if ($state === "IL") print " selected"; ?>>Illinois</option>
						<option value="IN"<?php if ($state === "IN") print " selected"; ?>>Indiana</option>
						<option value="IA"<?php if ($state === "IA") print " selected"; ?>>Iowa</option>
						<option value="KS"<?php if ($state === "KS") print " selected"; ?>>Kansas</option>
						<option value="KY"<?php if ($state === "KY") print " selected"; ?>>Kentucky</option>
						<option value="LA"<?php if ($state === "LA") print " selected"; ?>>Louisiana</option>
						<option value="ME"<?php if ($state === "ME") print " selected"; ?>>Maine</option>
						<option value="MH"<?php if ($state === "MH") print " selected"; ?>>Marshall Islands</option>
						<option value="MD"<?php if ($state === "MD") print " selected"; ?>>Maryland</option>
						<option value="MA"<?php if ($state === "MA") print " selected"; ?>>Massachusetts</option>
						<option value="MI"<?php if ($state === "MI") print " selected"; ?>>Michigan</option>
						<option value="MN"<?php if ($state === "MN") print " selected"; ?>>Minnesota</option>
						<option value="MS"<?php if ($state === "MS") print " selected"; ?>>Mississippi</option>
						<option value="MO"<?php if ($state === "MO") print " selected"; ?>>Missouri</option>
						<option value="MT"<?php if ($state === "MT") print " selected"; ?>>Montana</option>
						<option value="NE"<?php if ($state === "NE") print " selected"; ?>>Nebraska</option>
						<option value="NV"<?php if ($state === "NV") print " selected"; ?>>Nevada</option>
						<option value="NH"<?php if ($state === "NH") print " selected"; ?>>New Hampshire</option>
						<option value="NJ"<?php if ($state === "NJ") print " selected"; ?>>New Jersey</option>
						<option value="NM"<?php if ($state === "NM") print " selected"; ?>>New Mexico</option>
						<option value="NY"<?php if ($state === "NY") print " selected"; ?>>New York</option>
						<option value="NC"<?php if ($state === "NC") print " selected"; ?>>North Carolina</option>
						<option value="ND"<?php if ($state === "ND") print " selected"; ?>>North Dakota</option>
						<option value="MP"<?php if ($state === "MP") print " selected"; ?>>Northern Mariana Islands</option>
						<option value="OH"<?php if ($state === "OH") print " selected"; ?>>Ohio</option>
						<option value="OK"<?php if ($state === "OK") print " selected"; ?>>Oklahoma</option>
						<option value="OR"<?php if ($state === "OR") print " selected"; ?>>Oregon</option>
						<option value="PW"<?php if ($state === "PW") print " selected"; ?>>Palau</option>
						<option value="PA"<?php if ($state === "PA") print " selected"; ?>>Pennsylvania</option>
						<option value="PR"<?php if ($state === "PR") print " selected"; ?>>Puerto Rico</option>
						<option value="RI"<?php if ($state === "RI") print " selected"; ?>>Rhode Island</option>
						<option value="SC"<?php if ($state === "SC") print " selected"; ?>>South Carolina</option>
						<option value="SD"<?php if ($state === "SD") print " selected"; ?>>South Dakota</option>
						<option value="TN"<?php if ($state === "TN") print " selected"; ?>>Tennessee</option>
						<option value="TX"<?php if ($state === "TX") print " selected"; ?>>Texas</option>
						<option value="UT"<?php if ($state === "UT") print " selected"; ?>>Utah</option>
						<option value="VT"<?php if ($state === "VT") print " selected"; ?>>Vermont</option>
						<option value="VI"<?php if ($state === "VI") print " selected"; ?>>Virgin Islands</option>
						<option value="VA"<?php if ($state === "VA") print " selected"; ?>>Virginia</option>
						<option value="WA"<?php if ($state === "WA") print " selected"; ?>>Washington</option>
						<option value="WV"<?php if ($state === "WV") print " selected"; ?>>West Virginia</option>
						<option value="WI"<?php if ($state === "WI") print " selected"; ?>>Wisconsin</option>
						<option value="WY"<?php if ($state === "WY") print " selected"; ?>>Wyoming</option>
					</select>
                  </font></font>
                  </td>
                </tr><?php $county = $edit ? stripslashes($info['county']) : ""; ?>
                <tr bgcolor="#FFFFFF" class="textbody" style="visibility:<?php print (($county === "") && ($state !== "CA")) ? "hidden":"visible"; ?>" id="countiesrow">
                  <td align="left" class="text1">County:&nbsp;<strong><b><font color="#CC0000">*</font></b> </strong></td>
                  <td><select name="county" id="county">
                      <option value=""<?php if ($county === "") print " selected"; ?>>Choose a County</option>
                      <?php
                      	foreach ($CALIFORNIA_COUNTIES_ARRAY as $value) {
                      		print "<option value=\"$value\"";
                      		if ($county === $value) print " selected";
                      		print ">$value</option>\n";
                      	}
                      ?>
                      </select>
    (Shown only if CA selected)</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Zip:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="zip" type="text" size="10" maxlength="10" value="<?php print $edit ? $info['zip'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Phone:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td>(
                    <input name="phone1" type="text" id="phone1" size="3" maxlength="3" value="<?php print $edit ? $info['phone1'] : ""; ?>">
) <b><font color="#CC0000">
<input name="phone2" type="text" id="phone2" size="3" maxlength="3" value="<?php print $edit ? $info['phone2'] : ""; ?>">
</font></b>-
<input name="phone3" type="text" id="phone3" size="4" maxlength="4" value="<?php print $edit ? $info['phone3'] : ""; ?>">
<font color="#CC0000">&nbsp;</font> Ext.
<input name="phone4" type="text" id="phone4" size="4" maxlength="4" value="<?php print $edit ? $info['phone4'] : ""; ?>">
<font color="#CC0000">&nbsp;</font>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Fax:&nbsp;</td>
                  <td>(
                    <input name="fax1" type="text" id="fax1" size="3" maxlength="3" value="<?php print $edit ? $info['fax1'] : ""; ?>">
) <b><font color="#CC0000">
<input name="fax2" type="text" id="fax2" size="3" maxlength="3" value="<?php print $edit ? $info['fax2'] : ""; ?>">
</font></b>-
<input name="fax3" type="text" id="fax3" size="4" maxlength="4" value="<?php print $edit ? $info['fax3'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td valign="top">&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">Default Product:&nbsp;<b><font color="#CC0000">* </font></b><br></td>
                  <td valign="top"><p><span class="text1">Select the product to which you would like MySMS to default to when accessing training and support information. Note: You will have the option to change products.</span></p>
                    <p><?php
                    		$default_product = $edit ? stripslashes($info['default_product']) : "";
                    		showProductSelect('default_product', $default_product, 'uploadinputs');
                    	?></p>
                  <p>&nbsp;</p></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td><input type="submit" name="Submit" value="Submit Registration"></td>
                </tr>
              </table>
              </form>
<?php
}
/**
 * @return void
 * @param info array
 * @desc output delete user form, initialize fields with items from info array
 */
function form_delete_user($info="") {
	global $PRODUCT_ARRAY;
	global $CALIFORNIA_COUNTIES_ARRAY;
?>
			<form name="edit_user" method="post" action="edit_user_confirmation.php">
              <table width="515"  border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Email Address:&nbsp;</td>
                  <td><input name="email" type="hidden" class="uploadinputs" value="<?php print stripslashes($info['email']); ?>"><?php print stripslashes($info['email']); ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Password:&nbsp;</td>
                  <td width="365"><?php print str_repeat("*",strlen($info['password'])+1); ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">First Name:&nbsp;</td>
                  <td><input name="firstname" type="hidden" class="uploadinputs" value="<?php print stripslashes($info['firstname']); ?>"><?php print stripslashes($info['firstname']); ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Last Name:&nbsp;</td>
                  <td><input name="lastname" type="hidden" class="uploadinputs" value="<?php print stripslashes($info['lastname']); ?>"><?php print stripslashes($info['lastname']); ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Title:&nbsp;</td>
                  <td><?php print stripslashes($info['title']); ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Company:&nbsp;</td>
                  <td><?php print stripslashes($info['company']); ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Address:&nbsp;</td>
                  <td><?php print stripslashes($info['address']); ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">City:&nbsp;</td>
                  <td><?php print stripslashes($info['city']); ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">State:&nbsp;</td>
                  <td><?php print stripslashes($info['state']); ?>
                  </td>
                </tr>
                <?php if ($county !== "") { ?>
                <tr bgcolor="#FFFFFF" class="textbody" id="countiesrow">
                  <td align="left" class="text1">County:&nbsp;<strong><b><font color="#CC0000">*</font></b> </strong></td>
                  <td><?php print stripslashes($info['county']); ?></td>
                </tr>
                <?php } ?>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Zip:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><?php print stripslashes($info['zip']); ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Phone:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><?php print fix_phone_out($info['phone']); ?>
                  </td>
                </tr>
                <?php if ($county !== "") { ?>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Fax:&nbsp;</td>
                  <td><?php print fix_phone_out($info['fax']); ?>
                  </td>
                </tr>
                <? } ?>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td valign="top">&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">Default Product:&nbsp;<b><font color="#CC0000">* </font></b><br></td>
                  <td valign="top"><?php print stripslashes($info['default_product']); ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Registration Status:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><?php print stripslashes($info['registration_status']); ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Signup Date:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><?php print $info['signup_date']; ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">IP Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><?php print $info['ip_address']; ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Computer Details:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><?php print stripslashes($info['computer_details']); ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;<input type="hidden" name="id" value="<?php print $info['id']; ?>"></td>
                  <td>&nbsp;<input type="hidden" name="user_action" value="delete"></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td><input type="submit" name="Submit" value="Delete Registrant">&nbsp;<input type="button" name="Cancel" value="Cancel" onclick="javascript:history.back();"></td>
                </tr>
              </table>
              </form>
<?php
}
/**
 * @return void
 * @param $info array
 * @param $public bool
 * @desc output edit user form, initialize fields with items from info array
 */
function form_edit_user($info="",$public=false) {
	global $PRODUCT_ARRAY;
	global $CALIFORNIA_COUNTIES_ARRAY;
	$edit = is_array($info) ? true : false;
	$target = ($public) ? "edit_profile_confirmation.php":"edit_user_confirmation.php";
?>

<script language="javascript">
function showhideCounties(){
	frm = document.register;
	rw = document.getElementById("countiesrow")
	if(frm.state.options[frm.state.selectedIndex].value == 'CA') {
		rw.style.visibility='visible';
		frm.county.focus();
	} else {
		rw.style.visibility='hidden';
		frm.county.selectedIndex = 0;
		frm.state.focus();
	}
}
</script>
			<form name="edit_user" method="post" action="<?php print $target; ?>">
              <table width="515"  border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Email Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input type="text" name="email" class="uploadinputs" value="<?php print $edit ? stripslashes($info['email']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Password:&nbsp;</td>
                  <td width="365"><?php print str_repeat("*",strlen($info['password'])+1); ?><input name="password" type="hidden" class="uploadinputs" value="<?php print $edit ? $info['password'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1"></td>
                  <td><p><span class="text1"><span class="text1"><font color="#CC0000"><b>Your MySMS password must follow the guidelines below. These guidelines are being implemented to ensure secure access to the MySMS website.</b></font>
                  <br><br></span>
                  	<table border="0" cellpadding="0" cellspacing="0">
                  		<tr>
                  			<td valign="top" colspan="2" class="text1"><font color="#CC0000"><b>Password Guidelines:</b></font></td>
                  		</tr>
                  		<tr>
                  			<td valign="top" ><img src="/images/bullet2.gif"></td>
                  			<td valign="top" class="text1">Minimum of 8 characters in length </td>
                  		</tr>
                  		<tr>
                  			<td valign="top" ><img src="/images/bullet2.gif"></td>
                  			<td valign="top" class="text1">Must contain at least one letter, at least one number, and one of the following special characters ! @ # $ % ^ & * ( ) _ </td>
                  		</tr>
                  		<tr>
                  			<td valign="top" ><img src="/images/bullet2.gif"></td>
                  			<td valign="top" class="text1">Cannot contain three or more consecutive letters from your email address </td>
                  		</tr>
                  	</table>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">New Password:&nbsp;</td>
                  <td><input name="new_password" type="password" class="uploadinputs" value="<?php print $edit ? $info['new_password'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Confirm Password:&nbsp;</td>
                  <td><input name="password1" type="password" class="uploadinputs" value="<?php print $edit ? $info['password1'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">First Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="firstname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['firstname']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Last Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="lastname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['lastname']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Title:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="title" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['title']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Company:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="company" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['company']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="address" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['address']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">City:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="city" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['city']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">State:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">
                    <select name="state" id="state" onchange="showhideCounties();"><?php $state = $edit ? stripslashes($info['state']) : ""; ?>
						<option value=""<?php if ($state === "") print " selected"; ?>>Select...</option>
						<option value="AL"<?php if ($state === "AL") print " selected"; ?>>Alabama</option>
						<option value="AK"<?php if ($state === "AK") print " selected"; ?>>Alaska</option>
						<option value="AS"<?php if ($state === "AS") print " selected"; ?>>American Samoa</option>
						<option value="AZ"<?php if ($state === "AZ") print " selected"; ?>>Arizona</option>
						<option value="AR"<?php if ($state === "AR") print " selected"; ?>>Arkansas</option>
						<option value="CA"<?php if ($state === "CA") print " selected"; ?>>California</option>
						<option value="CO"<?php if ($state === "CO") print " selected"; ?>>Colorado</option>
						<option value="CT"<?php if ($state === "CT") print " selected"; ?>>Connecticut</option>
						<option value="DE"<?php if ($state === "DE") print " selected"; ?>>Delaware</option>
						<option value="DC"<?php if ($state === "DC") print " selected"; ?>>District of Columbia</option>
						<option value="FM"<?php if ($state === "FM") print " selected"; ?>>Fed. States of Micronesia</option>
						<option value="FL"<?php if ($state === "FL") print " selected"; ?>>Florida</option>
						<option value="GA"<?php if ($state === "GA") print " selected"; ?>>Georgia</option>
						<option value="GU"<?php if ($state === "GU") print " selected"; ?>>Guam</option>
						<option value="HI"<?php if ($state === "HI") print " selected"; ?>>Hawaii</option>
						<option value="ID"<?php if ($state === "ID") print " selected"; ?>>Idaho</option>
						<option value="IL"<?php if ($state === "IL") print " selected"; ?>>Illinois</option>
						<option value="IN"<?php if ($state === "IN") print " selected"; ?>>Indiana</option>
						<option value="IA"<?php if ($state === "IA") print " selected"; ?>>Iowa</option>
						<option value="KS"<?php if ($state === "KS") print " selected"; ?>>Kansas</option>
						<option value="KY"<?php if ($state === "KY") print " selected"; ?>>Kentucky</option>
						<option value="LA"<?php if ($state === "LA") print " selected"; ?>>Louisiana</option>
						<option value="ME"<?php if ($state === "ME") print " selected"; ?>>Maine</option>
						<option value="MH"<?php if ($state === "MH") print " selected"; ?>>Marshall Islands</option>
						<option value="MD"<?php if ($state === "MD") print " selected"; ?>>Maryland</option>
						<option value="MA"<?php if ($state === "MA") print " selected"; ?>>Massachusetts</option>
						<option value="MI"<?php if ($state === "MI") print " selected"; ?>>Michigan</option>
						<option value="MN"<?php if ($state === "MN") print " selected"; ?>>Minnesota</option>
						<option value="MS"<?php if ($state === "MS") print " selected"; ?>>Mississippi</option>
						<option value="MO"<?php if ($state === "MO") print " selected"; ?>>Missouri</option>
						<option value="MT"<?php if ($state === "MT") print " selected"; ?>>Montana</option>
						<option value="NE"<?php if ($state === "NE") print " selected"; ?>>Nebraska</option>
						<option value="NV"<?php if ($state === "NV") print " selected"; ?>>Nevada</option>
						<option value="NH"<?php if ($state === "NH") print " selected"; ?>>New Hampshire</option>
						<option value="NJ"<?php if ($state === "NJ") print " selected"; ?>>New Jersey</option>
						<option value="NM"<?php if ($state === "NM") print " selected"; ?>>New Mexico</option>
						<option value="NY"<?php if ($state === "NY") print " selected"; ?>>New York</option>
						<option value="NC"<?php if ($state === "NC") print " selected"; ?>>North Carolina</option>
						<option value="ND"<?php if ($state === "ND") print " selected"; ?>>North Dakota</option>
						<option value="MP"<?php if ($state === "MP") print " selected"; ?>>Northern Mariana Islands</option>
						<option value="OH"<?php if ($state === "OH") print " selected"; ?>>Ohio</option>
						<option value="OK"<?php if ($state === "OK") print " selected"; ?>>Oklahoma</option>
						<option value="OR"<?php if ($state === "OR") print " selected"; ?>>Oregon</option>
						<option value="PW"<?php if ($state === "PW") print " selected"; ?>>Palau</option>
						<option value="PA"<?php if ($state === "PA") print " selected"; ?>>Pennsylvania</option>
						<option value="PR"<?php if ($state === "PR") print " selected"; ?>>Puerto Rico</option>
						<option value="RI"<?php if ($state === "RI") print " selected"; ?>>Rhode Island</option>
						<option value="SC"<?php if ($state === "SC") print " selected"; ?>>South Carolina</option>
						<option value="SD"<?php if ($state === "SD") print " selected"; ?>>South Dakota</option>
						<option value="TN"<?php if ($state === "TN") print " selected"; ?>>Tennessee</option>
						<option value="TX"<?php if ($state === "TX") print " selected"; ?>>Texas</option>
						<option value="UT"<?php if ($state === "UT") print " selected"; ?>>Utah</option>
						<option value="VT"<?php if ($state === "VT") print " selected"; ?>>Vermont</option>
						<option value="VI"<?php if ($state === "VI") print " selected"; ?>>Virgin Islands</option>
						<option value="VA"<?php if ($state === "VA") print " selected"; ?>>Virginia</option>
						<option value="WA"<?php if ($state === "WA") print " selected"; ?>>Washington</option>
						<option value="WV"<?php if ($state === "WV") print " selected"; ?>>West Virginia</option>
						<option value="WI"<?php if ($state === "WI") print " selected"; ?>>Wisconsin</option>
						<option value="WY"<?php if ($state === "WY") print " selected"; ?>>Wyoming</option>
					</select>
                  </font></font>
                  </td>
                </tr><?php $county = $edit ? stripslashes($info['county']) : ""; ?>
                <tr bgcolor="#FFFFFF" class="textbody" style="visibility:<?php print (($county === "") && ($state !== "CA")) ? "hidden":"visible"; ?>" id="countiesrow">
                  <td align="left" class="text1">County:&nbsp;<strong><b><font color="#CC0000">*</font></b> </strong></td>
                  <td><select name="county" id="county">
                      <option value=""<?php if ($county === "") print " selected"; ?>>Choose a County</option>
                      <?php
                      	foreach ($CALIFORNIA_COUNTIES_ARRAY as $value) {
                      		print "<option value=\"$value\"";
                      		if ($county === $value) print " selected";
                      		print ">$value</option>\n";
                      	}
                      ?>
                      </select>
    (Shown only if CA selected)</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Zip:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="zip" type="text" size="10" maxlength="10" value="<?php print $edit ? $info['zip'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Phone:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td>(
                    <input name="phone1" type="text" id="phone1" size="3" maxlength="3" value="<?php print $edit ? $info['phone1'] : ""; ?>">
) <b><font color="#CC0000">
<input name="phone2" type="text" id="phone2" size="3" maxlength="3" value="<?php print $edit ? $info['phone2'] : ""; ?>">
</font></b>-
<input name="phone3" type="text" id="phone3" size="4" maxlength="4" value="<?php print $edit ? $info['phone3'] : ""; ?>">
<font color="#CC0000">&nbsp;</font> Ext.
<input name="phone4" type="text" id="phone4" size="4" maxlength="4" value="<?php print $edit ? $info['phone4'] : ""; ?>">
<font color="#CC0000">&nbsp;</font>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Fax:&nbsp;</td>
                  <td>(
                    <input name="fax1" type="text" id="fax1" size="3" maxlength="3" value="<?php print $edit ? $info['fax1'] : ""; ?>">
) <b><font color="#CC0000">
<input name="fax2" type="text" id="fax2" size="3" maxlength="3" value="<?php print $edit ? $info['fax2'] : ""; ?>">
</font></b>-
<input name="fax3" type="text" id="fax3" size="4" maxlength="4" value="<?php print $edit ? $info['fax3'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td valign="top">&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">Default Product:&nbsp;<b><font color="#CC0000">* </font></b><br></td>
                  <td valign="top"><p><span class="text1">Select the product to which you would like MySMS to default to when accessing training and support information. Note: You will have the option to change products.</span></p>
                    <p><?php
                    		$default_product = $edit ? stripslashes($info['default_product']) : "";
                    		showProductSelect('default_product', $default_product, 'uploadinputs');
                    	?></p>
                  <p>&nbsp;</p></td>
                </tr>
<?php
	if (!$public) {
?>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Client ID:&nbsp;</td>
                  <td><input name="clientid" type="text" id="clientid" size="20" maxlength="10" value="<?php print $edit ? $info['clientid'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Registration Status:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><select name="registration_status"><?php $registration_status = $edit ? $info['registration_status'] : ""; ?>
		              	<option value=""<?php if ($registration_status === "") print " selected"; ?>>Select...</option>
		                <option value="Pending"<?php if ($registration_status === "Pending") print " selected"; ?>>Pending</option>
		                <option value="Approved"<?php if ($registration_status === "Approved") print " selected"; ?>>Approved</option>
		                <option value="Credit Hold"<?php if ($registration_status === "Credit Hold") print " selected"; ?>>Credit Hold</option>
		                <option value="Inactive"<?php if ($registration_status === "Inactive") print " selected"; ?>>Inactive</option>
		                <option value="Denied"<?php if ($registration_status === "Denied") print " selected"; ?>>Denied</option>
		                <option value="Profile Update"<?php if ($registration_status === "Profile Update") print " selected"; ?>>Profile Update</option>
                  	  </select>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Signup Date:&nbsp;</td>
                  <td><?php print $info['signup_date']; ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Last Login:&nbsp;</td>
                  <td><?php print convert_datetime($info['last_login'],'Y-m-d H:i:s'); ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">IP Address:&nbsp;</td>
                  <td><?php print $info['ip_address']; ?>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Computer Details:&nbsp;</td>
                  <td><?php print stripslashes($info['computer_details']); ?>
                  </td>
                </tr>
<?php
	}
?>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;<input type="hidden" name="id" value="<?php print $info['id']; ?>"></td>
                  <td>&nbsp;<input type="hidden" name="user_action" value="edit"></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td><input type="submit" name="Submit" value="Submit Changes">&nbsp;<input type="button" name="Cancel" value="Cancel" onclick="javascript:history.back();"></td>
                </tr>
              </table>
              </form>
<?php
}
/**
 * @return void
 * @param info array
 * @desc output admin add user form, initialize fields with items from info array
 */
function form_add_user($info="") {
	global $PRODUCT_ARRAY;
	global $CALIFORNIA_COUNTIES_ARRAY;
	$edit = is_array($info) ? true : false;
?>

<script language="javascript">
function showhideCounties(){
	frm = document.add_user;
	rw = document.getElementById("countiesrow")
	if(frm.state.options[frm.state.selectedIndex].value == 'CA') {
		rw.style.visibility='visible';
		frm.county.focus();
	} else {
		rw.style.visibility='hidden';
		frm.county.selectedIndex = 0;
		frm.state.focus();
	}
}
</script>
			<form name="add_user" method="post" action="edit_user_confirmation.php">
              <table width="515"  border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Email Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input type="text" name="email" class="uploadinputs" value="<?php print $edit ? $info['email'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Confirm Email Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input type="text" name="email1" class="uploadinputs" value="<?php print $edit ? $info['email1'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1"></td>
                  <td width="365"><span class="text1"><font color="#CC0000"><b>Your MySMS password must follow the guidelines below. These guidelines are being implemented to ensure secure access to the MySMS website.</b></font>
                  <br><br></span>
                  	<table border="0" cellpadding="0" cellspacing="0">
                  		<tr>
                  			<td valign="top" colspan="2" class="text1"><font color="#CC0000"><b>Password Guidelines:</b></font></td>
                  		</tr>
                  		<tr>
                  			<td valign="top" ><img src="/images/bullet2.gif"></td>
                  			<td valign="top" class="text1">Minimum of 8 characters in length </td>
                  		</tr>
                  		<tr>
                  			<td valign="top" ><img src="/images/bullet2.gif"></td>
                  			<td valign="top" class="text1">Must contain at least one letter, at least one number, and one of the following special characters ! @ # $ % ^ & * ( ) _ </td>
                  		</tr>
                  		<tr>
                  			<td valign="top" ><img src="/images/bullet2.gif"></td>
                  			<td valign="top" class="text1">Cannot contain three or more consecutive letters from your email address </td>
                  		</tr>
                  	</table>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Password:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td width="365"><input name="password" type="password" class="uploadinputs" value="<?php print $edit ? $info['password'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Confirm Password:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="password1" type="password" class="uploadinputs" value="<?php print $edit ? $info['password1'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">First Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="firstname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['firstname']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Last Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="lastname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['lastname']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Title:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="title" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['title']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Company:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="company" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['company']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="address" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['address']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">City:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="city" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['city']) : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">State:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">
                    <select name="state" id="state" onchange="showhideCounties();"><?php $state = $edit ? stripslashes($info['state']) : ""; ?>
						<option value=""<?php if ($state === "") print " selected"; ?>>Select...</option>
						<option value="AL"<?php if ($state === "AL") print " selected"; ?>>Alabama</option>
						<option value="AK"<?php if ($state === "AK") print " selected"; ?>>Alaska</option>
						<option value="AS"<?php if ($state === "AS") print " selected"; ?>>American Samoa</option>
						<option value="AZ"<?php if ($state === "AZ") print " selected"; ?>>Arizona</option>
						<option value="AR"<?php if ($state === "AR") print " selected"; ?>>Arkansas</option>
						<option value="CA"<?php if ($state === "CA") print " selected"; ?>>California</option>
						<option value="CO"<?php if ($state === "CO") print " selected"; ?>>Colorado</option>
						<option value="CT"<?php if ($state === "CT") print " selected"; ?>>Connecticut</option>
						<option value="DE"<?php if ($state === "DE") print " selected"; ?>>Delaware</option>
						<option value="DC"<?php if ($state === "DC") print " selected"; ?>>District of Columbia</option>
						<option value="FM"<?php if ($state === "FM") print " selected"; ?>>Fed. States of Micronesia</option>
						<option value="FL"<?php if ($state === "FL") print " selected"; ?>>Florida</option>
						<option value="GA"<?php if ($state === "GA") print " selected"; ?>>Georgia</option>
						<option value="GU"<?php if ($state === "GU") print " selected"; ?>>Guam</option>
						<option value="HI"<?php if ($state === "HI") print " selected"; ?>>Hawaii</option>
						<option value="ID"<?php if ($state === "ID") print " selected"; ?>>Idaho</option>
						<option value="IL"<?php if ($state === "IL") print " selected"; ?>>Illinois</option>
						<option value="IN"<?php if ($state === "IN") print " selected"; ?>>Indiana</option>
						<option value="IA"<?php if ($state === "IA") print " selected"; ?>>Iowa</option>
						<option value="KS"<?php if ($state === "KS") print " selected"; ?>>Kansas</option>
						<option value="KY"<?php if ($state === "KY") print " selected"; ?>>Kentucky</option>
						<option value="LA"<?php if ($state === "LA") print " selected"; ?>>Louisiana</option>
						<option value="ME"<?php if ($state === "ME") print " selected"; ?>>Maine</option>
						<option value="MH"<?php if ($state === "MH") print " selected"; ?>>Marshall Islands</option>
						<option value="MD"<?php if ($state === "MD") print " selected"; ?>>Maryland</option>
						<option value="MA"<?php if ($state === "MA") print " selected"; ?>>Massachusetts</option>
						<option value="MI"<?php if ($state === "MI") print " selected"; ?>>Michigan</option>
						<option value="MN"<?php if ($state === "MN") print " selected"; ?>>Minnesota</option>
						<option value="MS"<?php if ($state === "MS") print " selected"; ?>>Mississippi</option>
						<option value="MO"<?php if ($state === "MO") print " selected"; ?>>Missouri</option>
						<option value="MT"<?php if ($state === "MT") print " selected"; ?>>Montana</option>
						<option value="NE"<?php if ($state === "NE") print " selected"; ?>>Nebraska</option>
						<option value="NV"<?php if ($state === "NV") print " selected"; ?>>Nevada</option>
						<option value="NH"<?php if ($state === "NH") print " selected"; ?>>New Hampshire</option>
						<option value="NJ"<?php if ($state === "NJ") print " selected"; ?>>New Jersey</option>
						<option value="NM"<?php if ($state === "NM") print " selected"; ?>>New Mexico</option>
						<option value="NY"<?php if ($state === "NY") print " selected"; ?>>New York</option>
						<option value="NC"<?php if ($state === "NC") print " selected"; ?>>North Carolina</option>
						<option value="ND"<?php if ($state === "ND") print " selected"; ?>>North Dakota</option>
						<option value="MP"<?php if ($state === "MP") print " selected"; ?>>Northern Mariana Islands</option>
						<option value="OH"<?php if ($state === "OH") print " selected"; ?>>Ohio</option>
						<option value="OK"<?php if ($state === "OK") print " selected"; ?>>Oklahoma</option>
						<option value="OR"<?php if ($state === "OR") print " selected"; ?>>Oregon</option>
						<option value="PW"<?php if ($state === "PW") print " selected"; ?>>Palau</option>
						<option value="PA"<?php if ($state === "PA") print " selected"; ?>>Pennsylvania</option>
						<option value="PR"<?php if ($state === "PR") print " selected"; ?>>Puerto Rico</option>
						<option value="RI"<?php if ($state === "RI") print " selected"; ?>>Rhode Island</option>
						<option value="SC"<?php if ($state === "SC") print " selected"; ?>>South Carolina</option>
						<option value="SD"<?php if ($state === "SD") print " selected"; ?>>South Dakota</option>
						<option value="TN"<?php if ($state === "TN") print " selected"; ?>>Tennessee</option>
						<option value="TX"<?php if ($state === "TX") print " selected"; ?>>Texas</option>
						<option value="UT"<?php if ($state === "UT") print " selected"; ?>>Utah</option>
						<option value="VT"<?php if ($state === "VT") print " selected"; ?>>Vermont</option>
						<option value="VI"<?php if ($state === "VI") print " selected"; ?>>Virgin Islands</option>
						<option value="VA"<?php if ($state === "VA") print " selected"; ?>>Virginia</option>
						<option value="WA"<?php if ($state === "WA") print " selected"; ?>>Washington</option>
						<option value="WV"<?php if ($state === "WV") print " selected"; ?>>West Virginia</option>
						<option value="WI"<?php if ($state === "WI") print " selected"; ?>>Wisconsin</option>
						<option value="WY"<?php if ($state === "WY") print " selected"; ?>>Wyoming</option>
					</select>
                  </font></font>
                  </td>
                </tr><?php $county = $edit ? stripslashes($info['county']) : ""; ?>
                <tr bgcolor="#FFFFFF" class="textbody" style="visibility:<?php print (($county === "") && ($state !== "CA")) ? "hidden":"visible"; ?>" id="countiesrow">
                  <td align="left" class="text1">County:&nbsp;<strong><b><font color="#CC0000">*</font></b> </strong></td>
                  <td><select name="county" id="county">
                      <option value=""<?php if ($county === "") print " selected"; ?>>Choose a County</option>
                      <?php
                      	foreach ($CALIFORNIA_COUNTIES_ARRAY as $value) {
                      		print "<option value=\"$value\"";
                      		if ($county === $value) print " selected";
                      		print ">$value</option>\n";
                      	}
                      ?>
                      </select>
    (Shown only if CA selected)</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Zip:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="zip" type="text" size="10" maxlength="10" value="<?php print $edit ? $info['zip'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Phone:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td>(
                    <input name="phone1" type="text" id="phone1" size="3" maxlength="3" value="<?php print $edit ? $info['phone1'] : ""; ?>">
) <b><font color="#CC0000">
<input name="phone2" type="text" id="phone2" size="3" maxlength="3" value="<?php print $edit ? $info['phone2'] : ""; ?>">
</font></b>-
<input name="phone3" type="text" id="phone3" size="4" maxlength="4" value="<?php print $edit ? $info['phone3'] : ""; ?>">
<font color="#CC0000">&nbsp;</font> Ext.
<input name="phone4" type="text" id="phone4" size="4" maxlength="4" value="<?php print $edit ? $info['phone4'] : ""; ?>">
<font color="#CC0000">&nbsp;</font>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Fax:&nbsp;</td>
                  <td>(
                    <input name="fax1" type="text" id="fax1" size="3" maxlength="3" value="<?php print $edit ? $info['fax1'] : ""; ?>">
) <b><font color="#CC0000">
<input name="fax2" type="text" id="fax2" size="3" maxlength="3" value="<?php print $edit ? $info['fax2'] : ""; ?>">
</font></b>-
<input name="fax3" type="text" id="fax3" size="4" maxlength="4" value="<?php print $edit ? $info['fax3'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td valign="top">&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">Default Product:&nbsp;<b><font color="#CC0000">* </font></b><br></td>
                  <td valign="top"><p><span class="text1">Select the product to which you would like MySMS to default to when accessing training and support information. Note: You will have the option to change products.</span></p>
                    <p><?php
                    		$default_product = $edit ? stripslashes($info['default_product']) : "";
                    		showProductSelect('default_product', $default_product, 'uploadinputs');
                    	?></p>
                  <p>&nbsp;</p></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;<input type="hidden" name="user_action" value="add"></td>
                  <td><input type="submit" name="Submit" value="Submit Registration"></td>
                </tr>
              </table>
              </form>
<?php
}
/**
 * @return void
 * @desc output admin form to change application variables
 */
function form_admin_settings() {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	$sql = "SELECT a.id,a.name,a.title,a.description,a.value,a.type,a.group,a.sort_order,DATE_FORMAT(a.last_modified, '%m-%d-%Y %H:%i:%s') as last_modified FROM admin_settings AS a ORDER BY a.group ASC,a.sort_order ASC";
	$result = mysql_query($sql);
	if (!$result) {
		sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
		print "There was an error retrieving your admin settings. Please <a href=\"mysms_settings.php\">try again</a>.";
	} else {
?>
			<form name="admin_settings" method="post" action="edit_user_confirmation.php">
              <table width="100%"  border="0" align="center" cellpadding="5" cellspacing="1">
<?php
		$current_group = '';
		while ($row = mysql_fetch_assoc($result)) {
			if ($current_group != trim($row['group'])) {
				$current_group = trim($row['group']);
?>
			        <tr bgcolor="#CCCCCC">
			          <td colspan="4" class="textbody"><b><?php print $row['group']; ?></b></td>
			        </tr>
<?php
			}
			switch ($row['type']) {
				case "select":
					$options_sql = "SELECT * FROM configuration_options WHERE configurationid = '{$row['id']}'";
					$options_result = mysql_query($options_sql);
?>
			        <tr bgcolor="#EDEDED">
			          <td class="text1"><b><?php print $row['title']; ?></b></td>
			          <td class="text1"><?php print $row['description']; ?></td>
			          <td width="110" align="center" class="text1"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">
	                    <select name="<?php print "config_".$row['id']; ?>" id="<?php print "config_".$row['id']; ?>">
	                    	<?php
	                    		while ($options = mysql_fetch_assoc($options_result)) {
	                    			if ($options['value'] == $row['value']) {
	                    				print "<option value=\"{$options['value']}\" selected>{$options['name']}</option>\n";
	                    			} else {
	                    				print "<option value=\"{$options['value']}\">{$options['name']}</option>\n";
	                    			}
	                    		}
	                    	?>
	                    </select></font></td>
			          <td width="110" align="center" class="text1">Last Modified: <?php print $row['last_modified']; ?></td>
			        </tr>
<?php
					break;
				case "textarea":
?>
			        <tr bgcolor="#EDEDED">
			          <td class="text1"><b><?php print $row['title']; ?></b></td>
			          <td class="text1"><?php print $row['description']; ?></td>
			          <td width="110" align="center" class="text1"><textarea name="<?php print "config_".$row['id']; ?>" class="uploadinputs"><?php print trim($row['value']); ?></textarea></td>
			          <td width="110" align="center" class="text1">Last Modified: <?php print $row['last_modified']; ?></td>
			        </tr>
<?php
					break;
				case "checkbox":
					$selected = explode(',',$row['value']);
					$options_sql = "SELECT * FROM configuration_options WHERE configurationid = '{$row['id']}'";
					$options_result = mysql_query($options_sql);
?>
			        <tr bgcolor="#EDEDED">
			          <td class="text1"><b><?php print $row['title']; ?></b></td>
			          <td class="text1"><?php print $row['description']; ?></td>
			          <td width="110" align="center" class="text1"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">
	                    <?php
	                    	while ($options = mysql_fetch_assoc($options_result)) {
	                    		if (in_array($options['value'], $selected)) {
	                    			print "<input name=\"config_".$row['id']."[] type=\"checkbox\" value=\"{$options['value']}\" checked> {$options['name']}<br>\n";
	                    		} else {
	                    			print "<input name=\"config_".$row['id']."[] type=\"checkbox\" value=\"{$options['value']}\"> {$options['name']}</option>\n";
	                    		}
	                    	}
	                    ?></font></td>
			          <td width="110" align="center" class="text1">Last Modified: <?php print $row['last_modified']; ?></td>
			        </tr>
<?php
					break;
				case "radio":
					$options_sql = "SELECT * FROM configuration_options WHERE configurationid = '{$row['id']}'";
					$options_result = mysql_query($options_sql);
?>
			        <tr bgcolor="#EDEDED">
			          <td class="text1"><b><?php print $row['title']; ?></b></td>
			          <td class="text1"><?php print $row['description']; ?></td>
			          <td width="110" align="center" class="text1"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">
	                    <?php
	                    	while ($options = mysql_fetch_assoc($options_result)) {
	                    		if ($options['value']== $row['value']) {
	                    			print "<input name=\"config_".$row['id']." type=\"radio\" value=\"{$options['value']}\" checked> {$options['name']}<br>\n";
	                    		} else {
	                    			print "<input name=\"config_".$row['id']." type=\"radio\" value=\"{$options['value']}\"> {$options['name']}</option>\n";
	                    		}
	                    	}
	                    ?></font></td>
			          <td width="110" align="center" class="text1">Last Modified: <?php print $row['last_modified']; ?></td>
			        </tr>
<?php
					break;
				default:
?>
			        <tr bgcolor="#EDEDED">
			          <td class="text1"><b><?php print $row['title']; ?></b></td>
			          <td class="text1"><?php print $row['description']; ?></td>
			          <td width="110" align="center" class="text1"><input type="text" name="<?php print "config_".$row['id']; ?>" class="uploadinputs" value="<?php print $row['value']; ?>"></td>
			          <td width="110" align="center" class="text1">Last Modified: <?php print $row['last_modified']; ?></td>
			        </tr>
<?php
					break;
			}
		}
?>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1" colspan="4">&nbsp;</td>
                </tr>
				<tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1" colspan="4">&nbsp;<input type="hidden" name="user_action" value="save_settings">
                  <input type="submit" name="Submit" value="Save Changes"></td>
                </tr>
              </table>
              </form>
<?php
	}
}
/**
 * @return void
 * @param $info array
 * @desc output edit ftp location form, initialize fields with items from info array
 */
function form_edit_FTP($info) {
	global $FTP_TYPE_ARRAY;
	$target = "edit_ftp_confirmation.php";
?>
			<form name="edit_ftp" method="post" action="<?php print $target; ?>">
              <table width="515"  border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Product:&nbsp;</td>
                  <td><input type="hidden" name="product" value="<?php print $info['product']; ?>"><?php print stripslashes($info['product']); ?>
                  </td>
                </tr>
                <?php /* <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Server:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="server" type="text" class="uploadinputs" value="<?php print stripslashes($info['server']); ?>">
                  </td>
                </tr> */ ?>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Directory:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="directory" type="text" class="uploadinputs" value="<?php print stripslashes($info['directory']); ?>">
                  </td>
                </tr><?php $type = stripslashes($info['type']); ?>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Type:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><select name="type" class="uploadinputs">
                      <option value=""<?php if ($type === "") print " selected"; ?>>Select...</option>
                      <?php
                      	foreach ($FTP_TYPE_ARRAY as $key=>$value) {
                      		print "<option value=\"$value\"";
                      		if ($type === $value) print " selected";
                      		print ">$value</option>\n";
                      	}
                      ?>
                      </select>
                  </td>
                </tr>
                <?php /* <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Username:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="username" type="text" class="uploadinputs" value="<?php print stripslashes($info['username']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Password:&nbsp;</td>
                  <td width="365"><?php print str_repeat("*",strlen($info['password'])+1); ?><input name="password" type="hidden" class="uploadinputs" value="<?php print $info['password']; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">New Password:&nbsp;</td>
                  <td><input name="new_password" type="password" class="uploadinputs" value="<?php print $info['new_password']; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Confirm Password:&nbsp;</td>
                  <td><input name="password1" type="password" class="uploadinputs" value="<?php print $info['password1']; ?>">
                  </td>
                </tr> */ ?>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;<input type="hidden" name="id" value="<?php print $info['id']; ?>"></td>
                  <td>&nbsp;<input type="hidden" name="ftp_action" value="edit"></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td><input type="submit" name="Submit" value="Submit Changes"></td>
                </tr>
              </table>
              </form>
<?php
}
/**
 * @return void
 * @param $info array
 * @desc output delete ftp location confirmation form, initialize fields with items from info array
 */
function form_delete_FTP($info) {
	$target = "edit_ftp_confirmation.php";
?>
			<form name="delete_ftp" method="post" action="<?php print $target; ?>">
              <table width="515"  border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Product:&nbsp;</td>
                  <td><?php print stripslashes($info['product']); ?>
                  </td>
                </tr>
                <?php /* <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Server:&nbsp;</td>
                  <td><?php print stripslashes($info['server']); ?></td>
                </tr> */ ?>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Directory:&nbsp;</td>
                  <td><?php print stripslashes($info['directory']); ?></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Type:&nbsp;</td>
                  <td><?php print stripslashes($info['type']); ?></td>
                </tr>
                <?php /* <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Username:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><?php print stripslashes($info['username']); ?></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Password:&nbsp;</td>
                  <td width="365"><?php print str_repeat("*",strlen($info['password'])+1); ?></td>
                </tr> */ ?>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;<input type="hidden" name="id" value="<?php print $info['id']; ?>"></td>
                  <td>&nbsp;<input type="hidden" name="ftp_action" value="delete"></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td><input type="submit" name="Submit" value="Delete Location">&nbsp;<input type="button" name="Cancel" value="Cancel" onclick="javascript:history.back();"></td>
                </tr>
              </table>
              </form>
<?php
}
/**
 * @return void
 * @param $info array
 * @desc output add ftp location form, initialize fields with items from info array
 */
function form_add_FTP($info="") {
	global $FTP_TYPE_ARRAY;
	$target = "edit_ftp_confirmation.php";
	$edit = is_array($info) ? true : false;
?>
			<form name="add_ftp" method="post" action="<?php print $target; ?>">
              <table width="515"  border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Product:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input type="text" name="product" value="<?php print $edit ? stripslashes($info['product']):""; ?>">
                  </td>
                </tr>
                <?php /*<tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Server:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="server" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['server']):""; ?>">
                  </td>
                </tr>*/ ?>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Directory:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="directory" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['directory']):""; ?>">
                  </td>
                </tr><?php $type = $edit ? stripslashes($info['type']) : ""; ?>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Type:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><select name="type" class="uploadinputs">
                      <option value=""<?php if ($type === "") print " selected"; ?>>Select...</option>
                      <?php
                      	foreach ($FTP_TYPE_ARRAY as $key=>$value) {
                      		print "<option value=\"$value\"";
                      		if ($type === $value) print " selected";
                      		print ">$value</option>\n";
                      	}
                      ?>
                      </select>
                  </td>
                </tr>
                <?php /*<tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Username:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="username" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['username']):""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Password:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td width="365"><input name="password" type="password" class="uploadinputs" value="<?php $edit ? print $info['password']:""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Confirm Password:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="password1" type="password" class="uploadinputs" value="<?php print $edit ? $info['password1']:""; ?>">
                  </td>
                </tr>*/ ?>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td>&nbsp;<input type="hidden" name="ftp_action" value="add"></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td><input type="submit" name="Submit" value="Add Location"></td>
                </tr>
              </table>
              </form>
<?php
}
function fn_progress_bar($intCurrentCount = 100, $intTotalCount = 100) {
	static $intNumberRuns = 0;
	static $intDisplayedCurrentPercent = 0;
	$strProgressBar = '';
	$dblPercentIncrease = (100 / $intTotalCount);
	$intCurrentPercent = intval($intCurrentCount * $dblPercentIncrease);
	$intNumberRuns++;
	if(1 == $intNumberRuns) {
		$strProgressBar = "
<script type='text/javascript' language='javascript'>
document.getElementById('mesg').style.width='50%';
document.getElementById('progress_bar_complete').style.width='0%';
document.getElementById('progress_bar_complete').style.backgroundColor='#CC0000';
document.getElementById('mesg').rows[0].insertCell(1);
document.getElementById('mesg').rows[0].cells[1].style.backgroundColor='#FFFFFF';
document.getElementById('mesg').rows[0].cells[1].innerHTML='&nbsp;';
</script>
";
	} else if($intDisplayedCurrentPercent <> $intCurrentPercent) {
		$intDisplayedCurrentPercent = $intCurrentPercent;
		$strProgressBar = "
<script type='text/javascript' language='javascript'>
dhd_fn_progress_bar_update($intCurrentPercent);
</script>
";
	}
	if(100 <= $intCurrentPercent) {
		$intNumberRuns = $intDisplayedCurrentPercent = 0;
		$strProgressBar = "
<script type='text/javascript' language='javascript'>
document.getElementById('progress_bar_complete').style.backgroundColor='#CC0000';
document.getElementById('progress_bar_complete').innerHTML = '100%';
</script>
";
	}
	echo $strProgressBar;
	flush();
	ob_flush();
}
/**
 * @return void
 * @param $product string
 * @param $sub_dir string
 * @param $userid int
 * @param $info array
 * @desc output software upgrade registration form, initialize fields with items from info array
 */
function form_upgraderegister($product,$sub_dir,$userid,$info="") {
	global $CALIFORNIA_COUNTIES_ARRAY;
	if (is_array($info)) {
		$edit = true;
	} else {
		$edit = false;
		$user = getUser($userid);
	}
?>
<script type="text/javascript" src="/extranet/js/calendarDateInput.js">
/* load calendar script */
</script>
<script language="javascript">
function showhideCounties(){
	frm = document.upgraderegister;
	rw = document.getElementById("countiesrow")
	if(frm.state.options[frm.state.selectedIndex].value == 'CA') {
		rw.style.visibility='visible';
		frm.county.focus();
	} else {
		rw.style.visibility='hidden';
		frm.county.selectedIndex = 0;
		frm.state.focus();
	}
}
</script>
			<form name="upgraderegister" method="post" action="upgrade_registration_confirm.php">
              <table width="515"  border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">First Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="firstname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['firstname']) : stripslashes($user['firstname']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Last Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="lastname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['lastname']) : stripslashes($user['lastname']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Title:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="title" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['title']) : stripslashes($user['title']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Company:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="company" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['company']) : stripslashes($user['company']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="address" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['address']) : stripslashes($user['address']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">City:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="city" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['city']) : stripslashes($user['city']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">State:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">
                  <?php
                  	$state = ($edit) ? stripslashes($info['state']) : stripslashes($user['state']);
                  	showStateSelect("state",$state,"","Select...",'onchange="showhideCounties();"');
                  ?>
                  </font></font>
                  </td>
                </tr><?php $county = $edit ? stripslashes($info['county']) : stripslashes($user['county']); ?>
                <tr bgcolor="#FFFFFF" class="textbody" style="visibility:<?php print (($county === "") && ($state !== "CA")) ? "hidden":"visible"; ?>" id="countiesrow">
                  <td align="left" class="text1">County:&nbsp;<strong><b><font color="#CC0000">*</font></b> </strong></td>
                  <td><select name="county" id="county">
                      <option value=""<?php if ($county === "") print " selected"; ?>>Choose a County</option>
                      <?php
                      	foreach ($CALIFORNIA_COUNTIES_ARRAY as $value) {
                      		print "<option value=\"$value\"";
                      		if ($county === $value) print " selected";
                      		print ">$value</option>\n";
                      	}
                      ?>
                      </select>
    (Shown only if CA selected)</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Zip:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="zip" type="text" size="10" maxlength="10" value="<?php print $edit ? $info['zip'] : stripslashes($user['zip']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Phone:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td>(
                    <input name="phone1" type="text" id="phone1" size="3" maxlength="3" value="<?php print $edit ? $info['phone1'] : stripslashes($user['phone1']); ?>">
) <b><font color="#CC0000">
<input name="phone2" type="text" id="phone2" size="3" maxlength="3" value="<?php print $edit ? $info['phone2'] : stripslashes($user['phone2']); ?>">
</font></b>-
<input name="phone3" type="text" id="phone3" size="4" maxlength="4" value="<?php print $edit ? $info['phone3'] : stripslashes($user['phone3']); ?>">
<font color="#CC0000">&nbsp;</font> Ext.
<input name="phone4" type="text" id="phone4" size="4" maxlength="4" value="<?php print $edit ? $info['phone4'] : stripslashes($user['phone4']); ?>">
<font color="#CC0000">&nbsp;</font>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Alternate Phone:&nbsp;</td>
                  <td>(
                    <input name="alt_phone1" type="text" id="alt_phone1" size="3" maxlength="3" value="<?php print $edit ? $info['alt_phone1'] : ""; ?>">
) <b><font color="#CC0000">
<input name="alt_phone2" type="text" id="alt_phone2" size="3" maxlength="3" value="<?php print $edit ? $info['alt_phone2'] : ""; ?>">
</font></b>-
<input name="alt_phone3" type="text" id="alt_phone3" size="4" maxlength="4" value="<?php print $edit ? $info['alt_phone3'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td valign="top">&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Email Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input type="text" name="email" class="uploadinputs" value="<?php print $edit ? $info['email'] : stripslashes($user['email']); ?>">
                  </td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">&nbsp;</td>
                  <td class="text1">&nbsp;</td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Comments:</td>
                  <td class="text1"><textarea name="comments" rows="5" class="uploadinputs"><?php print $edit ? trim($info['comments']) : ""; ?></textarea></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Date when you plan to&nbsp;<br>
  perform your upgrade?:&nbsp;<font color="#CC0000"><b>* </b></font></td>
                  <td class="text1"><?php 	if ($edit) {
                  								print "<script>DateInput('est_upgrade_date', true, 'MM/DD/YYYY', '{$info['est_upgrade_date']}')</script>";
                 							} else {
                  								print "<script>DateInput('est_upgrade_date', true, 'MM/DD/YYYY')</script>";
                 							} ?>
				  </td>
                </tr><?php $est_upgrade_time = $edit ? stripslashes($info['est_upgrade_time']) : ""; ?>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Approx Time:&nbsp;<font color="#CC0000"><b>* </b></font></td>
                  <td valign="top" class="text1"><select name="est_upgrade_time">
				        <option value=""<?php if ($est_upgrade_time === "") print " selected"; ?>>Start Time</option>
                        <option value="6:00 am"<?php if ($est_upgrade_time === "6:00 am") print " selected"; ?>>6:00 am</option>
                        <option value="7:00 am"<?php if ($est_upgrade_time === "7:00 am") print " selected"; ?>>7:00 am</option>
                        <option value="8:00 am"<?php if ($est_upgrade_time === "8:00 am") print " selected"; ?>>8:00 am</option>
                        <option value="9:00 am"<?php if ($est_upgrade_time === "9:00 am") print " selected"; ?>>9:00 am</option>
                        <option value="10:00 am"<?php if ($est_upgrade_time === "10:00 am") print " selected"; ?>>10:00 am</option>
                        <option value="11:00 am"<?php if ($est_upgrade_time === "11:00 am") print " selected"; ?>>11:00 am</option>
                        <option value="12:00 pm"<?php if ($est_upgrade_time === "12:00 pm") print " selected"; ?>>12:00 pm</option>
                        <option value="1:00 pm"<?php if ($est_upgrade_time === "1:00 pm") print " selected"; ?>>1:00 pm</option>
                        <option value="2:00 pm"<?php if ($est_upgrade_time === "2:00 pm") print " selected"; ?>>2:00 pm</option>
                        <option value="3:00 pm"<?php if ($est_upgrade_time === "3:00 pm") print " selected"; ?>>3:00 pm</option>
                        <option value="4:00 pm"<?php if ($est_upgrade_time === "4:00 pm") print " selected"; ?>>4:00 pm</option>
                        <option value="5:00 pm"<?php if ($est_upgrade_time === "5:00 pm") print " selected"; ?>>5:00 pm</option>
                        <option value="6:00 pm"<?php if ($est_upgrade_time === "6:00 pm") print " selected"; ?>>6:00 pm</option>
                        <option value="7:00 pm"<?php if ($est_upgrade_time === "7:00 pm") print " selected"; ?>>7:00 pm</option>
                        <option value="8:00 pm"<?php if ($est_upgrade_time === "8:00 pm") print " selected"; ?>>8:00 pm</option>
                        <option value="9:00 pm"<?php if ($est_upgrade_time === "9:00 pm") print " selected"; ?>>9:00 pm</option>
                        <option value="10:00 pm"<?php if ($est_upgrade_time === "10:00 pm") print " selected"; ?>>10:00 pm</option>
                        <option value="11:00 pm"<?php if ($est_upgrade_time === "11:00 pm") print " selected"; ?>>11:00 pm</option>
                        <option value="12:00 am"<?php if ($est_upgrade_time === "12:00 am") print " selected"; ?>>12:00 am</option>
                                        </select><?php $est_upgrade_time_zone = $edit ? stripslashes($info['est_upgrade_zone']) : ""; ?>
                  <select name="est_upgrade_time_zone">
                        <option value="Pacific"<?php if (($est_upgrade_time_zone === "") || ($est_upgrade_time === "Pacific"))  print " selected"; ?>>Pacific</option>
                        <option value="Mountain"<?php if ($est_upgrade_time_zone === "Mountain") print " selected"; ?>>Mountain</option>
                        <option value="Central"<?php if ($est_upgrade_time_zone === "Central") print " selected"; ?>>Central</option>
                        <option value="Eastern"<?php if ($est_upgrade_time_zone === "Eastern") print " selected"; ?>>Eastern</option>
                      </select>
</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">&nbsp;</td>
                  <td><span class="text1"><b>SMS Customer Support Hours:</b><br>
                    9:00 a.m. - 8:30 p.m. (Eastern)<br>
                    6:00 a.m. - 5:30 p.m. (Pacific)<br>
                    After Hours Support is available at $150/hr </span></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td colspan="2" align="right" class="text1"><table width="95%"  border="1" align="center" cellpadding="8" cellspacing="0">
                    <tr>
                      <td bgcolor="#FFFFFF" class="text1"><?php include("backup_agreement.php"); ?>
                        <p class="text1">
                          <input type="checkbox" name="backup_agreement" value="Agree">
                        <b>I agree &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b><a href="javascript:printThis();" class="text1">Printer Friendly Version </a></p>
                        <p class="text1">&nbsp;

                        </p></td>
                    </tr>
                  </table></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td><input type="submit" name="Submit" value="Submit Registration"></td>
                </tr>
              </table>
              <input type="hidden" name="product" value="<?php print $product; ?>">
              <input type="hidden" name="sub_dir" value="<?php print $sub_dir; ?>">
              </form>
<?php
}
/**
 * @return void
 * @param $userid int
 * @param $info array
 * @desc output schedule upgrade form, initialize fields with items from info array
 */
function form_scheduleupgrade($userid,$info="") {
	global $CALIFORNIA_COUNTIES_ARRAY;
	if (is_array($info)) {
		$edit = true;
	} else {
		$edit = false;
		$user = getUser($userid);
	}
?>
<script type="text/javascript" src="/extranet/js/calendarDateInput.js">
/* load calendar script */
</script>
<script language="javascript">
function showhideCounties(){
	frm = document.scheduleupgrade;
	rw = document.getElementById("countiesrow")
	if(frm.state.options[frm.state.selectedIndex].value == 'CA') {
		rw.style.visibility='visible';
		frm.county.focus();
	} else {
		rw.style.visibility='hidden';
		frm.county.selectedIndex = 0;
		frm.state.focus();
	}
}
</script>
			<form name="scheduleupgrade" method="post" action="schedule_confirm.php">
              <table width="515"  border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">First Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="firstname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['firstname']) : stripslashes($user['firstname']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Last Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="lastname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['lastname']) : stripslashes($user['lastname']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Title:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="title" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['title']) : stripslashes($user['title']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Company:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="company" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['company']) : stripslashes($user['company']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="address" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['address']) : stripslashes($user['address']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">City:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="city" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['city']) : stripslashes($user['city']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">State:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">
                  <?php
                  	$state = ($edit) ? stripslashes($info['state']) : stripslashes($user['state']);
                  	showStateSelect("state",$state,"","Select...",'onchange="showhideCounties();"');
                  ?>
                  </font></font>
                  </td>
                </tr><?php $county = $edit ? stripslashes($info['county']) : stripslashes($user['county']); ?>
                <tr bgcolor="#FFFFFF" class="textbody" style="visibility:<?php print (($county === "") && ($state !== "CA")) ? "hidden":"visible"; ?>" id="countiesrow">
                  <td align="left" class="text1">County:&nbsp;<strong><b><font color="#CC0000">*</font></b> </strong></td>
                  <td><select name="county" id="county">
                      <option value=""<?php if ($county === "") print " selected"; ?>>Choose a County</option>
                      <?php
                      	foreach ($CALIFORNIA_COUNTIES_ARRAY as $value) {
                      		print "<option value=\"$value\"";
                      		if ($county === $value) print " selected";
                      		print ">$value</option>\n";
                      	}
                      ?>
                      </select>
    (Shown only if CA selected)</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Zip:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="zip" type="text" size="10" maxlength="10" value="<?php print $edit ? $info['zip'] : stripslashes($user['zip']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Phone:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td>(
                    <input name="phone1" type="text" id="phone1" size="3" maxlength="3" value="<?php print $edit ? $info['phone1'] : stripslashes($user['phone1']); ?>">
) <b><font color="#CC0000">
<input name="phone2" type="text" id="phone2" size="3" maxlength="3" value="<?php print $edit ? $info['phone2'] : stripslashes($user['phone2']); ?>">
</font></b>-
<input name="phone3" type="text" id="phone3" size="4" maxlength="4" value="<?php print $edit ? $info['phone3'] : stripslashes($user['phone3']); ?>">
<font color="#CC0000">&nbsp;</font> Ext.
<input name="phone4" type="text" id="phone4" size="4" maxlength="4" value="<?php print $edit ? $info['phone4'] : stripslashes($user['phone4']); ?>">
<font color="#CC0000">&nbsp;</font>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Alternate Phone:&nbsp;</td>
                  <td>(
                    <input name="alt_phone1" type="text" id="alt_phone1" size="3" maxlength="3" value="<?php print $edit ? $info['alt_phone1'] : ""; ?>">
) <b><font color="#CC0000">
<input name="alt_phone2" type="text" id="alt_phone2" size="3" maxlength="3" value="<?php print $edit ? $info['alt_phone2'] : ""; ?>">
</font></b>-
<input name="alt_phone3" type="text" id="alt_phone3" size="4" maxlength="4" value="<?php print $edit ? $info['alt_phone3'] : ""; ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td valign="top">&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Email Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input type="text" name="email" class="uploadinputs" value="<?php print $edit ? $info['email'] : stripslashes($user['email']); ?>">
                  </td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">&nbsp;</td>
                  <td class="text1">&nbsp;</td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Comments:</td>
                  <td class="text1"><textarea name="comments" rows="5" class="uploadinputs"><?php print $edit ? trim($info['comments']) : ""; ?></textarea></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td><input type="submit" name="Submit" value="Submit Registration"></td>
                </tr>
              </table>
              </form>
<?php
}
/**
 * @return void
 * @param $userid int
 * @param $info array
 * @desc output product request form, initialize fields with items from info array
 */
function form_productrequest($userid="",$info="") {
	global $PRODUCT_ARRAY;
	global $CALIFORNIA_COUNTIES_ARRAY;
	if (is_array($info)) {
		$edit = true;
	} else {
		$edit = false;
		if ($userid !== "") {
			$user = getUser($userid);
		} else {
			$user = Array();
		}
	}
?>
<script language="javascript">
function showhideCounties(){
	frm = document.productrequest;
	rw = document.getElementById("countiesrow")
	if(frm.state.options[frm.state.selectedIndex].value == 'CA') {
		rw.style.visibility='visible';
		frm.county.focus();
	} else {
		rw.style.visibility='hidden';
		frm.county.selectedIndex = 0;
		frm.state.focus();
	}
}
</script>
			<form name="productrequest" method="post" action="product_request_confirm.php">
              <table width="515"  border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="79" align="left" class="text1">First Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td width="433"><input name="firstname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['firstname']) : stripslashes($user['firstname']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Last Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="lastname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['lastname']) : stripslashes($user['lastname']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Title:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="title" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['title']) : stripslashes($user['title']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Company:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="company" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['company']) : stripslashes($user['company']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="address" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['address']) : stripslashes($user['address']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="79" align="left" class="text1">City:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="city" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['city']) : stripslashes($user['city']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">State:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">
                  <?php
                  	$state = ($edit) ? stripslashes($info['state']) : stripslashes($user['state']);
                  	showStateSelect("state",$state,"","Select...",'onchange="showhideCounties();"');
                  ?>
                  </font></font>
                  </td>
                </tr><?php $county = $edit ? stripslashes($info['county']) : stripslashes($user['county']); ?>
                <tr bgcolor="#FFFFFF" class="textbody" style="visibility:<?php print (($county === "") && ($state !== "CA")) ? "hidden":"visible"; ?>" id="countiesrow">
                  <td align="left" class="text1">County:&nbsp;<strong><b><font color="#CC0000">*</font></b> </strong></td>
                  <td><select name="county" id="county">
                      <option value=""<?php if ($county === "") print " selected"; ?>>Choose a County</option>
                      <?php
                      	foreach ($CALIFORNIA_COUNTIES_ARRAY as $value) {
                      		print "<option value=\"$value\"";
                      		if ($county === $value) print " selected";
                      		print ">$value</option>\n";
                      	}
                      ?>
                      </select>
    (Shown only if CA selected)</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Zip:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="zip" type="text" size="10" maxlength="10" value="<?php print $edit ? $info['zip'] : stripslashes($user['zip']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Phone:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td>(
                    <input name="phone1" type="text" id="phone1" size="3" maxlength="3" value="<?php print $edit ? $info['phone1'] : stripslashes($user['phone1']); ?>">
) <b><font color="#CC0000">
<input name="phone2" type="text" id="phone2" size="3" maxlength="3" value="<?php print $edit ? $info['phone2'] : stripslashes($user['phone2']); ?>">
</font></b>-
<input name="phone3" type="text" id="phone3" size="4" maxlength="4" value="<?php print $edit ? $info['phone3'] : stripslashes($user['phone3']); ?>">
<font color="#CC0000">&nbsp;</font> Ext.
<input name="phone4" type="text" id="phone4" size="4" maxlength="4" value="<?php print $edit ? $info['phone4'] : stripslashes($user['phone4']); ?>">
<font color="#CC0000">&nbsp;</font>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Fax:&nbsp;</td>
                  <td>(
                    <input name="fax1" type="text" id="fax1" size="3" maxlength="3" value="<?php print $edit ? $info['fax1'] : stripslashes($user['fax1']); ?>">
) <b><font color="#CC0000">
<input name="fax2" type="text" id="fax2" size="3" maxlength="3" value="<?php print $edit ? $info['fax2'] : stripslashes($user['fax2']); ?>">
</font></b>-
<input name="fax3" type="text" id="fax3" size="4" maxlength="4" value="<?php print $edit ? $info['fax3'] : stripslashes($user['fax3']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td valign="top">&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="79" align="left" class="text1">Email:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input type="text" name="email" class="uploadinputs" value="<?php print $edit ? $info['email'] : stripslashes($user['email']); ?>">
                  </td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">&nbsp;</td>
                  <td class="text1">&nbsp;</td>
                </tr>
                 <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td colspan="2" class="text1"><p><br>
                          <strong>I am interested in:</strong></p>
                      <?php
                      	$iaminterestedin = ($edit) ? $info['Iaminterestedin'] : array();
                      	if (!is_array($iaminterestedin)) $iaminterestedin = array();
                      ?>
                      <table width="500" border="0" cellpadding="0" cellspacing="1" class="content">
                        <tr valign="middle" class="textbody">
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="Natural Hazard Disclosure" size="20"<?php if (in_array('Natural Hazard Disclosure',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="230" class="text1">Natural Hazard Disclosure</td>
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="1099 Services" size="20"<?php if (in_array('1099 Services',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="230" class="text1">1099 Services</td>
                        </tr>
                        <tr valign="middle" class="textbody">
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="Transaction Management/e-commerce" size="20"<?php if (in_array('Transaction Management/e-commerce',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="230" class="text1">Transaction Management/e-commerce</td>
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="Release Tracking Services" size="20"<?php if (in_array('Release Tracking Services',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="230" class="text1">Release Tracking Services</td>
                        </tr>
                        <tr valign="middle" class="textbody">
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="PayoffAssist.com" size="20"<?php if (in_array('PayoffAssist.com',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="230" class="text1">PayoffAssist.com</td>
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="Trust Accounting Services" size="20"<?php if (in_array('Trust Accounting Services',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="230" class="text1">Trust Accounting Services</td>
                        </tr>
                        <tr valign="middle" class="textbody">
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="Imaging Solutions" size="20"<?php if (in_array('Imaging Solutions',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="230" class="text1">Imaging Solutions</td>
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="Other" size="20"<?php if (in_array('Other',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="230" class="text1">Other:&nbsp;&nbsp;
                              <input name="Other Interest(s)" type="text" class="inputfield" id="Other Interest(s)2" size="20" value="<?php print $info['Other Interest(s)']; ?>"></td>
                        </tr>
                        <tr valign="middle" class="textbody">
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="Escrow, Closing & Title Production Systems" size="20"<?php if (in_array('Escrow, Closing & Title Production Systems',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="230" class="text1">Escrow, Closing &amp; Title Production Systems</td>
                          <td colspan="2">&nbsp;</td>
                        </tr>
                      </table>
                      <p> <strong>How did you hear about First American SMS?</strong></p>
                      <?php
                      	$referredby = ($edit) ? $info['Referredby'] : array();
                      	if (!is_array($referredby)) $referredby = array();
                       ?>
                      <table width="500" border="0" cellpadding="0" cellspacing="1" class="content">
                        <tr valign="middle">
                          <td width="40"><input name="Referredby[]" type="checkbox" id="Referred by[]" value="Magazine Ad" size="20"<?php if (in_array('Magazine Ad',$referredby)) print " checked"; ?>></td>
                          <td width="507" class="text1">Magazine Ad</td>
                        </tr>
                        <tr valign="middle">
                          <td width="40"><input name="Referredby[]" type="checkbox" id="Referred by[]" value="Web/Email Ad" size="20"<?php if (in_array('Web/Email Ad',$referredby)) print " checked"; ?>></td>
                          <td width="507" class="text1">Web/Email Ad</td>
                        </tr>
                        <tr valign="middle">
                          <td width="40"><input name="Referredby[]" type="checkbox" id="Referred by[]" value="Web Search" size="20"<?php if (in_array('Web Search',$referredby)) print " checked"; ?>></td>
                          <td width="507" class="text1">Web Search</td>
                        </tr>
                        <tr valign="middle">
                          <td width="40"><input name="Referredby[]" type="checkbox" id="Referred by[]" value="Customer Referral" size="20"<?php if (in_array('Customer Referral',$referredby)) print " checked"; ?>></td>
                          <td width="507" class="text1">Customer Referral:&nbsp;&nbsp;
                              <input name="Customer Referral Name" type="text" class="inputfield" id="Customer Referral Name" size="20" value="<?php print $info['Customer Referral Name']; ?>"></td>
                        </tr>
                        <tr valign="middle">
                          <td width="40"><input name="Referredby[]" type="checkbox" id="Referred by[]" value="Other" size="20"<?php if (in_array('Other',$referredby)) print " checked"; ?>></td>
                          <td width="507" class="text1">Other:&nbsp;&nbsp;
                              <input name="Other Referral" type="text" class="inputfield" id="Other Referral" size="20" value="<?php print $info['Other Referral']; ?>"></td>
                        </tr>
                      </table></td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">&nbsp;</td>
                  <td class="text1">&nbsp;</td>
                </tr>
               <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td colspan="2" align="left" class="text1">Additional Comments/Information:</td>
                </tr>
               <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td colspan="2" class="text1"><textarea name="comments" cols="50" rows="5" class="uploadinputs"><?php print $edit ? trim($info['comments']) : ""; ?></textarea></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td><input type="submit" name="Submit" value="Submit Request"></td>
                </tr>
              </table>
              </form>
<?php
}
/**
 * @return void
 * @param $userid int
 * @param $info array
 * @desc output join mailing list form, initialize fields with items from info array
 */
function form_mailinglist($userid="",$info="") {
	global $PRODUCT_ARRAY;
	global $CALIFORNIA_COUNTIES_ARRAY;
	if (is_array($info)) {
		$edit = true;
	} else {
		$edit = false;
		if ($userid !== "") {
			$user = getUser($userid);
		} else {
			$user = Array();
		}
	}
?>
<script language="javascript">
function showhideCounties(){
	frm = document.mailinglist;
	rw = document.getElementById("countiesrow")
	if(frm.state.options[frm.state.selectedIndex].value == 'CA') {
		rw.style.visibility='visible';
		frm.county.focus();
	} else {
		rw.style.visibility='hidden';
		frm.county.selectedIndex = 0;
		frm.state.focus();
	}
}
</script>
			<form name="mailinglist" method="post" action="mailing_list_confirm.php">
              <table width="515"  border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="79" align="left" class="text1">First Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td width="433"><input name="firstname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['firstname']) : stripslashes($user['firstname']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Last Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="lastname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['lastname']) : stripslashes($user['lastname']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Title:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="title" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['title']) : stripslashes($user['title']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Company:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="company" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['company']) : stripslashes($user['company']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="address" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['address']) : stripslashes($user['address']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="79" align="left" class="text1">City:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="city" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['city']) : stripslashes($user['city']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">State:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">
                  <?php
                  	$state = ($edit) ? stripslashes($info['state']) : stripslashes($user['state']);
                  	showStateSelect("state",$state,"","Select...",'onchange="showhideCounties();"');
                  ?>
                  </font></font>
                  </td>
                </tr><?php $county = $edit ? stripslashes($info['county']) : stripslashes($user['county']); ?>
                <tr bgcolor="#FFFFFF" class="textbody" style="visibility:<?php print (($county === "") && ($state !== "CA")) ? "hidden":"visible"; ?>" id="countiesrow">
                  <td align="left" class="text1">County:&nbsp;<strong><b><font color="#CC0000">*</font></b> </strong></td>
                  <td><select name="county" id="county">
                      <option value=""<?php if ($county === "") print " selected"; ?>>Choose a County</option>
                      <?php
                      	foreach ($CALIFORNIA_COUNTIES_ARRAY as $value) {
                      		print "<option value=\"$value\"";
                      		if ($county === $value) print " selected";
                      		print ">$value</option>\n";
                      	}
                      ?>
                      </select>
    (Shown only if CA selected)</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Zip:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="zip" type="text" size="10" maxlength="10" value="<?php print $edit ? $info['zip'] : stripslashes($user['zip']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Phone:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td>(
                    <input name="phone1" type="text" id="phone1" size="3" maxlength="3" value="<?php print $edit ? $info['phone1'] : stripslashes($user['phone1']); ?>">
) <b><font color="#CC0000">
<input name="phone2" type="text" id="phone2" size="3" maxlength="3" value="<?php print $edit ? $info['phone2'] : stripslashes($user['phone2']); ?>">
</font></b>-
<input name="phone3" type="text" id="phone3" size="4" maxlength="4" value="<?php print $edit ? $info['phone3'] : stripslashes($user['phone3']); ?>">
<font color="#CC0000">&nbsp;</font> Ext.
<input name="phone4" type="text" id="phone4" size="4" maxlength="4" value="<?php print $edit ? $info['phone4'] : stripslashes($user['phone4']); ?>">
<font color="#CC0000">&nbsp;</font>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Fax:&nbsp;</td>
                  <td>(
                    <input name="fax1" type="text" id="fax1" size="3" maxlength="3" value="<?php print $edit ? $info['fax1'] : stripslashes($user['fax1']); ?>">
) <b><font color="#CC0000">
<input name="fax2" type="text" id="fax2" size="3" maxlength="3" value="<?php print $edit ? $info['fax2'] : stripslashes($user['fax2']); ?>">
</font></b>-
<input name="fax3" type="text" id="fax3" size="4" maxlength="4" value="<?php print $edit ? $info['fax3'] : stripslashes($user['fax3']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td valign="top">&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="79" align="left" class="text1">Email:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input type="text" name="email" class="uploadinputs" value="<?php print $edit ? $info['email'] : stripslashes($user['email']); ?>">
                  </td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">&nbsp;</td>
                  <td class="text1">&nbsp;</td>
                </tr>
                 <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td colspan="2" class="text1"><p><br>
                          <strong>I am interested in:</strong></p>
                          <?php
                          $iaminterestedin = ($edit) ? $info['Iaminterestedin'] : array();
                          if (!is_array($iaminterestedin)) $iaminterestedin = array();
                          ?>
                      <table width="500" border="0" cellpadding="0" cellspacing="1" class="content">
                        <tr valign="middle" class="textbody">
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="Natural Hazard Disclosure" size="20"<?php if (in_array('Natural Hazard Disclosure',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="280" class="text1">Natural Hazard Disclosure</td>
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="1099 Services" size="20"<?php if (in_array('1099 Services',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="230" class="text1">1099 Services</td>
                        </tr>
                        <tr valign="middle" class="textbody">
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="Transaction Management/e-commerce" size="20"<?php if (in_array('Transaction Management/e-commerce',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="280" class="text1">Transaction Management/e-commerce</td>
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="Release Tracking Services" size="20"<?php if (in_array('Release Tracking Services',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="230" class="text1">Release Tracking Services</td>
                        </tr>
                        <tr valign="middle" class="textbody">
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="PayoffAssist.com" size="20"<?php if (in_array('PayoffAssist.com',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="280" class="text1">PayoffAssist.com</td>
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="Trust Accounting Services" size="20"<?php if (in_array('Trust Accounting Services',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="230" class="text1">Trust Accounting Services</td>
                        </tr>
                        <tr valign="middle" class="textbody">
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="Imaging Solutions" size="20"<?php if (in_array('Imaging Solutions',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="280" class="text1">Imaging Solutions</td>
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="Other" size="20"<?php if (in_array('Other',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="230" class="text1">Other:&nbsp;&nbsp;
                              <input name="Other Interest(s)" type="text" class="inputfield" id="Other Interest(s)2" size="20" value="<?php print $info['Other Interest(s)']; ?>"></td>
                        </tr>
                        <tr valign="middle" class="textbody">
                          <td width="40"><input name="Iaminterestedin[]" type="checkbox" id="Iaminterestedin[]" value="Escrow, Closing &amp; Title Production Systems" size="20"<?php if (in_array('Escrow, Closing &amp; Title Production Systems',$iaminterestedin)) print " checked"; ?>></td>
                          <td width="280" class="text1">Escrow, Closing &amp; Title Production Systems</td>
                          <td colspan="2">&nbsp;</td>
                        </tr>
                      </table>
                      <p> <strong>How did you hear about First American SMS?</strong></p>
                      <?php
                      	$referredby = ($edit) ? $info['Referredby'] : array();
                      	if (!is_array($referredby)) $referredby = array();
                      ?>
                      <table width="500" border="0" cellpadding="0" cellspacing="1" class="content">
                        <tr valign="middle">
                          <td width="40"><input name="Referredby[]" type="checkbox" id="Referred by[]" value="Magazine Ad" size="20"<?php if (in_array('Magazine Ad',$referredby)) print " checked"; ?>></td>
                          <td width="507" class="text1">Magazine Ad</td>
                        </tr>
                        <tr valign="middle">
                          <td width="40"><input name="Referredby[]" type="checkbox" id="Referred by[]" value="Web/Email Ad" size="20"<?php if (in_array('Web/Email Ad',$referredby)) print " checked"; ?>></td>
                          <td width="507" class="text1">Web/Email Ad</td>
                        </tr>
                        <tr valign="middle">
                          <td width="40"><input name="Referredby[]" type="checkbox" id="Referred by[]" value="Web Search" size="20"<?php if (in_array('Web Search',$referredby)) print " checked"; ?>></td>
                          <td width="507" class="text1">Web Search</td>
                        </tr>
                        <tr valign="middle">
                          <td width="40"><input name="Referredby[]" type="checkbox" id="Referred by[]" value="Customer Referral" size="20"<?php if (in_array('Customer Referral',$referredby)) print " checked"; ?>></td>
                          <td width="507" class="text1">Customer Referral:&nbsp;&nbsp;
                              <input name="Customer Referral Name" type="text" class="inputfield" id="Customer Referral Name" size="20" value="<?php print $info['Customer Referral Name']; ?>"></td>
                        </tr>
                        <tr valign="middle">
                          <td width="40"><input name="Referredby[]" type="checkbox" id="Referred by[]" value="Other" size="20"<?php if (in_array('Other',$referredby)) print " checked"; ?>></td>
                          <td width="507" class="text1">Other:&nbsp;&nbsp;
                              <input name="Other Referral" type="text" class="inputfield" id="Other Referral" size="20" value="<?php print $info['Other Referral']; ?>"></td>
                        </tr>
                      </table></td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">&nbsp;</td>
                  <td class="text1">&nbsp;</td>
                </tr>
               <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td colspan="2" align="left" class="text1">Additional Comments/Information:</td>
                </tr>
               <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td colspan="2" class="text1"><textarea name="comments" cols="50" rows="5" class="uploadinputs"><?php print $edit ? trim($info['comments']) : ""; ?></textarea></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td><input type="submit" name="Submit" value="Submit Request"></td>
                </tr>
              </table>
              </form>
<?php
}
/**
 * @return void
 * @param $userid int
 * @param $info array
 * @desc output software change request form, initialize fields with items from info array
 */
function form_changerequest($userid='',$info="") {
	global $PRODUCT_ARRAY;
	global $CALIFORNIA_COUNTIES_ARRAY;
	if (is_array($info)) {
		$edit = true;
	} else {
		$edit = false;
		if ($userid !== "") {
			$user = getUser($userid);
		} else {
			$user = Array();
		}
	}
	if (!session_id()) {
		$sid = md5(uniqid(rand()));
	} else {
		$sid = session_id();
	}
?>
<script language="javascript">
function showhideCounties(){
	frm = document.changerequest;
	rw = document.getElementById("countiesrow")
	if(frm.state.options[frm.state.selectedIndex].value == 'CA') {
		rw.style.visibility='visible';
		frm.county.focus();
	} else {
		rw.style.visibility='hidden';
		frm.county.selectedIndex = 0;
		frm.state.focus();
	}
}
</script>
			<!--<form name="changerequest" method="post" action="change_request_confirm.php" enctype="multipart/form-data">-->
			<form name="changerequest" method="POST" action="/cgi-bin/upload.cgi?sid=<? echo $sid; ?>" enctype="multipart/form-data">
              <table width="515"  border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">First Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td width="365"><input name="firstname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['firstname']) : stripslashes($user['firstname']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Last Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="lastname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['lastname']) : stripslashes($user['lastname']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Title:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="title" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['title']) : stripslashes($user['title']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Company:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="company" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['company']) : stripslashes($user['company']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="address" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['address']) : stripslashes($user['address']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">City:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="city" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['city']) : stripslashes($user['city']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">State:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">
                  <?php
                  	$state = ($edit) ? stripslashes($info['state']) : stripslashes($user['state']);
                  	showStateSelect("state",$state,"","Select...",'onchange="showhideCounties();"');
                  ?>
                  </font></font>
                  </td>
                </tr><?php $county = $edit ? stripslashes($info['county']) : stripslashes($user['county']); ?>
                <tr bgcolor="#FFFFFF" class="textbody" style="visibility:<?php print (($county === "") && ($state !== "CA")) ? "hidden":"visible"; ?>" id="countiesrow">
                  <td align="left" class="text1">County:&nbsp;<strong><b><font color="#CC0000">*</font></b> </strong></td>
                  <td><select name="county" id="county">
                      <option value=""<?php if ($county === "") print " selected"; ?>>Choose a County</option>
                      <?php
                      	foreach ($CALIFORNIA_COUNTIES_ARRAY as $value) {
                      		print "<option value=\"$value\"";
                      		if ($county === $value) print " selected";
                      		print ">$value</option>\n";
                      	}
                      ?>
                      </select>
    (Shown only if CA selected)</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Zip:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="zip" type="text" size="10" maxlength="10" value="<?php print $edit ? $info['zip'] : stripslashes($user['zip']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Phone:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td>(
                    <input name="phone1" type="text" id="phone1" size="3" maxlength="3" value="<?php print $edit ? $info['phone1'] : stripslashes($user['phone1']); ?>">
) <b><font color="#CC0000">
<input name="phone2" type="text" id="phone2" size="3" maxlength="3" value="<?php print $edit ? $info['phone2'] : stripslashes($user['phone2']); ?>">
</font></b>-
<input name="phone3" type="text" id="phone3" size="4" maxlength="4" value="<?php print $edit ? $info['phone3'] : stripslashes($user['phone3']); ?>">
<font color="#CC0000">&nbsp;</font> Ext.
<input name="phone4" type="text" id="phone4" size="4" maxlength="4" value="<?php print $edit ? $info['phone4'] : stripslashes($user['phone4']); ?>">
<font color="#CC0000">&nbsp;</font>
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Fax:&nbsp;</td>
                  <td>(
                    <input name="fax1" type="text" id="fax1" size="3" maxlength="3" value="<?php print $edit ? $info['fax1'] : stripslashes($user['fax1']); ?>">
) <b><font color="#CC0000">
<input name="fax2" type="text" id="fax2" size="3" maxlength="3" value="<?php print $edit ? $info['fax2'] : stripslashes($user['fax2']); ?>">
</font></b>-
<input name="fax3" type="text" id="fax3" size="4" maxlength="4" value="<?php print $edit ? $info['fax3'] : stripslashes($user['fax3']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td valign="top">&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Email Address:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input type="text" name="email" class="uploadinputs" value="<?php print $edit ? $info['email'] : stripslashes($user['email']); ?>">
                  </td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">&nbsp;</td>
                  <td class="text1">&nbsp;</td>
                </tr>
                <tr class="textbody">
                  <td align="left" class="text1">Product/Service:&nbsp;<b><font color="#CC0000">*</font></b></td>
                  <td>
                  <?php
                  	$product = ($edit) ? stripslashes($info['product']) : stripslashes($_SESSION['default_product']);
                  	showProductSelectFiltered("product",$product,"uploadinputs","Select...",'',true,array('VISION', 'Image-Pro', 'Trust32', 'GreenFolders', 'DocNet'));
                  ?></td>
                </tr>
                <tr class="textbody">
                  <td align="left" class="text1">If Other, please specify:&nbsp;</td>
                  <td><input name="other_product" type="text" class="uploadinputs" value="<?php print $edit ? trim($info['other_product']) : ""; ?>">
                  </td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">&nbsp;</td>
                  <td class="text1">&nbsp;</td>
                </tr>
               <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Please describe the enhancement or correction<br>that you would like to see:&nbsp;</td>
                  <td class="text1"><textarea name="comments" cols="30" rows="5" class="uploadinputs2"><?php print $edit ? trim($info['comments']) : ""; ?></textarea></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr valign="top" class="textbody">
                  <td align="left" class="text1">Attach extra pages,&nbsp;screen prints or form&nbsp;
  samples, if necessary:&nbsp;</td>
                  <td class="text1"><?php print "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"".intval((1024*1024)*MAXIMUM_UPLOAD_FILE_SIZE)."\">"; ?>
                  <input type="file" name="attachment" class="uploadinputs" id="attachment"><br>
                  <?php print "(max file size: ".MAXIMUM_UPLOAD_FILE_SIZE." Mb)"; ?></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <!--<td><input type="submit" name="Submit" value="Submit Request"></td>-->
                  <td><?php if (!session_id()) { ?>
                  	<input type="hidden" name="page" value="/public/feedback/change_request_confirm.php">
                   	<?php	} else { ?>
                  	<input type="hidden" name="page" value="/extranet/feedback/change_request_confirm.php">
                   	<?php	} ?>
                  	<input type="hidden" name="sessionid" value="<?php print $sid; ?>">
                   	<input type="button" value="Submit" onClick="postIt(this.form);"></td>
                </tr>
              </table>
              </form>
<?php
}
/**
 * @return void
 * @param $userid int
 * @param $info array
 * @desc output software change request form, initialize fields with items from info array
 */
function form_uploaddocuments($userid,$info="") {
	global $PRODUCT_ARRAY;
	global $CALIFORNIA_COUNTIES_ARRAY;
	if (is_array($info)) {
		$edit = true;
	} else {
		$edit = false;
		if ($userid !== "") {
			$user = getUser($userid);
		} else {
			$user = Array();
		}
	}
	$sid = session_id();
?>
<script language="javascript">
function showhideCounties(){
	frm = document.uploaddocuments;
	rw = document.getElementById("countiesrow")
	if(frm.state.options[frm.state.selectedIndex].value == 'CA') {
		rw.style.visibility='visible';
		frm.county.focus();
	} else {
		rw.style.visibility='hidden';
		frm.county.selectedIndex = 0;
		frm.state.focus();
	}
}
</script>
			<!--<form name="changerequest" method="post" action="change_request_confirm.php" enctype="multipart/form-data">-->
			<form name="uploaddocuments" method="POST" action="/cgi-bin/upload.cgi?sid=<? echo $sid; ?>" enctype="multipart/form-data">
              <table width="515"  border="0" cellspacing="0" cellpadding="0">
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Your First Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td width="365"><input name="firstname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['firstname']) : stripslashes($user['firstname']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Your Last Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="lastname" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['lastname']) : stripslashes($user['lastname']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Your Company Name:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input name="company" type="text" class="uploadinputs" value="<?php print $edit ? stripslashes($info['company']) : stripslashes($user['company']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">State:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><font color="#FFFFFF" face="Arial, Helvetica, sans-serif"><font color="#FFFFFF" face="Arial, Helvetica, sans-serif">
                  <?php
                  	$state = ($edit) ? stripslashes($info['state']) : stripslashes($user['state']);
                  	showStateSelect("state",$state,"","Select...",'onchange="showhideCounties();"');
                  ?>
                  </font></font>
                  </td>
                </tr><?php $county = $edit ? stripslashes($info['county']) : stripslashes($user['county']); ?>
                <tr bgcolor="#FFFFFF" class="textbody" style="visibility:<?php print (($county === "") && ($state !== "CA")) ? "hidden":"visible"; ?>" id="countiesrow">
                  <td align="left" class="text1">County:&nbsp;<strong><b><font color="#CC0000">*</font></b> </strong></td>
                  <td><select name="county" id="county">
                      <option value=""<?php if ($county === "") print " selected"; ?>>Choose a County</option>
                      <?php
                      	foreach ($CALIFORNIA_COUNTIES_ARRAY as $value) {
                      		print "<option value=\"$value\"";
                      		if ($county === $value) print " selected";
                      		print ">$value</option>\n";
                      	}
                      ?>
                      </select>
    (Shown only if CA selected)</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td width="150" align="left" class="text1">Your Email:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td><input type="text" name="email" class="uploadinputs" value="<?php print $edit ? $info['email'] : stripslashes($user['email']); ?>">
                  </td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td valign="top">&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Your Phone No:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td>(
                    <input name="phone1" type="text" id="phone1" size="3" maxlength="3" value="<?php print $edit ? $info['phone1'] : stripslashes($user['phone1']); ?>">
) <b><font color="#CC0000">
<input name="phone2" type="text" id="phone2" size="3" maxlength="3" value="<?php print $edit ? $info['phone2'] : stripslashes($user['phone2']); ?>">
</font></b>-
<input name="phone3" type="text" id="phone3" size="4" maxlength="4" value="<?php print $edit ? $info['phone3'] : stripslashes($user['phone3']); ?>">
<font color="#CC0000">&nbsp;</font> Ext.
<input name="phone4" type="text" id="phone4" size="4" maxlength="4" value="<?php print $edit ? $info['phone4'] : stripslashes($user['phone4']); ?>">
<font color="#CC0000">&nbsp;</font>
                  </td>
                </tr>
                <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">&nbsp;</td>
                  <td class="text1">&nbsp;</td>
                </tr>
                <tr valign="top" class="textbody">
                  <td align="left" class="text1">Attach Document:&nbsp;<b><font color="#CC0000">* </font></b></td>
                  <td class="text1"><?php print "<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"".intval((1024*1024)*MAXIMUM_UPLOAD_FILE_SIZE)."\">"; ?>
                  <input type="file" name="attachment" class="uploadinputs" id="attachment"><br>
                  <?php print "(max file size: ".MAXIMUM_UPLOAD_FILE_SIZE." Mb)"; ?></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
               <tr valign="top" bgcolor="#FFFFFF" class="textbody">
                  <td align="left" class="text1">Comments:&nbsp;</td>
                  <td class="text1"><textarea name="comments" cols="30" rows="5" class="uploadinputs2"><?php print $edit ? trim($info['comments']) : ""; ?></textarea></td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr bgcolor="#FFFFFF" class="textbody">
                  <td align="left" valign="top" class="text1">&nbsp;</td>
                  <!--<td><input type="submit" name="Submit" value="Submit Request"></td>-->
                  <td><input type="hidden" name="page" value="/extranet/implementation/upload_confirm.php">
                  	<input type="hidden" name="sessionid" value="<?php print $sid; ?>">
                   	<input type="button" value="Submit Document" onClick="postIt(this.form);"></td>
                </tr>
              </table>
              <!--<input type="hidden" name=userid value='<?=$_SESSION['userid'];?>'>-->
              </form>
<?php
}
?>