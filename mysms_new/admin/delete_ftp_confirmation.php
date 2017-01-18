<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php'); ?>
<?php 
ob_start();
session_start();
header("Cache-control: private");
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
	ob_end_flush();
	$ftp_info = getFTPbyId($_POST['ftpid']);
}	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>First American SMS: MySMS Admin</title>
 
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
              <td class="textbody"><b>Delete MySMS FTP Location</b></td>
              <td align="right">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td valign="top" bgcolor="#FFFFFF" class="text1"><p><b><font color="#CC0000">ARE YOU SURE YOU WANT TO DELETE THIS RECORD??</b><br>
        Cannot be undone.</p></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td class="text1">&nbsp;</td>
      </tr>
    </table>
      <table width="100%"  border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" id="desc">
        <tr bgcolor="#EDEDED">
          <td valign="top" bgcolor="#FFFFFF" class="textbody">
          <?php
          	if (is_array($ftp_info)) {
          		form_delete_FTP($ftp_info);
          	} else {
          		print "Invalid location id. No ftp location returned.";
          	} 
          ?></td>
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