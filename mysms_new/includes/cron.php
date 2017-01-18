#!/usr/bin/php -q
<?php
/**
* Set unused accounts to Inactive status
*/
	require_once("mysms_fns.php");
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	$ids = '';
	$today = date("Y-m-d H:i:s");
	$sql = "SELECT id 
		FROM users
		WHERE (TO_DAYS('$today') - TO_DAYS(last_login)) > ".INACTIVE_PERIOD." 
		AND registration_status NOT LIKE 'Inactive'";
	$result = mysql_query ($sql) or die ("LINE: ".__LINE__." in FILE: ".__FILE__." Query: $sql<br>".mysql_error());
	while($row = mysql_fetch_array($result)) {
		$ids .= "{$row["id"]},";
	}
	$ids = substr($ids,0,-1);
	if (trim($ids) !== '') {
		$sql = "UPDATE users 
				SET registration_status = 'Inactive'
				WHERE id IN ( $ids )";
		$result = mysql_query ($sql) or die ("LINE: ".__LINE__." in FILE: ".__FILE__." Query: $sql<br>".mysql_error());
	}
/**
* Clean out downloads temp directory
*/
	rmdirRecursive(FTP_TEMP_DIR);
/**
* EOF
*/
?>
