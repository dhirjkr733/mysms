<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php'); ?>
<?php 
ob_start();
session_start();
header("Cache-control: private");
$confirm = false;
$logged_in = checkUser($_SESSION['userid'],true);
if (!$logged_in) { // already logged in?
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
	ob_end_flush();
	if ($login_error == "") $login_error = "Your session has expired. Please <a href=\"/admin/index.php\">log in again</a>.";
	include_once($_SERVER['DOCUMENT_ROOT'].'/admin/login_error.php');
	exit();
} else {
	switch ($_POST['user_action']) {
		case "add":
			$error_msg = "";
			//validate registration form
			$error_msg = validate_form("add_user");
			if ($error_msg !== "") {
				//failed - return to form with error messages
				$return_form = $_POST;
				include_once('user_add.php');
			} else {
				//passed - process registrant
				$email = $_POST['email'];
				$password = $_POST['password'];
				$firstname = $_POST['firstname'];
				$lastname = $_POST['lastname'];
				$clientid = $_POST['clientid'];
				$title = $_POST['title'];
				$company = $_POST['company'];
				$address = $_POST['address'];
				$city = $_POST['city'];
				$state = $_POST['state'];
				if ($state === "CA") {
					$county = $_POST['county'];
				} else {
					$county = "";
				}
				$zip = $_POST['zip'];
				$phone = fix_phone_in("phone");
				$fax = fix_phone_in("fax");
				$default_product = $_POST['default_product'];
				$signup_date = date("Ymd");
				$registration_status = 'Approved';
				$computer_details = $_SERVER['HTTP_USER_AGENT'];
				$ip_address = $_SERVER['REMOTE_ADDR'];
				//add to db as pending registrant
				$user_array = Array (
							'email'=>$email,
							'password'=>$password,
							'firstname'=>$firstname,
							'lastname'=>$lastname,
							'clientid'=>$clientid,
							'title'=>$title,
							'company'=>$company,
							'address'=>$address,
							'city'=>$city,
							'state'=>$state,
							'county'=>$county,
							'zip'=>$zip,
							'phone'=>$phone,
							'fax'=>$fax,
							'default_product'=>$default_product,
							'signup_date'=>$signup_date,
							'registration_status'=>$registration_status,
							'computer_details'=>$computer_details,
							'ip_address'=>$ip_address
							);
				$result = insertUser($user_array);
				if (!$result) {
					$mesg = "There was an error adding this user. Changes were NOT saved.<br>Please return to <a href=\"user_summary.php\">User Summary</a>.";
				} else {
					$mailmsg = "
Dear $firstname,
					
Congratulations! As part of your First American SMS system installation, we have automatically registered you for MySMS. This is a website where First American SMS customers can access current news and information as well as support and etraining tools.

Your MySMS login and password is:
Login: $email
Password: $password

To log into MySMS, simply go to ".APPLICATION_HOME_PAGE." and enter your email address and password. (Don't forget to add this to your favorites!) 

If you have any questions regarding your login, please contact us at ".ADMINISTRATION_EMAIL."

Welcome to MySMS!

";
					mail($email,"MySMS Registration Confirmation",$mailmsg,"From: ".ADMINISTRATION_EMAIL."\r\n");
					$mesg = "User information for <b>".htmlspecialchars($firstname)." ".htmlspecialchars($lastname)." <a href=\"mailto:$email\">&lt;$email&gt;</a></b> was successfully registered.<br>Please continue to <a href=\"user_summary.php\">User Summary</a>.";
				}
				$confirm = true;
			}
			break;
		case "edit":
			$error_msg = "";
			//validate registration form
			$error_msg = validate_form("edit_user");
			if ($error_msg !== "") {
				//failed - return to form with error messages
				$return_form = $_POST;
				include_once('user_detail.php');
			} else {
				//passed - make update
				//get old user info
				$old_user = getUser($_POST['id']);
				//update with new
				$email = $_POST['email'];
				if ($_POST['new_password'] !== '') {
					$password = $_POST['new_password'];
				} else {
					$password = $_POST['password'];
				}
				$firstname = $_POST['firstname'];
				$lastname = $_POST['lastname'];
				$clientid = $_POST['clientid'];
				$title = $_POST['title'];
				$company = $_POST['company'];
				$address = $_POST['address'];
				$city = $_POST['city'];
				$state = $_POST['state'];
				if ($state === "CA") {
					$county = $_POST['county'];
				} else {
					$county = "";
				}
				$zip = $_POST['zip'];
				$phone = fix_phone_in("phone");
				$fax = fix_phone_in("fax");
				$default_product = $_POST['default_product'];
				$registration_status = $_POST['registration_status'];
				unset($user_array);
				$user_array = Array (
							'email'=>$email,
							'password'=>$password,
							'firstname'=>$firstname,
							'lastname'=>$lastname,
							'clientid'=>$clientid,
							'title'=>$title,
							'company'=>$company,
							'address'=>$address,
							'city'=>$city,
							'state'=>$state,
							'county'=>$county,
							'zip'=>$zip,
							'phone'=>$phone,
							'fax'=>$fax,
							'default_product'=>$default_product,
							'registration_status'=>$registration_status
							);
				$result = updateUser($_POST['id'],$user_array);
				if (!$result) {
					$mesg = "There was an error updating this user. Changes were NOT saved.<br>Please return to <a href=\"user_summary.php\">User Summary</a>.";
				} else {
					if ((trim($old_user['registration_status']) !== trim($registration_status))) {
						if ((trim($old_user['registration_status']) == "Pending") && ($registration_status == "Approved")) {
							$mailmsg = "
Dear $firstname,

Congratulations! Your registration for the MySMS website has been approved. Your MySMS login and password is:
Login: $email
Password: $password

At MySMS, you can access current news and information as well as support and training tools. To log into MySMS, simply go to ".APPLICATION_HOME_PAGE." and enter your email address and password. (Don't forget to add this to your favorites!) 

If you have any questions regarding your login, please contact us at ".ADMINISTRATION_EMAIL."

Welcome to MySMS!

";
							mail($email,"MySMS Registration Confirmation",$mailmsg,"From: ".ADMINISTRATION_EMAIL."\r\n");
						}
					}
					$mesg = "User information for <b>$firstname $lastname <a href=\"mailto:$email\">&lt;$email&gt;</a></b> was successfully updated.<br>Please continue to <a href=\"user_summary.php\">User Summary</a>.";
				}
				$confirm = true;
			}
			break;
		case "delete":
			$email = $_POST['email'];
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$result = deleteUser($_POST['id']);
			if (!$result) {
				$mesg = "There was an error deleting this user. <br>Please return to <a href=\"user_summary.php\">User Summary</a>.";
			} else {
				$mesg = "User information for <b>$firstname $lastname <a href=\"mailto:$email\">&lt;$email&gt;</a></b> was successfully deleted.<br>Please continue to <a href=\"user_summary.php\">User Summary</a>.";
			}
			$confirm = true;
			break;
		case "save_settings":
			db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
			$sql = "SELECT * FROM admin_settings";
			$result = mysql_query($sql);
			if (!$result) {
				sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
				$mesg = "There was an error retrieving your admin settings. Please <a href=\"mysms_settings.php\">try again</a>.";
			} else {
				$mesg = "";
				while ($row = mysql_fetch_assoc($result)) {	
					switch ($row['type']) {
						case "select":
						case "textarea":
						case "checkbox":
						case "radio":
						default:
							if (array_key_exists("config_".$row['id'],$_POST)) {
								//check to see if different
								$new_value = $_POST["config_".$row['id']];
								if ($new_value != $row['value']) {
									$change_sql = "UPDATE admin_settings SET value='$new_value',last_modified=NOW() WHERE id = '{$row['id']}'";
									$change_result = mysql_query($change_sql);
									if (!$change_result) {
										$mesg .= "<font color=\"#CC0000\">{$row['title']} was NOT updated.</font><br>\n";
									} else {
										$mesg .= "{$row['title']} was updated.<br>\n";
									}
								}
							}
							break;
					}
				}
			}
			$confirm = true;
			break;
		default:
			$mesg = "No action was specified. Please return to <a href=\"user_summary.php\">User Summary</a>.";
			$confirm = true;
			break;
	}
}	
if ($confirm) {
	ob_end_flush();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>First American SMS</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="/mysms.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.uploadinputs {
	width: 220px;
}
.uploadinputs2 {
	width: 355px;
}
-->
</style>
</head>

<body leftmargin="5" topmargin="0" marginwidth="0" marginheight="0">
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/header_admin.php'); ?>
<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="188" height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td colspan="7" valign="top" bgcolor="#FFFFFF"><table width="100%"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
      <tr bgcolor="#FFCC00" class="textbody">
        <td bgcolor="#FFCC00"><table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="textbody"><b>MySMS Admin</b></td>
              <td align="right">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td valign="top" bgcolor="#FFFFFF" class="text1"><p><?php print $mesg; ?></p></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td class="text1">&nbsp;</td>
      </tr>
    </table>
      <!-- <table width="525"  border="0" align="center" cellpadding="5" cellspacing="1" id="pagelinks">
        <tr bgcolor="#FFFFFF">
          <td width="310" class="textbody">Page <a href="#">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a> </td>
          <td width="192" align="right" class="textbody"><a href="#">Previous</a> | <a href="#">Next</a> </td>
        </tr>
      </table> --></td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="188" height="19">&nbsp;</td>
    <td width="1"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td width="188">&nbsp;</td>
    <td width="1"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td width="188">&nbsp;</td>
    <td width="1"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td width="187">&nbsp;</td>
    <td width="1"><img src="/images/pixel.gif" width="1" height="1"></td>
  </tr>
</table>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/footer.php'); ?>
<p>&nbsp;</p>
</body>
</html>
<?php
}
?>