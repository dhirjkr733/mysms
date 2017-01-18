<?php
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php'); 
$msg = "";
$confirm = true;
if ($_POST['action'] === 'change_password') {
	if (valid_email($_POST["email"])) {
		if ($_POST["email"] == $_SESSION['email']) {
			db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
			$email_sql = "SELECT id FROM users WHERE email=".quote_smart($_POST["email"])." AND password=ENCODE('{$_SESSION['old_password']}','".SALT."')";
			$email_result = @mysql_query($email_sql);
			$email_count = @mysql_num_rows($email_result);
			//print $email_sql;
			if ($email_count == 1) {
				$row = mysql_fetch_array($email_result);
				$error_msg = validate_form("change_password");
				if ($error_msg === '') {
					$email_sql = "UPDATE users SET password = ENCODE('".$_POST["password"]."','".SALT."'),password_expires=DATE_ADD(CURDATE(), INTERVAL 90 DAY),last_login=NOW() WHERE id='".$row['id']."'";
					$email_result = @mysql_query($email_sql);
					if (!$email_result) {
						sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
						$msg = "There was an error updating your account information. Please <a href=\"change_password.php\">try again</a>.";
					} else {
						unset($_SESSION['change_password']);
						$_SESSION['logged_in'] = true;
						$msg = "Thank you. Your password was updated. Please <a href='/extranet/index.php'>Click here</a> to continue.";	
						$email_sql = "INSERT INTO password_log (password,usersid) VALUES (ENCODE('".$_POST["password"]."','".SALT."'),'".$row['id']."')";
						$email_result = @mysql_query($email_sql);
					}
				} else {
					$confirm = false;
					include_once('change_password.php');
				}
			} else {
				$msg = "There is no account registered under the Email Address provided. Please <a href=\"change_password.php\">try again</a>.";
			}
		} else {
			$msg = "The Email Address provided is not associated with this account. Please <a href=\"change_password.php\">try again</a>.";
		}
	} else {
		$error_msg = "Please enter the Email Address associated with this account.";
		$confirm = false;
		include_once('change_password.php');
	}
} else {
	$msg .= "You are not authorized to view this page.";
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
}
if ($confirm) {
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


<?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/header.php'); ?>
<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="188" height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="188" height="300"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/subnav_profile.php'); ?>
    <br>
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/subnav_logregister.php'); ?></td>
    <td width="1" bgcolor="#CCCCCC"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
      <tr bgcolor="#FFCC00" class="textbody">
        <td bgcolor="#FFCC00"><table width="515" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="321" class="textbody"><b>Change Your Password?</b></td>
              <td width="194" align="right">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td valign="top" bgcolor="#FFFFFF" class="text1"><p><?php print $msg; ?> </p>
          </td>
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