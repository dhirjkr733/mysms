<?php
session_start(); // use on all pages !
include("config1.inc.php"); // stores important required info
$this_page_title = "Login Management";
//include($auth_header);  // authorization stuff referenced in config file, can override default

// check new login and setup session
if ($new_login) {
	
	// check for missing log/pass
	if (!$login AND !$password) { $error = "Missing Login and Password. Please enter a Login and Password."; $login = ""; $no_cookie_login = 1; } // no_login keeps cookie from populating and conflicting with error message
	elseif ($login AND !$password) { $error = "Missing Password. Please enter a Password and Login."; }
	elseif (!$login AND $password) { $error = "Missing Login. Please enter a Login and Password."; $login = ""; $no_cookie_login = 1; }
	else {
		// verify login
		//$login_sql = "SELECT user.user_id,user.master_org_id,user.sub_org_id,user.first_name,DECODE(user.password,'$crypt_pass') AS password,user.type,user.status,UNIX_TIMESTAMP(user.last_access) AS last_access FROM user WHERE user.login='$login'"; 
		$login_sql = "SELECT editor_id,first_name,DECODE(password,'$crypt_pass') AS password,type,UNIX_TIMESTAMP(last_access) AS last_access FROM editor WHERE login='$login'"; 
		if (($login_result = mysql_query($login_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__)) && mysql_num_rows($login_result)) {
			
			list ($u_id,$firstname,$queried_password,$type,$last_access) = mysql_fetch_row($login_result);
			
			//print "Poof: $queried_password";
			
			// passwords no matchy
			if ($queried_password != $password) { 
				$error = "Invalid Password. Please enter a correct Password.";
			}
			else {
				// good to go, set session variables
				session_register("sess_login");
				session_register("sess_password");
				session_register("time_last_verified");
				session_register("utype");      // user_type
				session_register("uid");        // user_id
				session_register("fname");      // first name

				$sess_login = $login;
				$sess_password = $password;
				$time_last_verified = time(); // seconds since epoch
				$utype = $type;
				$uid = $u_id;
				$fname = $firstname;
				
				//$last_login = date("l, F j, Y, h:i a ",$last_access + $s_time_offset) . $c_time_zone;
				$last_login = date("n/j/y, g:ia ",$last_access + $s_time_offset) . $c_time_zone;
				$last_login = urlencode($last_login);
				
				// update last_access
				$update_query = mysql_query("UPDATE editor SET last_access=NOW() WHERE login='$login'",$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);

				// SET COOKIE - used only to remember display login 
				//if (!isset($show_login)) { 
				setcookie("show_login", $login, time()+$login_exp, "/", $cookie_domain,0); 
				//}
				
				// clean any tacked on variables that mess up redirect
				//$referer_stripped = strtok($HTTP_REFERER,"?");
				
				// user type= 1 for admin or 2 for regular user, admin user goes only to manage users
				if ($utype==1) {
					header("Location: editors.php?last_login=$last_login");
				}
				else {
					header("Location: edit_list.php?last_login=$last_login");
				}
				exit;				
			}
		}
		// bad login
		else { $error = "Invalid Login. Please enter a correct Login and Password."; $login = ""; $no_cookie_login = 1; }
	}
}

// log user OUT
if ($man_logout || $auto_logout || $verfail) {
	// might not be logged in to get here!
	if ($PHPSESSID) {
		// keeping master and sub org ids for correct logo display, etc., remove all other variables but keep sessionid
		session_unregister("$sess_login");
		session_unregister("$sess_password");
		session_unregister("$time_last_verified");
		session_unregister("$utype");      // user_type
		session_unregister("$uid");        // user_id
		session_unregister("$fname");      // first name
		unset($sess_login);
		unset($sess_password);
		unset($time_last_verified);
		unset($last_login);
		unset($utype);
		unset($uid);
		unset($fname);
		session_destroy();
	}
}

// additional title for this page
$page_title .= " - ";
$page_title .= $this_page_title;

// you could put page-specific META tags here to override any in the config file

// HTML header include referenced in config file or could override here
include($header);

?>
				            <table align="center" width="100%">
				              <tr> 
				                <td align="center"><font class="bigger_even"><?php echo $this_page_title; ?></font></td>
				              </tr>
				              <tr> 
				                <td align="center"><img src="<?php print $path_sys_images;?>images/black.gif" width="100%" height="1"></td>
				              </tr>
				              <tr>
				                <td align="center"> 
				                  <BR>
				                  <?php
								  
								  // Show any errors/success
								  if ($error) {
									echo "<BR><font class=\"warning\"><B>$error</B></font><BR>\n";
									echo "<font class=\"smaller\"><BR>If you continue to have problems, e-mail <A HREF=\"mailto:$tech_sup_email\">$tech_sup_email</A> or call $tech_sup_phone.<BR><BR></font>";
								  }
								  elseif ($success) {
									echo "<CENTER><BR><font class=\"warning\"><B>$success</B></font></CENTER><BR><BR>\n";
								  }
								  // display welcome message if present & not logged in
								  if ($welcome_msg && !$fname && !$error && !$man_logout && !$auto_logout && !$verfail) {
									echo "<BR>$welcome_msg<BR><BR>\n";
								  }

								  // Show login/out messages
					                  $logout_minutes = number_format($logout_time/60);
					                  $reverify_minutes = number_format($reverify_time/60);
					                  if ($fname) { echo "You are currently logged in as <B>$fname</B>. <BR>If you would like to login as a different user, <a href=\"".$PHP_SELF."?man_logout=1\">log out</a> first.<BR><BR>\n"; $login = ""; $no_cookie_login = 1; }
					                  if ($man_logout) { echo "You are now <B>logged off</B>. You must login again below to use the system.<BR>\n"; }
					                  if ($auto_logout) { echo "You have been automatically <B>logged off</B>. <BR>As a security feature, users are automatically logged off after $logout_minutes minutes of inactivity. Please login below to use the system.\n"; }
					                  if ($verfail) { echo "You have been automatically <B>logged off</B>. As a security feature, we re-verify user login information every $reverify_minutes minutes and were unable to verify yours. Please try to login again below. If you continue to have problems, e-mail <A HREF=\"mailto:$tech_sup_email\">$tech_sup_email</A> or call $tech_sup_phone.\n"; }
					                  if ($fname=="") {
					                  ?>
									   <form method="post" action="<?php echo $PHP_SELF ?>">
									   Login:<BR>
									   <input type="text" name="login" maxlength="20" size="10" value="<?php if ($login) { echo $login ; } elseif (!$login && !$no_cookie_login) { echo $show_login ; } ?>"><BR>
									   Password:<BR>
									   <input type="password" name="password" maxlength="20" size="10"><BR>
									   <input type="submit" name="new_login" value=" Login "><BR><BR>
									   </form>
					                  <?php
					                  }
				                  ?>
				                  </td>
				              </tr>
				            </table>
<?php

// footer include referenced in config
include($footer);

?>


