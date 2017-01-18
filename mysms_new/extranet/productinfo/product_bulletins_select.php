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
if (isset($_POST['product'])) {
	$product = $_POST['product'];
} else {
	$product = $_SESSION['default_product'];
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>First American SMS</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../mysms.css" rel="stylesheet" type="text/css">
<script language="javascript">
function selectProduct() {
	frm = document.change_product;
	frm.submit();
}
</script>
</head>

<body leftmargin="5" topmargin="0" marginwidth="0" marginheight="0">
	<SCRIPT language=JavaScript src="../js/mysms_array.js" type=text/javascript></SCRIPT>
	<SCRIPT language=JavaScript src="../js/mysms.js" type=text/javascript></SCRIPT>
  <a name="top"></a>

<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td align="right"><a href="/index.php"><img src="../../../images/logo_topleft.gif" width="170" height="80" hspace="0" vspace="0" border="0"></a><img src="../../images/mysms_header.jpg" width="585" height="80" hspace="0" vspace="0"></td>
  </tr>
  <tr>
    <td height="23" bgcolor="#0F1477">&nbsp;</td>
  </tr>
</table>
<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="10">&nbsp;</td>
    <td width="727" height="23" valign="middle" class="text1">Back to: <a href="/index.php" class="text1">firstamsms.com</a> &raquo; <a href="../index.php" class="text1">MySMS</a></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td colspan="2"><img src="../../images/spacer.gif" width="1" height="1"></td>
  </tr>
</table>
<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="188" height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="../../../images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="../../../images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="188" height="77"><?php require_once('../includes/subnav_productinfo.php'); ?></td>
    <td width="1" bgcolor="#CCCCCC"><img src="../../../images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="1">
      <tr bgcolor="#FFCC00" class="textbody">
        <td colspan="2" bgcolor="#FFCC00"><b>Product Bulletins </b></td>
      </tr>
      <tr bgcolor="#EDEDED">
        <td bgcolor="#FFFFFF" class="textbody">&nbsp;</td>
        <td bgcolor="#FFFFFF" class="textbody">&nbsp;</td>
      </tr>
      <form name="change_product" method="POST">
      <tr valign="top" bgcolor="#EDEDED">
        <td width="131" bgcolor="#FFFFFF" class="textbody"><?php showProductSelect('product', '', '', 'Select Product', ''); ?></td>
        <td width="371" bgcolor="#FFFFFF" class="textbody"><img src="../../images/arrow2.gif" width="4" height="17" align="absmiddle"> <a href="javascript:selectProduct();">Go</a></td>
      </tr>
      </form>
    </table>
    <p>&nbsp;</p></td>
    <td width="1" bgcolor="#FFFFFF"><img src="../../../images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="188" height="19">&nbsp;</td>
    <td width="1"><img src="../../../images/pixel.gif" width="1" height="1"></td>
    <td width="188">&nbsp;</td>
    <td width="1"><img src="../../../images/pixel.gif" width="1" height="1"></td>
    <td width="188">&nbsp;</td>
    <td width="1"><img src="../../../images/pixel.gif" width="1" height="1"></td>
    <td width="187">&nbsp;</td>
    <td width="1"><img src="../../../images/pixel.gif" width="1" height="1"></td>
  </tr>
</table>
<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#CCCCCC">
    <td colspan="2"><img src="../../../images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td width="696" height="40" align="center" valign="middle" bgcolor="EDEDED" class="text1">
      <P>&copy; <?php echo date("Y") ?> First American SMS (800) 767-7832 (714) 998-1111<br>
        <a href="#" class="text1">Legal Notices</a>  | <a href="#" class="text1">Privacy Policy</a><STRONG><br>
    </STRONG></P>
    </td>
    <td width="55" align="center" valign="middle" bgcolor="#EDEDED" class="text1"><a href="#top" class="text1">Top</a></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td width="696" colspan="2"><img src="../../../images/pixel.gif" width="1" height="1"></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
