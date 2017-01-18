<?php
/**
 * @return null
 * @param $location string
 * @param $mesg string
 * @param $err_mail_to string[optional]
 * @desc repackages $_POST fields and sends back to $location with $mesg
 */
function return_form($location, $mesg, $err_mail_to="")  {
	
	$error_mail_msg = "An error occurred on ".date("l, F d, Y at h:i:s A").": \r\n";
	$error_mail_msg .= "\r\nPOST VARIABLES:\r\n";
	$returnform = "<html>\n<head>\n<title></title>\n</head><body>\n";
	$returnform .= "<form name=\"return_form\" method=\"post\" action=\"$location\">\n";
	$returnform .= "<input type=\"hidden\" name=\"mesg\" value=\"$mesg\">\n";
	foreach ($_POST as $key=>$value) {
		$returnform .= "<input type=\"hidden\" name=\"$key\" value=\"$value\">\n";
		$error_mail_msg .= "$key = $value\r\n";
	}
	$returnform .= "</form>\n";
	if ($err_mail_to !== "") {
			$error_mail_msg .= "\r\nTRANSACTION RESULTS:\r\n$mesg\r\n";
			mail($err_mail_to,"Form Error",$error_mail_msg,"From: webmaster@{$_SERVER['SERVER_NAME']}\r\n");
	}
	print $returnform;
	submitForm("return_form");
	print "</body>\n</html>";
}
/**
 * @return boolean
 * @desc insert record into ibroadcast database and return true on success
 * @param array $user_info
 */
function insertiBroadcast($user_info) {
	/* disconnected from Caliber Connect on 5/10/2016 */
	/*
	db_connect(IB_DATABASE,IB_DATABASE_USER,IB_DATABASE_PASS,IB_DATABASE_HOST);
	$sql = "SELECT * FROM ibc_listmembers WHERE email = '{$user_info['email']}' AND nl = '{$user_info['nl']}' LIMIT 1";
	$ib_result = mysql_query($sql) or die("File: ".__FILE__."<br>Line: ".__LINE__."<br>SQL: $sql <br>Error: ".mysql_error());
	if (mysql_numrows($ib_result) > 0) {// if it does exists, update contact information
		$update_string = '';
		$id = $ib_result['id'];
		if (is_array($user_info)) {
			foreach($user_info as $key => $value) {
				$update_string .= "$key=".quote_smart($value).",";
			}
			//remove last comma
			$update_string = substr($update_string, 0, -1);
			$sql = "UPDATE ibc_listmembers SET $update_string WHERE email = '{$user_info['email']}' AND nl = '{$user_info['nl']}'";
			$result = @mysql_query($sql);
			if (!$result) {
				sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	} else {// if it doesn't exists, add to iBroadcast db
		$field_list = '';
		$values_list = '';
		$num_rows = 0;
		if (is_array($user_info)) {
			foreach($user_info as $key => $value) {
				$field_list .= "$key,";
				$values_list .= quote_smart($value).",";
			}
			//remove last comma
			$field_list = substr($field_list,0,-1);
			$values_list = substr($values_list,0,-1);
			$sql = "INSERT INTO ibc_listmembers ($field_list) VALUES ($values_list)";
			$result = @mysql_query($sql);
			if (!$result) {
				sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
				return false;
			} else {
				return true;
			}
		} else {
			return false;
		}
	}
	*/
	return true;
}
/**
 * @return null
 * @desc forwards $form to target app when finished processing
 */
function submitForm($form) {
	print "<script language=\"JavaScript\">document.$form.submit();</script>\n";
}
function log_transaction($results)  {
	 
	$sql = "INSERT INTO transactions (
				Response_Code,
				Response_Subcode,
				Response_Reason_Code,
				Response_Reason_Text,
				Approval_Code,
				AVS_Result_code,
				Transaction_ID,
				Invoice_Number,
				Description,
				Amount,
				Method,
				Transaction_Type,
				Customer_ID,
				Cardholder_First_Name,
				Cardholder_Last_Name,
				Company,
				Billing_Address,
				City,
				State,
				Zip,
				Country,
				Phone,
				Fax,
				Email,
				Ship_to_First_Name,
				Ship_to_Last_Name,
				Ship_to_Company,
				Ship_to_Address,
				Ship_to_City,
				Ship_to_State,
				Ship_to_Zip,
				Ship_to_Country,
				Tax_Amount,
				Duty_Amount,
				Freight_Amount,
				Tax_Exempt_Flag,
				PO_Number,
				MD5_Hash,
				Card_Code_Response_Code,
				CAVV_Response_Code)
			VALUES (
				'{$results['data'][1]}',
				'{$results['data'][2]}',
				'{$results['data'][3]}',
				'{$results['data'][4]}',
				'{$results['data'][5]}',
				'{$results['data'][6]}',
				'{$results['data'][7]}',
				'{$results['data'][8]}',
				'{$results['data'][9]}',
				'{$results['data'][10]}',
				'{$results['data'][11]}',
				'{$results['data'][12]}',
				'{$results['data'][13]}',
				'{$results['data'][14]}',
				'{$results['data'][15]}',
				'{$results['data'][16]}',
				'{$results['data'][17]}',
				'{$results['data'][18]}',
				'{$results['data'][19]}',
				'{$results['data'][20]}',
				'{$results['data'][21]}',
				'{$results['data'][22]}',
				'{$results['data'][23]}',
				'{$results['data'][24]}',
				'{$results['data'][25]}',
				'{$results['data'][26]}',
				'{$results['data'][27]}',
				'{$results['data'][28]}',
				'{$results['data'][29]}',
				'{$results['data'][30]}',
				'{$results['data'][31]}',
				'{$results['data'][32]}',
				'{$results['data'][33]}',
				'{$results['data'][34]}',
				'{$results['data'][35]}',
				'{$results['data'][36]}',
				'{$results['data'][37]}',
				'{$results['data'][38]}',
				'{$results['data'][39]}',
				'{$results['data'][40]}');";
	mysql_query($sql) or die ("Line ".__LINE__." in ".__FILE__.": ".mysql_error());
	// get id of inserted row
	$sql = "SELECT id FROM transactions WHERE Transaction_ID = '{$results['data'][7]}' and Email = '{$results['data'][24]}';";
	$result = mysql_query($sql) or die ("Line ".__LINE__." in ".__FILE__.": ".mysql_error());
	if (!$result) {
		return false;
	} else {
		$id = mysql_result($result,0,0);
		return $id;
	}
}
?>