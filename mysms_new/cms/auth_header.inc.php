<?php
// used at top of each page to verify user

$time_now = time(); // seconds since epoch
// calculate the time lapsed from last verification
$time_lapsed = $time_now - $time_last_verified;

if ($sess_login && $sess_password) { // check if already logged in
	if ($time_lapsed > $reverify_time) {
		// verify login
		$login_sql = "SELECT editor_id,first_name,DECODE(password,'$crypt_pass'),type FROM editor WHERE login='$sess_login'"; 
		if (($login_result = mysql_query($login_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__)) && mysql_num_rows($login_result)) {
			
			list ($u_id,$firstname,$queried_password,$type) = mysql_fetch_row($login_result);
			
			// passwords no matchy
			if ($queried_password != $sess_password) { $logmout = 1; }
			else {
				// update some sesion variables, already registered when first logging in
				$time_last_verified = time(); // seconds since epoch
				$utype = $type;
				$uid = $u_id;
				$fname = $firstname;
			}
		}
		// bad login
		else { $logmout = 1; }
		
		// problems get logged out
		if ($logmout) {
			header("Location: login.php?verfail=1");
			exit;
		}
		
	}
	// don't need to reverify user if reverification not exceeded allowed time - do nothing
}
else { // redirect if no login/password set
	header("Location: login.php");
	exit;
}
?>