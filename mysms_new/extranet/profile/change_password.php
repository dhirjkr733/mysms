<?php 
session_start();
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php');
if (isset($_SESSION['change_password'])) {
	if ($_SESSION['change_password'] === true) {
		$logged_in = true;
	} else {
		$logged_in = false;
	}
} else {
	$logged_in = false;
}
if (!$logged_in) {
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
	if ($login_error == "") $login_error = "Your session has expired. Please <a href=\"".APPLICATION_HOME_PAGE."\">log in again</a>.";
	include_once($_SERVER['DOCUMENT_ROOT'].'/login_error.php');
} else {
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
              <td width="321" class="textbody"><b>Change Your Password</b></td>
              <td width="194" align="right">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td valign="top" bgcolor="#FFFFFF" class="text1"><p>Your password has expired. Please enter your e-mail address and a new password below.</p>
        <?php if(isset($error_msg)) print "<p><font color=\"#CC0000\">$error_msg</font></p>"; ?>
          <form name="change_password" method="POST" action="/extranet/profile/change_password_confirm.php">
			  <table width="170" border="0" align="center" cellpadding="0" cellspacing="0">
			    <tr>
			      <td height="15" class="text1"><img src="/images/spacer.gif" width="1" height="1"></td>
			    </tr>
			    <tr>
			      <td class="text1">E-mail Address<br>
			          <input name="email" type="text" size="18">
			      </td>
			    </tr>
			    <tr>
			      <td height="5" class="text1"><img src="/images/spacer.gif" width="1" height="1"></td>
			    </tr>
			    <tr>
			      <td class="text1">New MySMS Password<br>
			          <input name="password" type="password" size="18">
			      </td>
			    </tr>
			    <tr>
			      <td height="5" class="text1"><img src="/images/spacer.gif" width="1" height="1"></td>
			    </tr>
			    <tr>
			      <td class="text1">Confirm New MySMS Password<br>
			          <input name="password1" type="password" size="18">
			      </td>
			    </tr>
			    <tr>
			      <td height="5" class="text1"><img src="/images/spacer.gif" width="5" height="5">
			      <input name="action" type="hidden" size="18" value="change_password"></td>
			    </tr>
			    <tr>
			      <td class="nav1"><table width="170" border="0" cellspacing="0" cellpadding="0">
			          <tr>
			            <td width="10"><img src="/images/arrow2.gif" width="4" height="17"></td>
			            <td width="46"><a href="javascript:document.change_password.submit();">Submit</a></td>
			            <td width="10">&nbsp;</td>
			            <td width="104">&nbsp;</td>
			          </tr>
			      </table></td>
			    </tr>
			    <tr>
			      <td height="10" class="text1"><img src="/images/spacer.gif" width="5" height="5"></td>
			    </tr>
			    <tr>
			      <td></td>
			    </tr>
			  </table>
          </form></td>
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