<?php 
ob_start();
session_start();
header("Cache-control: private");
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php');
$logged_in = checkUser($_SESSION['userid']);
if (!$logged_in) { // already logged in?
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
	ob_end_flush();
	if ($login_error == "") $login_error = "Your session has expired. Please <a href=\"".APPLICATION_HOME_PAGE."\">log in again</a>.";
	include_once($_SERVER['DOCUMENT_ROOT'].'/login_error.php');
	exit();
}
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
    <td width="188" height="300"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/subnav_documents.php'); ?></td>
    <td width="1" bgcolor="#CCCCCC"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
        <tr bgcolor="#FFCC00" class="textbody">
          <td bgcolor="#FFCC00"><table width="515" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="textbody"><b>Logos</b></td>
              <td width="250" align="right">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="text1">Description of the screen/instructions will go here </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="text1">&nbsp;</td>
        </tr>
      </table>
      <table width="525"  border="0" align="center" cellpadding="5" cellspacing="1" id="files">
        <tr bgcolor="#CCCCCC" class="textbody">
          <td width="334"><b>Description</b></td>
          <td><b>File Size </b></td>
          <td align="center"><b> View </b></td>
        </tr>
        <tr bgcolor="#EDEDED" class="text1">
          <td class="text1">Logo Requirements &amp; Instructions</td>
          <td width="80" class="text1">100k</td>
          <td width="110" align="center" class="text1"><img src="/images/arrow4.gif" width="4" height="17" align="absmiddle"> <a href="#" class="text1">View/Download</a></td>
        </tr>
        <tr bgcolor="#EDEDED" class="text1">
          <td class="text1">&nbsp;</td>
          <td width="80" class="text1">&nbsp;</td>
          <td width="110" align="center" class="text1">&nbsp;</td>
        </tr>
        <tr bgcolor="#EDEDED" class="text1">
          <td class="text1">&nbsp;</td>
          <td width="80" class="text1">&nbsp;</td>
          <td width="110" align="center" class="text1">&nbsp;</td>
        </tr>
        <tr bgcolor="#EDEDED" class="text1">
          <td class="text1">&nbsp;</td>
          <td width="80" class="text1">&nbsp;</td>
          <td width="110" align="center" class="text1">&nbsp;</td>
        </tr>
      </table>
      <p><a href=yourlink.html onmouseover=popup("support") onmouseout=popdown()><font size=3 color=green>Support</font></a>
</p>
      <p><a href=yourlink.html onmouseover=popup("feedback") onmouseout=popdown()><font size=3 color=green>Feedback</font></a> </p>
    <!--       <table width="525"  border="0" align="center" cellpadding="5" cellspacing="1" id="pagelinks">
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
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/footer.php'); ?>
<p>&nbsp;</p>
</body>
</html>
