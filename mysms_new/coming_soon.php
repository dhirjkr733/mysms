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
<title>MYSMS Support and Training (FASMS Home Page)</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="keywords" content="support connection, email the help desk, chat support, Centra login, industry links, connect your representative, initiate a remote session" />
<meta name="description" content="Access online support tools and find answers to common questions" />
<link href="mysms.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
function flvFPW1(){// v1.3
// Copyright 2002, Marja Ribbers-de Vroed, FlevOOware (www.flevooware.nl/dreamweaver/)
var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16,v17,v18;if (v4>1){v10=screen.width;for (v6=0;v6<v2.length;v6++){v18=v2[v6].split("=");if (v18[0]=="width"){v8=parseInt(v18[1]);}if (v18[0]=="left"){v9=parseInt(v18[1]);v11=v6;}}if (v4==2){v7=(v10-v8)/2;v11=v2.length;}else if (v4==3){v7=v10-v8-v9;}v2[v11]="left="+v7;}if (v5>1){v14=screen.height;for (v6=0;v6<v2.length;v6++){v18=v2[v6].split("=");if (v18[0]=="height"){v12=parseInt(v18[1]);}if (v18[0]=="top"){v13=parseInt(v18[1]);v15=v6;}}if (v5==2){v7=(v14-v12)/2;v15=v2.length;}else if (v5==3){v7=v14-v12-v13;}v2[v15]="top="+v7;}v16=v2.join(",");v17=window.open(v1[0],v1[1],v16);if (v3){v17.focus();}document.MM_returnValue=false;}
//-->
</script>

<script type="text/javascript">
        function pullQueryString() {
            var error = window.location.search;
            if (error.substring(0, 1) == "?") {
                error = error.substring(1);
            }
            return error;
        }
    </script>
</head>

<body leftmargin="5" topmargin="0" marginwidth="0" marginheight="0">

<?php// require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/header.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/header.php'); ?>

<table width="755" border="0" cellspacing="0" cellpadding="20">
  <tr>
    <td align="center"><img src="images/coming_soon.jpg"></td>
  </tr>
</table>
<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#CCCCCC">
    <td colspan="2"><img src="../images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td width="696" height="40" align="center" valign="middle" bgcolor="EDEDED" class="text1">
      <P>&copy; <?php echo date("Y") ?> First American SMS  (800) 767-7832<br>
        <a href="http://www.firstamprs.com/content/privacy-information" class="text1" onClick="flvFPW1(this.href,'legal','width=980,height=600,scrollbars=yes',1);return document.MM_returnValue">Privacy Policies & Legal Notice</a><STRONG><br>
    </STRONG></P>
    </td>
    <td width="55" align="center" valign="middle" bgcolor="#EDEDED" class="text1"><a href="#top" class="text1">Top</a></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td width="696" colspan="2"><img src="../images/pixel.gif" width="1" height="1"></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
