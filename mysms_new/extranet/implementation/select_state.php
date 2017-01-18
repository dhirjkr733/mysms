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

<link href="../../mysms.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
function flvFPW1(){// v1.3
// Copyright 2002, Marja Ribbers-de Vroed, FlevOOware (www.flevooware.nl/dreamweaver/)
var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16,v17,v18;if (v4>1){v10=screen.width;for (v6=0;v6<v2.length;v6++){v18=v2[v6].split("=");if (v18[0]=="width"){v8=parseInt(v18[1]);}if (v18[0]=="left"){v9=parseInt(v18[1]);v11=v6;}}if (v4==2){v7=(v10-v8)/2;v11=v2.length;}else if (v4==3){v7=v10-v8-v9;}v2[v11]="left="+v7;}if (v5>1){v14=screen.height;for (v6=0;v6<v2.length;v6++){v18=v2[v6].split("=");if (v18[0]=="height"){v12=parseInt(v18[1]);}if (v18[0]=="top"){v13=parseInt(v18[1]);v15=v6;}}if (v5==2){v7=(v14-v12)/2;v15=v2.length;}else if (v5==3){v7=v14-v12-v13;}v2[v15]="top="+v7;}v16=v2.join(",");v17=window.open(v1[0],v1[1],v16);if (v3){v17.focus();}document.MM_returnValue=false;}
//-->
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
    <td width="188" height="77"><?php require_once('../includes/subnav_implementation.php'); ?></td>
    <td width="1" bgcolor="#CCCCCC"><img src="../../../images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="1">
      <tr bgcolor="#FFCC00" class="textbody">
          <td colspan="2" bgcolor="#FFCC00"><b>Please Select State of Implementation</b></td>
        </tr>
        <tr valign="middle" bgcolor="#EDEDED">
          <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
          <td bgcolor="#FFFFFF">&nbsp;</td>
        </tr>
        <tr valign="middle" bgcolor="#EDEDED">
          <td width="148" valign="top" bgcolor="#FFFFFF"><?php showStateSelect('state', '', '', 'Select State', ''); ?></td>
          <td width="354" bgcolor="#FFFFFF"><img src="../../images/arrow2.gif" width="4" height="17" align="absmiddle"> <a href="implementation_coordinators.php">Go</a></td>
        </tr>
      </table>
      <p align="center" class="text1">&nbsp;</p></td><td width="1" bgcolor="#FFFFFF"><img src="../../../images/pixel.gif" width="1" height="1"></td>
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
    <td width="696" height="40" align="center" valign="middle" bgcolor="EDEDED" class="text1"><P>Copyright 2004 First American SMS. SMS Title and Escrow Software Solutions (800) 767-7832 (714) 998-1111<br>
        <a href="http://www.firstamprs.com/content/privacy-information" class="text1" onClick="flvFPW1(this.href,'legal','width=980,height=600,scrollbars=yes',1);return document.MM_returnValue">Privacy Policies & Legal Notice</a><STRONG><br>
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
