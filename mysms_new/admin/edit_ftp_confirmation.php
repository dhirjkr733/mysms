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
	switch ($_POST['ftp_action']) {
		case "add":
			$error_msg = "";
			//validate form
			$error_msg = validate_form("add_ftp");
			if ($error_msg !== "") {
				//failed - return to form with error messages
				$return_form = $_POST;
				include_once('ftp_add.php');
			} else {
				//passed - insert record
				$product = $_POST['product'];
				$server = $_POST['server'];
				$directory = $_POST['directory'];
				$type = $_POST['type'];
				$username = $_POST['username'];
				$password = $_POST['password'];
				unset($ftp_array);
				$ftp_array = Array (
							'product'=>$product, 
							'server'=>$server,
							'directory'=>$directory,
							'type'=>$type,
							'username'=>$username,
							'password'=>$password
							);
				$result = insertFTP($ftp_array);
				if (!$result) {
					$mesg = "There was an error updating this FTP location. Changes were NOT saved.<br>Please return to <a href=\"ftp_settings.php\">MySMS FTP Administration</a>.";
				} else {
					$mesg = "FTP information for <b>$product</b> was successfully added.<br>Please continue to <a href=\"ftp_settings.php\">MySMS FTP Administration</a>.";
				}
				$confirm = true;
			}
			break;
		case "edit":
			$error_msg = "";
			//validate registration form
			$error_msg = validate_form("edit_ftp");
			if ($error_msg !== "") {
				//failed - return to form with error messages
				$return_form = $_POST;
				include_once('ftp_detail.php');
			} else {
				//passed - make update
				if ($_POST['new_password'] !== '') {
					$password = $_POST['new_password'];
				} else {
					$password = $_POST['password'];
				}
				$server = $_POST['server'];
				$directory = $_POST['directory'];
				$type = $_POST['type'];
				$username = $_POST['username'];
				unset($ftp_array);
				$ftp_array = Array (
							'server'=>$server,
							'directory'=>$directory,
							'type'=>$type,
							'username'=>$username,
							'password'=>$password
							);
				$result = updateFTP($_POST['id'],$ftp_array);
				if (!$result) {
					$mesg = "There was an error updating this FTP location. Changes were NOT saved.<br>Please return to <a href=\"ftp_settings.php\">MySMS FTP Administration</a>.";
				} else {
					$mesg = "User information for <b>{$POST['product']}</b> was successfully updated.<br>Please continue to <a href=\"ftp_settings.php\">MySMS FTP Administration</a>.";
				}
				$confirm = true;
			}
			break;
		case "delete":
			//delete record
			$result = deleteFTP($_POST['id']);
			if (!$result) {
				$mesg = "There was an error deleting this FTP location. Changes were NOT saved.<br>Please return to <a href=\"ftp_settings.php\">MySMS FTP Administration</a>.";
			} else {
				$mesg = "The FTP location was successfully deleted.<br>Please continue to <a href=\"ftp_settings.php\">MySMS FTP Administration</a>.";
			}
			$confirm = true;
			break;
		default:
			$mesg = "No action was specified. Please return to <a href=\"ftp_settings.php\">MySMS FTP Administration</a>.";
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
              <td class="textbody"><b>MySMS FTP Administration</b></td>
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