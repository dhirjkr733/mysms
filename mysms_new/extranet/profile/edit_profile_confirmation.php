<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php'); ?>
<?php 
ob_start();
session_start();
header("Cache-control: private");
$confirm = false;
$logged_in = checkUser($_SESSION['userid']);
if ((!$logged_in) || ($_SESSION['userid'] !== $_POST['id'])) { // already logged in?
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
	ob_end_flush();
	if ($login_error == "") $login_error = "Your session has expired. Please <a href=\"".APPLICATION_HOME_PAGE."\">log in again</a>.";
	include_once($_SERVER['DOCUMENT_ROOT'].'/login_error.php');
	exit();
} else {
	switch ($_POST['user_action']) {
		case "edit":
			$error_msg = "";
			//validate registration form
			$error_msg = validate_form("edit_profile");
			if ($error_msg !== "") {
				//failed - return to form with error messages
				$return_form = $_POST;
				include_once('edit_profile.php');
			} else {
				//passed - make update
				$email = $_POST['email'];
				if ($_POST['new_password'] !== '') {
					$password = $_POST['new_password'];
				} else {
					$password = $_POST['password'];
				}
				$firstname = $_POST['firstname'];
				$lastname = $_POST['lastname'];
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
				unset($user_array);
				$user_array = Array (
							'email'=>$email,
							'password'=>$password,
							'firstname'=>$firstname,
							'lastname'=>$lastname,
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
							'registration_status'=>"Profile Update"
							);
				$log_result = updateProfileLog($_POST['id'],$user_array);
				$result = updateUser($_POST['id'],$user_array);
				if (!$result) {
					$mesg = "There was an error updating this user. Changes were NOT saved.<br>Please return to <a href=\"".EXTRANET_HOME_PAGE."\">MySMS Home</a>.";
				} else {
					$_SESSION['email'] = $email;
					$_SESSION['firstname'] = htmlspecialchars($firstname);
					$_SESSION['lastname'] = htmlspecialchars($lastname);
					$_SESSION['default_state'] = $state;
					$_SESSION['default_product'] = $default_product;
					$mailmsg = "
User information has been updated for: 

".htmlspecialchars($firstname)." ".htmlspecialchars($lastname)." 
$company 
$city, $state

";
					mail(REGISTRATION_ADMIN_EMAIL,"MySMS User Profile Update",$mailmsg,"From: ".ADMINISTRATION_EMAIL."\r\n");
					$mesg = "User information for <b>".htmlspecialchars($firstname)." ".htmlspecialchars($lastname)." <a href=\"/extranet/profile/edit_profile.php\">&lt;$email&gt;</a></b> was successfully updated.";
					$mesg .= "<br>Please continue to <a href=\"".EXTRANET_HOME_PAGE."\">MySMS Home</a>.";
				}
				$confirm = true;
			}
			break;
		default:
			$mesg = "No action was specified. Please return to <a href=\"".EXTRANET_HOME_PAGE."\">MySMS Home</a>.";
			$confirm = true;
			break;
	}
}	
if ($confirm) {
	ob_end_flush();
	$user_info = getUser($_SESSION['userid']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>First American SMS</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="/mysms.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="5" topmargin="0" marginwidth="0" marginheight="0">


<?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/header.php'); ?>
<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="188" height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="188" height="300"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/subnav_profile.php'); ?></td>
    <td width="1" bgcolor="#CCCCCC"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
        <tr bgcolor="#FFCC00" class="textbody">
          <td bgcolor="#FFCC00"><table width="515" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="textbody"><b>Edit Profile: <font color="#CC0000"><?php print htmlspecialchars($user_info['firstname'])." ".htmlspecialchars($user_info['lastname']); ?></font></b></td>
              <td width="250" align="right">&nbsp;</td>
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
      </td>
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
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/footer.php'); ?>
<p>&nbsp;</p>
</body>
</html>
<?php
}
?>