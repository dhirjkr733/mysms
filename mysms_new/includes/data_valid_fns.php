<?php
/**
 * @return string
 * @param password string
 * @param account string
 * @desc check for valid strong password. returns description of error if failed. returns empty string on success
 */
function valid_password($password,$account) {
  /* password must meet the following criteria:
  length > 8
  not used before
  not contain 3 or more consecutive letters from user account name
  use characters from 3 of the 5 following groups:
  	1. lowercase letters
  	2. uppercase letters
  	3. numbers (for instance, 1, 2, 3)
  	4. symbols (for instance, @, =, -, and so on
  	5. unicode characters
  */

  //check for spaces
  if (preg_match('/\s/',$password)) {
  	$failed = "Your password may not contain spaces.<br><br>\n";
  	return $failed; 	
  } 
  //check length > 8
  if (strlen($password) < 8) {
  	$failed = "Your password must be a minimum of 8 characters in length.<br><br>\n";
  	return $failed; 	
  } 
  //check not used before
  db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
  $sql = "SELECT pl.password 
  			FROM password_log as pl,users as u 
  			WHERE pl.usersid = u.id 
  				AND u.email LIKE ".quote_smart($account)." 
  				AND pl.password = ENCODE('$password','".SALT."')";
  $result = mysql_query($sql) or die ("Line ".__LINE__." in ".__FILE__.": ".mysql_error());
  $rec_count = @mysql_num_rows($result);
  if ($rec_count > 0) {
  	$failed = "Password reuse is prohibited. Please choose another password.<br><br>\n";
  	return $failed;
  }
  //check not contain 3 or more consecutive letters from user account name
  $ckstr_length = strlen($account) - 2;
  for($i=0;$i<$ckstr_length;$i++) {
  	$substr = substr($account,$i,$i+3);
  	$pos = strpos($password,$substr);
  	if ($pos !== false) {
  		$failed = "Password may not contain 3 or more consecutive letters from email address.<br><br>\n";
  		return $failed;
  	}
  }
  //check for use characters from 3 of the 5 groups:
  $count = 0;
  if (preg_match('/[0-9]/',$password)) {
  	$count++;
  }
  if (preg_match('/[a-z]/',$password)) {
  	$count++;
  }
  if (preg_match('/[A-Z]/',$password)) {
  	$count++;
  }
  if (preg_match('/[~`!@#\$%\^&\*\(\)\-_=\+\[\]\{\}\|;:<>\.\?\/,\\\'\"]+/',$password)) {
  	$count++;
  }   	
  if ($count < 3) {
  	$failed = "Password must contain at least one letter, at least one number, and one of the following special characters ! @ # $ % ^ & * ( ) _ <br><br>\n";
    return $failed;
  }
  // still here, must have passed (false means no errors)
  $passed = '';
  return $passed;
}
/**
 * @return bool
 * @param address string
 * @desc check for valid email address
 */
function valid_email($address) {

  if (ereg("^[a-zA-Z0-9_\.\-]+@[a-zA-Z0-9\-]+\.[a-zA-Z0-9\-\.]+$", $address))
    return true;
  else 
    return false;
}
/**
 * @return bool
 * @param zip string
 * @desc check for valid 5 digit or zip+4 zip code
 */
function valid_zip($zip) {

  if ((ereg("^[0-9]{5}$", $zip)) || (ereg("^[0-9]{5}\-[0-9]{4}$", $zip)))
    return true;
  else 
    return false;
}
/**
 * @return bool
 * @param number string
 * @desc strip field of all chars except 0-9 and check for valid phone number
 */
function valid_phone($number) {
	$temp = ereg_replace( "[^0-9X]", "", $number); 
	$ext = strpos($temp,"X");
	if ($ext === false) {
		//no extension
		$reg_exp = "^[0-9]{10}$";
	} else {
		$reg_exp = "^[0-9]{10}X[0-9]{1,4}$";
	}
	if (ereg($reg_exp,$temp)) {
		return true;
	} else {
		return false;
	}
}
/**
 * @return string
 * @param fieldname string
 * @desc concatenates post variables fieldname1, fieldname2..fieldname4 into phone number plus optional extension in the format 123-456-7890X12345
 */
function fix_phone_in($fieldname)  {
	
	$result = trim($_POST["$fieldname"."1"]) . "-" . trim($_POST["$fieldname"."2"]) . "-" . trim($_POST["$fieldname"."3"]);
	//check for extension, add if present
	if (isset($_POST["$fieldname"."4"])) {
		$ext = trim($_POST["$fieldname"."4"]);
	} else {
		$ext = "";
	}
	if ($ext !== "") $result .= "X$ext";
	return $result;
}
/**
 * @return string
 * @param number string
 * @desc formats phone number for output
 */
function fix_phone_out($number)  {
	$temp = ereg_replace( "[^0-9X]", "", $number);
	$ext = strpos($temp,"X");
	if ($ext === false) {
		//no extension
		$result = "(".substr($temp, 0, 3).") ".substr($temp, 3, 3)."-".substr($temp, 6, 4);
	} else {
		$result = "(".substr($temp, 0, 3).") ".substr($temp, 3, 3)."-".substr($temp, 6, 4)." Ext. ".substr($temp, $ext+1);
	}
	return $result;
}
/**
 * @return string
 * @param fieldname string
 * @desc explodes phone number field from database into 3 element array, 4 elements if extension present
 */
function fix_phone_from_db($number)  {
	
	$temp = ereg_replace( "[^0-9X]", "", $number);
	unset($result);
	$ext = strpos($temp,"X");
	$result[] = substr($temp, 0, 3);
	$result[] = substr($temp, 3, 3);
	$result[] = substr($temp, 6, 4);
	if ($ext !== false) {
		$result[] = substr($temp, $ext+1);
	}
	return $result;
}
/**
 * @return unknown
 * @param string string
 * @param components int
 * @param $error int
 * @param $cleaned array
 * @desc $string is absolute or relative URI to validate, components needed to consider valid, $error and $cleaned passed by reference indicating the missing components and the cleaned components of the URI
 */
function is_url($string, $components, &$error, &$cleaned) {
	  
	$error = 0; 
	// first clear error variable  
	$_error = 0;
	
	$ret = ereg("^(([^:/?#]+):)?(//([^/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?", $string, $regs);
	// return false if we were not even able to parse uri  
	if (!$ret) return false; 
	
	// check the seperate parts  
	if (empty($regs[2])) $_error += SCHEME;  
	if (empty($regs[4])) $_error += AUTHORITY;  
	if (!empty($regs[4]) and strcmp($regs[2], 'http') == 0) {
		// do we have an ok hostname?   
		if (!ereg("((([a-z0-9]+)[a-z0-9_]¦\\-)+\\.)+".// subdomain + domain
		    "[a-z]{2,4}".// TLD    ":?[0-9]{0,5}$",// port    
		    $regs[4])) {    
		    	$_error += AUTHORITY_WF;   
		}  
	}  
	if (empty($regs[5])) $_error += PATH;  
	if (empty($regs[7])) $_error += QUERY;  
	if (empty($regs[9])) $_error += FRAGMENT; 
	if ($cleaned!= '') {   
		$cleaned['scheme'] = $regs[2];   
		$cleaned['authority'] = $regs[4];   
		$cleaned['path'] = preg_replace("{[^-/:@&=+$,_.!~*()'a-zA-Z0-9]}", '', $regs[5]);   
		$cleaned['query'] = preg_replace("{[^-;/?:@&=+$,_.!~*'()A-Za-z0-9%]}", '', urlencode_querystring($regs[7]));   
		$cleaned['fragment'] = preg_replace("{[^-;/?:@&=+$,_.!~*'()A-Za-z0-9%]}", '', urlencode($regs[9]));
	} 
	foreach (array(SCHEME, AUTHORITY, AUTHORITY_WF, PATH, QUERY, FRAGMENT) as $comp) {   
		if ($components & $comp and $_error & $comp) $error += $comp;  
	} 
	if ($error > 0) {   
		$error = $_error;   
		return false;  
	}  
	$error = $_error;  
	return true; 
}
/**
 * @return string
 * @param rel_uri string
 * @param base string
 * @param REMOVE_LEADING_DOTS bool[optional]
 * @desc trasnsform relative uri to absolute uri
 */
function make_abs($rel_uri, $base, $REMOVE_LEADING_DOTS = true) {  
	preg_match("'^([^:]+://[^/]+)/'", $base, $m);  
	$base_start = $m[1];  
	if (preg_match("'^/'", $rel_uri)) {   
		return $base_start . $rel_uri;  
	}  
	$base = preg_replace("{[^/]+$}", '', $base);  
	$base .= $rel_uri;  
	$base = preg_replace("{^[^:]+://[^/]+}", '', $base);  
	$base_array = explode('/', $base);  
	if (count($base_array) and !strlen($base_array[0]))   
		array_shift($base_array);  
	$i = 1;  
	while ($i < count($base_array)) {   
		if ($base_array[$i - 1] == ".") {    
			array_splice($base_array, $i - 1, 1);    
			if ($i > 1) $i--;   
		} 
		elseif ($base_array[$i] == ".." and $base_array[$i - 1]!= "..") {    
			array_splice($base_array, $i - 1, 2);    
			if ($i > 1) { 
				$i--; 
				if ($i == count($base_array)) array_push($base_array, "");    
			}   
		} 
		else {    
			$i++;   
		}  
	}  
	if (count($base_array) and $base_array[-1] == ".")   
		$base_array[-1] = "";  
	/* How do we treat the case where there are still some leading ../
	   segments left? According to RFC2396 we are free to handle that
	   any way we want. The default is to remove them.
#    
		"If the resulting buffer string still begins with one or more
		complete path segments of "..", then the reference is considered    
		to be in error. Implementations may handle this error by    
		retaining these components in the resolved path (i.e., treating    
		them as part of the final URI), by removing them from the    
		resolved path (i.e., discarding relative levels above the root),    
		or by avoiding traversal of the reference." 
#    
		http://www.faqs.org/rfcs/rfc2396.html  5.2.6.g  
	*/  
	if ($REMOVE_LEADING_DOTS) {   
		while (count($base_array) and preg_match("/^\.\.?$/", $base_array[0])) {    
			array_shift($base_array);   
		}  
	}  
	return($base_start . '/' . implode("/", $base_array)); 
}
/**
 * @return string
 * @param parsed array
 * @desc glues together uri parsed by is_url
 */
function make_uri($parsed) { 
  
  	if (!is_array($parsed)) return false;

  	if (isset($parsed['scheme'])) {
     	$sep = (strtolower($parsed['scheme']) == 'mailto' ? ':' : '://');
     	$uri = $parsed['scheme'] . $sep;
  	} 
  	else {
     	$uri = '';
  	}

  	if (isset($parsed['pass'])) {
     	$uri .= "$parsed[user]:$parsed[pass]@";
  	} 
  	elseif (isset($parsed['user'])) {
     	$uri .= "$parsed[user]@";
  	}
 
  	if (isset($parsed['authority']))     $uri .= $parsed['host'];
  	if (isset($parsed['port']))     $uri .= ":$parsed[port]";
  	if (isset($parsed['path']))     $uri .= $parsed['path'];
 	if (isset($parsed['query']))    $uri .= "?$parsed[query]";
  	if (isset($parsed['fragment'])) $uri .= "#$parsed[fragment]"; 

  	return $uri; 
}
/**
 * @return string
 * @param form string
 * @desc validate incoming form data, return empty string on pass and error message on failure
 */
function validate_form($form) {
	$today = date('Ymd');
	$err_msg = "";
	switch ($form) {
		case "add_user":
		case "register":
			db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
			if (valid_email($_POST["email"])) { 
				if ($_POST["email1"] !== "") {
					if ($_POST["email"] === $_POST["email1"]) {
						$email_sql = "SELECT id FROM users WHERE email LIKE ".quote_smart($_POST["email"]);
						$email_result = mysql_query($email_sql) or die ("Line ".__LINE__." in ".__FILE__.": ".mysql_error());
						$email_count = @mysql_num_rows($email_result);
						if ($email_count !== 0) $err_msg .= "The Email Address you supplied is already in use by an active account.<br><br>\n";
					} else {
						$err_msg .= "Confirm Email Address does not match Email Address. Please enter both again.<br><br>\n";
					}
				} else {
					$err_msg .= "Please Confirm Email Address.<br><br>\n";
				}
			} else {
				$err_msg .= "Please enter a valid Email Address.<br><br>\n";
			}
			$err_msg .= (trim($_POST["password"]) !== "") ?  "":"Please enter Password.<br><br>\n";
			$err_msg .= (trim($_POST["password1"]) !== "") ?  "":"Please Confirm Password.<br><br>\n";
			$err_msg .= ($_POST["password"]=== $_POST["password1"]) ?  "":"Password and Confirm Password must match.<br><br>\n";
			if (($_POST["email"] !== "") && ($_POST["password"] !== "")) $err_msg .= valid_password(trim($_POST["password"]),trim($_POST["email"]));
			$err_msg .= (trim($_POST["firstname"]) !== "") ?  "":"Please enter First Name.<br><br>\n";
			$err_msg .= (trim($_POST["lastname"]) !== "") ?  "":"Please enter Last Name.<br><br>\n";
			$err_msg .= (trim($_POST["title"]) !== "") ?  "":"Please enter Title.<br><br>\n";
			$err_msg .= (trim($_POST["company"]) !== "") ?  "":"Please enter Company.<br><br>\n";
			$err_msg .= (trim($_POST["address"]) !== "") ?  "":"Please enter Address.<br><br>\n";
			$err_msg .= (trim($_POST["city"]) !== "") ?  "":"Please enter City.<br><br>\n";
			$err_msg .= (trim($_POST["state"]) !== "") ?  "":"Please select State.<br><br>\n";
			if ($_POST["state"] === "CA") {
				$err_msg .= (trim($_POST["county"]) !== "") ?  "":"Please select a County.<br><br>\n";
			}
			$err_msg .= (valid_zip($_POST["zip"])) ?  "":"Please enter a valid Zip.<br><br>\n";
			if (!valid_phone(fix_phone_in("phone"))) $err_msg .= "Please enter a valid Phone.<br><br>\n";
			if ((trim($_POST["fax1"]) !== "") || (trim($_POST["fax2"]) !== "") ||(trim($_POST["fax3"]) !== "")) {
				if (!valid_phone(fix_phone_in("fax"))) $err_msg .= "Please enter a valid Fax.<br><br>\n";
			}
			$err_msg .= (trim($_POST["default_product"]) !== "") ?  "":"Please select Default Product.<br><br>\n";
			$err_msg .= (trim($_POST["clientid"])!== "" && !ctype_alnum($_POST["clientid"]))? "Client ID must contains only alpha-numberic characters.<br><br>\n" : "";
			break;
		case "edit_user":
			db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
			if (valid_email($_POST["email"])) { 
				$email_sql = "SELECT id FROM users WHERE email=".quote_smart($_POST["email"])." AND id != '{$_POST['id']}'";
				$email_result = mysql_query($email_sql) or die ("Line ".__LINE__." in ".__FILE__.": ".mysql_error());
				$email_count = @mysql_num_rows($email_result);
				if ($email_count !== 0) $err_msg .= "The Email Address you supplied is already in use by another account.<br><br>\n";
			} else {
				$err_msg .= "Please enter a valid Email Address.<br><br>\n";
			}
			if (trim($_POST["new_password"]) !== "") {
				$err_msg .= (trim($_POST["password1"]) !== "") ?  "":"Please Confirm New Password.<br><br>\n";
				$err_msg .= ($_POST["new_password"]=== $_POST["password1"]) ?  "":"New Password and Confirm Password must match.<br><br>\n";
				if (($_POST["email"] !== "") && ($_POST["new_password"] !== "")) $err_msg .= valid_password(trim($_POST["new_password"]),trim($_POST["email"]));
			}
			$err_msg .= (trim($_POST["firstname"]) !== "") ?  "":"Please enter First Name.<br><br>\n";
			$err_msg .= (trim($_POST["lastname"]) !== "") ?  "":"Please enter Last Name.<br><br>\n";
			$err_msg .= (trim($_POST["title"]) !== "") ?  "":"Please enter Title.<br><br>\n";
			$err_msg .= (trim($_POST["company"]) !== "") ?  "":"Please enter Company.<br><br>\n";
			$err_msg .= (trim($_POST["address"]) !== "") ?  "":"Please enter Address.<br><br>\n";
			$err_msg .= (trim($_POST["city"]) !== "") ?  "":"Please enter City.<br><br>\n";
			$err_msg .= (trim($_POST["state"]) !== "") ?  "":"Please select State.<br><br>\n";
			if ($_POST["state"] === "CA") {
				$err_msg .= (trim($_POST["county"]) !== "") ?  "":"Please select a County.<br><br>\n";
			}
			$err_msg .= (valid_zip($_POST["zip"])) ?  "":"Please enter a valid Zip.<br><br>\n";
			if (!valid_phone(fix_phone_in("phone"))) $err_msg .= "Please enter a valid Phone.<br><br>\n";
			if ((trim($_POST["fax1"]) !== "") || (trim($_POST["fax2"]) !== "") ||(trim($_POST["fax3"]) !== "")) {
				if (!valid_phone(fix_phone_in("fax"))) $err_msg .= "Please enter a valid Fax.<br><br>\n";
			}
			$err_msg .= (trim($_POST["default_product"]) !== "") ?  "":"Please select Default Product.<br><br>\n";
			$err_msg .= (trim($_POST["registration_status"]) !== "") ?  "":"Please enter Registration Status.<br><br>\n";
			$err_msg .= (trim($_POST["clientid"])!== "" && !ctype_alnum($_POST["clientid"]))? "Client ID must contains only alpha-numberic characters.<br><br>\n" : "";
			break;
		case "edit_profile":
			db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
			if (valid_email($_POST["email"])) { 
				$email_sql = "SELECT id FROM users WHERE email=".quote_smart($_POST["email"])." AND id != '{$_POST['id']}'";
				$email_result = mysql_query($email_sql) or die ("Line ".__LINE__." in ".__FILE__.": ".mysql_error());
				$email_count = @mysql_num_rows($email_result);
				if ($email_count !== 0) $err_msg .= "The Email Address you supplied is already in use by another account.<br><br>\n";
			} else {
				$err_msg .= "Please enter a valid Email Address.<br><br>\n";
			}
			if (trim($_POST["new_password"]) !== "") {
				$err_msg .= (trim($_POST["password1"]) !== "") ?  "":"Please Confirm New Password.<br><br>\n";
				$err_msg .= ($_POST["new_password"]=== $_POST["password1"]) ?  "":"New Password and Confirm Password must match.<br><br>\n";
				if (($_POST["email"] !== "") && ($_POST["new_password"] !== "")) $err_msg .= valid_password(trim($_POST["new_password"]),trim($_POST["email"]));
			}
			$err_msg .= (trim($_POST["firstname"]) !== "") ?  "":"Please enter First Name.<br><br>\n";
			$err_msg .= (trim($_POST["lastname"]) !== "") ?  "":"Please enter Last Name.<br><br>\n";
			$err_msg .= (trim($_POST["title"]) !== "") ?  "":"Please enter Title.<br><br>\n";
			$err_msg .= (trim($_POST["company"]) !== "") ?  "":"Please enter Company.<br><br>\n";
			$err_msg .= (trim($_POST["address"]) !== "") ?  "":"Please enter Address.<br><br>\n";
			$err_msg .= (trim($_POST["city"]) !== "") ?  "":"Please enter City.<br><br>\n";
			$err_msg .= (trim($_POST["state"]) !== "") ?  "":"Please select State.<br><br>\n";
			if ($_POST["state"] === "CA") {
				$err_msg .= (trim($_POST["county"]) !== "") ?  "":"Please select a County.<br><br>\n";
			}
			$err_msg .= (valid_zip($_POST["zip"])) ?  "":"Please enter a valid Zip.<br><br>\n";
			if (!valid_phone(fix_phone_in("phone"))) $err_msg .= "Please enter a valid Phone.<br><br>\n";
			if ((trim($_POST["fax1"]) !== "") || (trim($_POST["fax2"]) !== "") ||(trim($_POST["fax3"]) !== "")) {
				if (!valid_phone(fix_phone_in("fax"))) $err_msg .= "Please enter a valid Fax.<br><br>\n";
			}
			$err_msg .= (trim($_POST["default_product"]) !== "") ?  "":"Please select Default Product.<br><br>\n";
			break;
		case "change_password":
				$err_msg .= (trim($_POST["password"]) !== "") ?  "":"Please enter Password.<br><br>\n";
				$err_msg .= (trim($_POST["password1"]) !== "") ?  "":"Please Confirm Password.<br><br>\n";
				$err_msg .= ($_POST["password"]=== $_POST["password1"]) ?  "":"Password and Confirm Password must match.<br><br>\n";
				if (($_POST["email"] !== "") && ($_POST["password"] !== "")) $err_msg .= valid_password(trim($_POST["password"]),trim($_POST["email"]));
			break;
		case "add_ftp":
			$err_msg .= (trim($_POST["product"]) !== "") ?  "":"Please enter Product.<br><br>\n";
			//$err_msg .= (trim($_POST["server"]) !== "") ?  "":"Please enter Server.<br><br>\n";
			$err_msg .= (trim($_POST["directory"]) !== "") ?  "":"Please enter Directory.<br><br>\n";
			$err_msg .= (trim($_POST["type"]) !== "") ?  "":"Please select Type.<br><br>\n";
			/*
			$err_msg .= (trim($_POST["username"]) !== "") ?  "":"Please enter Username.<br><br>\n";
			$err_msg .= (trim($_POST["password"]) !== "") ?  "":"Please enter Password.<br><br>\n";
			$err_msg .= (trim($_POST["password1"]) !== "") ?  "":"Please Confirm Password.<br><br>\n";
			$err_msg .= ($_POST["password"]=== $_POST["password1"]) ?  "":"Password and Confirm Password must match.<br><br>\n";
			*/
			break;
		case "edit_ftp":
			//$err_msg .= (trim($_POST["server"]) !== "") ?  "":"Please enter Server.<br><br>\n";
			$err_msg .= (trim($_POST["directory"]) !== "") ?  "":"Please enter Directory.<br><br>\n";
			$err_msg .= (trim($_POST["type"]) !== "") ?  "":"Please select Type.<br><br>\n";
			/*
			$err_msg .= (trim($_POST["username"]) !== "") ?  "":"Please enter Username.<br><br>\n";
			if (trim($_POST["new_password"]) !== "") {
				$err_msg .= (trim($_POST["password1"]) !== "") ?  "":"Please Confirm New Password.<br><br>\n";
				$err_msg .= ($_POST["new_password"]=== $_POST["password1"]) ?  "":"New Password and Confirm Password must match.<br><br>\n";
				if (($_POST["email"] !== "") && ($_POST["new_password"] !== "")) $err_msg .= valid_password(trim($_POST["new_password"]),trim($_POST["email"]));
			}
			*/
			break;
		case "upgraderegister":
			db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
			$err_msg .= (trim($_POST["firstname"]) !== "") ?  "":"Please enter First Name.<br><br>\n";
			$err_msg .= (trim($_POST["lastname"]) !== "") ?  "":"Please enter Last Name.<br><br>\n";
			$err_msg .= (trim($_POST["title"]) !== "") ?  "":"Please enter Title.<br><br>\n";
			$err_msg .= (trim($_POST["company"]) !== "") ?  "":"Please enter Company.<br><br>\n";
			$err_msg .= (trim($_POST["address"]) !== "") ?  "":"Please enter Address.<br><br>\n";
			$err_msg .= (trim($_POST["city"]) !== "") ?  "":"Please enter City.<br><br>\n";
			$err_msg .= (trim($_POST["state"]) !== "") ?  "":"Please select State.<br><br>\n";
			if ($_POST["state"] === "CA") {
				$err_msg .= (trim($_POST["county"]) !== "") ?  "":"Please select a County.<br><br>\n";
			}
			$err_msg .= (valid_zip($_POST["zip"])) ?  "":"Please enter a valid Zip.<br><br>\n";
			if (!valid_phone(fix_phone_in("phone"))) $err_msg .= "Please enter a valid Phone.<br><br>\n";
			if ((trim($_POST["alt_phone1"]) !== "") || (trim($_POST["alt_phone2"]) !== "") ||(trim($_POST["alt_phone3"]) !== "")) {
				if (!valid_phone(fix_phone_in("alt_phone"))) $err_msg .= "Please enter a valid Alternate Phone.<br><br>\n";
			}
			$err_msg .= (valid_email($_POST["email"])) ?  "":"Please enter a valid Email Address.<br><br>\n";
			$err_msg .= ((intval(date('Ymd',strtotime($_POST["est_upgrade_date"])))) >= (intval($today))) ?  "":"Please enter a Planned Upgrade Date after today's date.<br><br>\n";
			$err_msg .= (trim($_POST["est_upgrade_time"]) !== "") ?  "":"Please enter a Planned Upgrade Start Time.<br><br>\n";
			$err_msg .= (trim($_POST["backup_agreement"]) !== "") ?  "":"You may not register for this upgrade unless you agree to the Backup Agreement.<br><br>\n";
			break;
		case "scheduleupgrade":
			db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
			$err_msg .= (trim($_POST["firstname"]) !== "") ?  "":"Please enter First Name.<br><br>\n";
			$err_msg .= (trim($_POST["lastname"]) !== "") ?  "":"Please enter Last Name.<br><br>\n";
			$err_msg .= (trim($_POST["title"]) !== "") ?  "":"Please enter Title.<br><br>\n";
			$err_msg .= (trim($_POST["company"]) !== "") ?  "":"Please enter Company.<br><br>\n";
			$err_msg .= (trim($_POST["address"]) !== "") ?  "":"Please enter Address.<br><br>\n";
			$err_msg .= (trim($_POST["city"]) !== "") ?  "":"Please enter City.<br><br>\n";
			$err_msg .= (trim($_POST["state"]) !== "") ?  "":"Please select State.<br><br>\n";
			if ($_POST["state"] === "CA") {
				$err_msg .= (trim($_POST["county"]) !== "") ?  "":"Please select a County.<br><br>\n";
			}
			$err_msg .= (valid_zip($_POST["zip"])) ?  "":"Please enter a valid Zip.<br><br>\n";
			if (!valid_phone(fix_phone_in("phone"))) $err_msg .= "Please enter a valid Phone.<br><br>\n";
			if ((trim($_POST["alt_phone1"]) !== "") || (trim($_POST["alt_phone2"]) !== "") ||(trim($_POST["alt_phone3"]) !== "")) {
				if (!valid_phone(fix_phone_in("alt_phone"))) $err_msg .= "Please enter a valid Alternate Phone.<br><br>\n";
			}
			$err_msg .= (valid_email($_POST["email"])) ?  "":"Please enter a valid Email Address.<br><br>\n";
			break;
		case "mailinglist":
		case "productrequest":
			$err_msg .= (trim($_POST["firstname"]) !== "") ?  "":"Please enter First Name.<br><br>\n";
			$err_msg .= (trim($_POST["lastname"]) !== "") ?  "":"Please enter Last Name.<br><br>\n";
			$err_msg .= (trim($_POST["title"]) !== "") ?  "":"Please enter Title.<br><br>\n";
			$err_msg .= (trim($_POST["company"]) !== "") ?  "":"Please enter Company.<br><br>\n";
			$err_msg .= (trim($_POST["address"]) !== "") ?  "":"Please enter Address.<br><br>\n";
			$err_msg .= (trim($_POST["city"]) !== "") ?  "":"Please enter City.<br><br>\n";
			$err_msg .= (trim($_POST["state"]) !== "") ?  "":"Please select State.<br><br>\n";
			if ($_POST["state"] === "CA") {
				$err_msg .= (trim($_POST["county"]) !== "") ?  "":"Please select a County.<br><br>\n";
			}
			$err_msg .= (valid_zip($_POST["zip"])) ?  "":"Please enter a valid Zip.<br><br>\n";
			if (!valid_phone(fix_phone_in("phone"))) $err_msg .= "Please enter a valid Phone.<br><br>\n";
			if ((trim($_POST["fax1"]) !== "") || (trim($_POST["fax2"]) !== "") ||(trim($_POST["fax3"]) !== "")) {
				if (!valid_phone(fix_phone_in("fax"))) $err_msg .= "Please enter a valid Fax.<br><br>\n";
			}
			$err_msg .= (valid_email($_POST["email"])) ?  "":"Please enter a valid Email Address.<br><br>\n";
			if (is_array($_POST['Iaminterestedin'])) {
				if (in_array('Other',$_POST['Iaminterestedin'])) {
					$err_msg .= (trim($_POST["Other Interest(s)"]) !== "") ?  "":"Please describe 'Other' Interest.<br><br>\n";
				}
			}
			if (is_array($_POST['Referredby'])) {
				if (in_array('Customer Referral',$_POST['Referredby'])) {
					$err_msg .= (trim($_POST["Customer Referral Name"]) !== "") ?  "":"Please enter name of 'Customer Referal' in 'How did you hear about First American SMS'.<br><br>\n";
				}
				if (in_array('Other',$_POST['Referredby'])) {
					$err_msg .= (trim($_POST["Other Referral"]) !== "") ?  "":"Please describe 'Other' in 'How did you hear about First American SMS'.<br><br>\n";
				}
			}
			break;
		case "changerequest":
			$err_msg .= (trim($_POST["firstname"]) !== "") ?  "":"Please enter First Name.<br><br>\n";
			$err_msg .= (trim($_POST["lastname"]) !== "") ?  "":"Please enter Last Name.<br><br>\n";
			$err_msg .= (trim($_POST["title"]) !== "") ?  "":"Please enter Title.<br><br>\n";
			$err_msg .= (trim($_POST["company"]) !== "") ?  "":"Please enter Company.<br><br>\n";
			$err_msg .= (trim($_POST["address"]) !== "") ?  "":"Please enter Address.<br><br>\n";
			$err_msg .= (trim($_POST["city"]) !== "") ?  "":"Please enter City.<br><br>\n";
			$err_msg .= (trim($_POST["state"]) !== "") ?  "":"Please select State.<br><br>\n";
			if ($_POST["state"] === "CA") {
				$err_msg .= (trim($_POST["county"]) !== "") ?  "":"Please select a County.<br><br>\n";
			}
			$err_msg .= (valid_zip($_POST["zip"])) ?  "":"Please enter a valid Zip.<br><br>\n";
			if (!valid_phone(fix_phone_in("phone"))) $err_msg .= "Please enter a valid Phone.<br><br>\n";
			if ((trim($_POST["fax1"]) !== "") || (trim($_POST["fax2"]) !== "") ||(trim($_POST["fax3"]) !== "")) {
				if (!valid_phone(fix_phone_in("fax"))) $err_msg .= "Please enter a valid Fax.<br><br>\n";
			}
			$err_msg .= (valid_email($_POST["email"])) ?  "":"Please enter a valid Email Address.<br><br>\n";
			$err_msg .= (trim($_POST["product"]) !== "") ?  "":"Please select Product/Service.<br><br>\n";
			if ($_POST["product"] === "Other") {
				$err_msg .= (trim($_POST["other_product"]) !== "") ?  "":"Please describe 'Other' Product/Service.<br><br>\n";
			}
			break;
		case "uploaddocuments":
			$err_msg .= (trim($_POST["firstname"]) !== "") ?  "":"Please enter First Name.<br><br>\n";
			$err_msg .= (trim($_POST["lastname"]) !== "") ?  "":"Please enter Last Name.<br><br>\n";
			$err_msg .= (trim($_POST["company"]) !== "") ?  "":"Please enter Company.<br><br>\n";
			$err_msg .= (trim($_POST["state"]) !== "") ?  "":"Please select State.<br><br>\n";
			if ($_POST["state"] === "CA") {
				$err_msg .= (trim($_POST["county"]) !== "") ?  "":"Please select a County.<br><br>\n";
			}
			if (!valid_phone(fix_phone_in("phone"))) $err_msg .= "Please enter a valid Phone.<br><br>\n";
			$err_msg .= (valid_email($_POST["email"])) ?  "":"Please enter a valid Email Address.<br><br>\n";
			$upload_errors = array( 1 => 'The uploaded file exceeds the upload_max_filesize directive for this server.', 'The uploaded file exceeds the MAX_FILE_SIZE allowed for this form.', 'The uploaded file was only partially uploaded', 'No file was uploaded');
			if ($_FILES['attachment']['error'] !== 0) {
				$err_msg .= "Sorry, the file \"".$_FILES['attachment']['name']."\" <B>failed to upload</B> properly.<br><br>\n";
				$err_msg .= "Specific upload error: ".$upload_errors[$_FILES['attachment']['error']]."<br><br>\n";
			}
			$err_msg .= ($err_msg === "") ?  "":"Please reselect file to upload.<br><br>\n";
			break;
		default:
			break;
	}
	if ($err_msg !== "") {
		$err_msg = "<table border='0' cellpadding='5' cellspacing='1' bgcolor='#CC0000' width='515'>
						<tr>
							<td valign='top' align='center' class='text1'><font color='#FFFFFF'>RETRY</font></td>
							<td valign='top' align='left' bgcolor='#FFFFFF' class='text1'><font color='#000000'><b>$err_msg</b></font></td>
						</tr>
					</table>";
	}
	return $err_msg;
}
/**
 * @return string
 * @param datestamp string
 * @param format string
 * @desc convert a mysql datetime datatype into any format
 */
function convert_datetime($datestamp, $format) {
	if ($datestamp!=0) {
		list($date, $time)=split(" ", $datestamp);
		list($year, $month, $day)=split("-", $date);
		list($hour, $minute, $second)=split(":", $time);
		$stampeddate=mktime($hour,$minute,$second,$month,$day,$year);
		$datestamp=date($format,$stampeddate);
		return $datestamp;
	}
}
/**
 * @return string
 * @param time string
 * @desc convert a 12 hour time string into 24 hour format
 */
function convert_time($time) {
	$ampm = substr($time,-2);
	$trunctime = trim(substr($time,0,-2));
	list($hour, $minutes)=split(":", $trunctime);
	if (strtoupper($ampm) === "PM") {
		if ($hour < "12") $hour = strval(intval($hour) + 12);
	} else {
		if ($hour === "12") $hour = "00";
	}
	if (strlen($hour) < 2) {
		$hour = "0" . $hour;
	} 
	$newtime = $hour . ":". $minutes . ":00";	
	return $newtime;
}
/**
 * @return string
 * @param array $a
 * @param array $b
 * @desc sort directory list array by name element in ascending order
 */
function sort_directory_by_name_asc($a, $b) {
       return strnatcasecmp($a["name"], $b["name"]);
}
/**
 * @return string
 * @param array $a
 * @param array $b
 * @desc sort directory list array by name element in descending order
 */
function sort_directory_by_name_desc($a, $b) {
       return strnatcasecmp($b["name"], $a["name"]);
}
/**
 * @return bool
 * @param uid int
 * @param admin bool[optional]
 * @desc check if user is logged in and has access priveleges
 */
function checkUserOld($uid, $admin=false) {
	if (isset($_SESSION['logged_in'])) {
		if ($_SESSION['logged_in'] === true) {
			if (isset($_SESSION['userid'])) {
				if ($_SESSION['userid'] != '') {
					if ($admin) {
						if (isset($_SESSION['admin'])) {
							if ($_SESSION['admin'] === true) {
								return true;
							} else {
								return false;
							}
						} else {
							return false;
						}
					} else {
						db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
						$access_sql = "SELECT registration_status FROM users WHERE id = '$uid'";
						$access_result = @mysql_query($access_sql);
						if ($access_result) {
							if (mysql_num_rows($access_result) > 0) {
								$access_row = mysql_fetch_assoc($access_result);
								switch ($access_row['registration_status']) {
									case "Profile Update":
									case "Approved":
										return true;
										break;
									default:
										return false;
										break;
								}
							} else {
								return false;
							}	
						} else {
							return false;
						}
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}
/**
 * @return bool
 * @param uid int
 * @param admin bool[optional]
 * @desc check if user is logged in and has access priveleges
 */
function checkUser($uid, $admin=false) {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	// GARBAGE COLLECTION
	$garbage_sql = "DELETE FROM `login_session` WHERE `session_time` <= now() - interval 1 HOUR ";
	mysql_query($garbage_sql);
	
	if (isset($_SESSION['logged_in'])) {
		if ($_SESSION['logged_in'] === true) {
			if (isset($_SESSION['userid']) || isset($_SESSION['usertoken'])) {
				if ($_SESSION['userid'] != '' || $_SESSION['usertoken'] != '') {
					if ($admin) {
						if (isset($_SESSION['admin'])) {
							if ($_SESSION['admin'] === true) {
								return true;
							} else {
								return false;
							}
						} else {
							return false;
						}
					} else {						
						$access_sql = "SELECT * FROM `login_session` WHERE `session_id` = '" . session_id() . "' AND `usertoken` = '" . $_SESSION['usertoken'] . "' AND `session_time` >= now() - interval 30 MINUTE ";
						$access_result = @mysql_query($access_sql);
						if ($access_result) {
							if (mysql_num_rows($access_result) > 0) {
								$update_session_sql = "UPDATE `login_session` SET `session_time` = now() WHERE `session_id` = '" . session_id() . "' AND `usertoken` = '" . $_SESSION['usertoken'] . "'";
								mysql_query($update_session_sql);
								return true;
							} else {
								return false;
							}	
						} else {
							return false;
						}
					}
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	} else {
		return false;
	}
}
/**
 * @return bool
 * @param string $product
 * @param string $sub_dir
 * @param string $userid
 * @desc check if user has registered for access to sub directory
 */
function check_registeredold($product, $sub_dir, $userid) {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	$sql = "SELECT id FROM productregistrations WHERE logged_in_userid=$userid AND sub_dir='$sub_dir' and product='$product'";
	$result = @mysql_query($sql);
	if (!$result) {
		return false;
	} else {
		$numrows = mysql_num_rows($result);
		if ($numrows > 0) {
			return true;
		} else {
			return false;
		}
	}
}
/**
 * @return bool
 * @param string $product
 * @param string $sub_dir
 * @param string $userid
 * @desc check if user has registered for access to sub directory
 */
function check_registered($product, $sub_dir, $userid) {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	$sql = "SELECT id FROM productregistrations WHERE logged_in_userid='$userid' AND sub_dir='$sub_dir' and product='$product'";
	$result = @mysql_query($sql);
	if (!$result) {
		return false;
	} else {
		$numrows = mysql_num_rows($result);
		if ($numrows > 0) {
			return true;
		} else {
			return false;
		}
	}
}
/**
 * @return bool
 * @param string $path
 * @param bool $followLinks
 * @param bool $deleteFolder
 * @desc delete all content and sub-content of a folder and optionally, the folder itself
 */
function rmdirRecursive($path,$followLinks=false,$deleteFolder=false) {
	$dir = opendir($path) ;
	while ( $entry = readdir($dir) ) {

		if ( is_file( "$path/$entry" ) || ((!$followLinks) && is_link("$path/$entry")) ) {
			//echo ( "unlink $path/$entry;\n" );
			unlink( "$path/$entry" );
		} elseif ( is_dir( "$path/$entry" ) && $entry!='.' && $entry!='..' ) {
			rmdirRecursive( "$path/$entry",$followLinks,true ) ;
		}
	}
	closedir($dir) ;
	if ($deleteFolder) {
		//echo "rmdir $path;\n";
		return rmdir($path);
	}
}
?>