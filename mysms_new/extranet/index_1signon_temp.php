<?php 
ob_start();
session_start();
header("Cache-control: private");
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php');
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/single_signon_test.php');

$change_password = false;
$login_error = "";
if (isset($_POST['login'])) {// coming from login form
	if ((trim($_POST["email"]) !== "") && (trim($_POST['password']) !== "")) {
		db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
		//$email = quote_smart($_POST["email"]);
		$email = $_POST["email"] ;
		$password = $_POST["password"];
		// Do single sign on first
		if (!$user_info = ValidateSMS($email, $password)) {
			$login_error = "There was an error retrieving your account information. Please <a href=\"".APPLICATION_HOME_PAGE."\">try again</a>.";
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
		}
		else {
			switch ($user_info['LoginResponse']['LoginStatus']['Status']) {
				case "Pending":
					$login_error = $user_info['LoginResponse']['LoginStatus']['Message'];
				break;
				case "Active": case "Approved": case 'Approved-Activated':
					$today = date('Y-m-d');
					$logged_in = true;
					$_SESSION['logged_in'] = true;

					$userid = '';
					//set remember me cookie//
					if($_POST["remeberme"] == 'on')
					  setcookie("ftp", $user_info['LoginResponse']['UserInformation']['EmailAddress'], time() + (3600 * 24 * 365),'/');
					else
					  setcookie("ftp", '', time() - 3600,'/');  

					// TODO: Replace the session values with data coming back from webserive 
					$_SESSION['change_password'] = "";
					$_SESSION['userid'] = $userid;
					$_SESSION['email'] = $user_info['LoginResponse']['UserInformation']['EmailAddress'];
					$_SESSION['firstname'] = htmlspecialchars($user_info['LoginResponse']['UserInformation']['FirstName']);
					$_SESSION['lastname'] = htmlspecialchars($user_info['LoginResponse']['UserInformation']['LastName']);
					$_SESSION['default_state'] = $user_info['LoginResponse']['ActiveCompanies'][0]['CompanyInformation']['State'];
					$_SESSION['default_product'] = $user_info['LoginResponse']['DefaultProduct']['ProductName'];
					$_SESSION['usertoken'] = $user_info['LoginResponse']['UserToken'] ;
					
					// CREATE DB SESSION LOG
					$log_sql = "INSERT INTO `login_session` VALUES ('" . session_id() . "','" . $user_info['LoginResponse']['UserToken'] . "', NOW())";
					mysql_query($log_sql);
				default:
					if (stristr($user_info['LoginResponse']['LoginStatus']['Message'], 'because your registration status has changed') !== false) {
						$login_error = "You cannot be logged in because your registration status has changed.<br>";
						$login_error .= "Please contact MySMS support at ".CUSTOMER_SUPPORT_EMAIL." or ".CUSTOMER_SUPPORT_PHONE.".";
					} else {
						$login_error = "Your username or password was incorrect. Please <a href=\"".APPLICATION_HOME_PAGE."\">click here</a> to try again.";
					}
				break;
			}
		}
	} else {
		$login_error = "Your E-mail Address and/or MySMS Password was missing. Please <a href=\"".APPLICATION_HOME_PAGE."\">try again</a>.";
	}
} else {
	$logged_in = checkUser($_SESSION['userid']);
}

if (!$logged_in) {
	if ($change_password) {
		include_once($_SERVER['DOCUMENT_ROOT'].'/extranet/profile/change_password.php');
		ob_end_flush();
	} else {
		$_SESSION = array();
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-42000, '/');
		}
		session_destroy();
		ob_end_flush();
		if ($login_error == "") $login_error = "Your session has expired. Please <a href=\"".APPLICATION_HOME_PAGE."\">log in again</a>.";
		include_once($_SERVER['DOCUMENT_ROOT'].'/login_error.php');
	}
} else {
	ob_end_flush();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>First American SMS</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../mysms.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--

function flvFPW1(){// v1.4
// Copyright 2003, Marja Ribbers-de Vroed, FlevOOware (www.flevooware.nl/dreamweaver/)
var v1=arguments,v2=v1[2].split(","),v3=(v1.length>3)?v1[3]:false,v4=(v1.length>4)?parseInt(v1[4]):0,v5=(v1.length>5)?parseInt(v1[5]):0,v6,v7=0,v8,v9,v10,v11,v12,v13,v14,v15,v16,v17,v18;if (v4>1||v1[2].indexOf("%")>-1){v10=screen.width;for (v6=0;v6<v2.length;v6++){v18=v2[v6].split("=");if (v18[0]=="width"){v8=parseInt(v18[1]);if (v18[1].indexOf("%")>-1){v8=(v8/100)*v10;v2[v6]="width="+v8;}}if (v18[0]=="left"){v9=parseInt(v18[1]);v11=v6;}}if (v4==2){v7=(v10-v8)/2;v11=v2.length;}else if (v4==3){v7=v10-v8-v9;}v2[v11]="left="+v7;}if (v5>1||v1[2].indexOf("%")>-1){v14=screen.height;for (v6=0;v6<v2.length;v6++){v18=v2[v6].split("=");if (v18[0]=="height"){v12=parseInt(v18[1]);if (v18[1].indexOf("%")>-1){v12=(v12/100)*v14;v2[v6]="height="+v12;}}if (v18[0]=="top"){v13=parseInt(v18[1]);v15=v6;}}if (v5==2){v7=(v14-v12)/2;v15=v2.length;}else if (v5==3){v7=v14-v12-v13;}v2[v15]="top="+v7;}v16=v2.join(",");v17=window.open(v1[0],v1[1],v16);if (v3){v17.focus();}document.MM_returnValue=false;}
//-->
</script>
</head>

<body leftmargin="5" topmargin="0" marginwidth="0" marginheight="0">

  <a name="top"></a>
  <?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/header_test.php'); ?>
  <table width="755" height="150" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="180"><img src="/images/toppic_home.jpg" width="181" height="150" vspace="0"></td>
    <td width="386" valign="top"><table width="100%" height="150"  border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td valign="middle"><img src="/images/welcometomysms.gif" width="310" height="42"></td>
        </tr>
    </table></td>
    <td width="188" align="center" valign="middle" class="textbody"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/home_extranet_news.php'); ?></td>
  </tr>
  <tr>
    <td height="2" colspan="3"><img src="../images/pixel.gif" width="1" height="1"></td>
  </tr>
</table>

<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="188" height="23" bgcolor="#0F1477"><img src="../images/hd_mysmsresources.gif" width="117" height="23"></td>
    <td width="1" bgcolor="#0F1477"><img src="../../images/pixel.gif" width="1" height="1"></td>
    <td width="188" bgcolor="#0F1477">&nbsp;</td>
    <td width="1" bgcolor="#0F1477"><img src="../../images/pixel.gif" width="1" height="1"></td>
    <td width="188" bgcolor="#0F1477">&nbsp;</td>
    <td width="1" bgcolor="#0F1477"><img src="../../images/pixel.gif" width="1" height="1"></td>
    <td width="187" valign="middle" bgcolor="#0F1477" class="text1">&nbsp;</td>
    <td width="1" bgcolor="#8585B7"><img src="../../images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="188" height="19" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="../../images/pixel.gif" width="1" height="1"></td>
    <td width="188" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="../../images/pixel.gif" width="1" height="1"></td>
    <td width="188" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1"><img src="../../images/pixel.gif" width="1" height="1"></td>
    <td width="187" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#8585B7"><img src="../../images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="188" align="center">
		<?php require_once('includes/subnav_support_test_temp.php'); ?>
		<br>
		<?php require_once('includes/subnav_upgrades.php'); ?>
		<br>
		<?php require_once('includes/subnav_feedback.php'); ?>
	</td>
    <td width="1" bgcolor="#CCCCCC"><img src="../../images/pixel.gif" width="1" height="1"></td>
    <td width="188" align="center">
    <?php require_once('includes/subnav_training.php'); ?>
    </td>
    <td width="1" bgcolor="#CCCCCC"><img src="../../images/pixel.gif" width="1" height="1"></td>
    <td width="188" align="center">     
    	<?php require_once('includes/subnav_implementation.php'); ?><br>
    	<?php require_once('includes/subnav_documents.php'); ?>
    </td>
    <td width="1" bgcolor="#CCCCCC"><img src="../../images/pixel.gif" width="1" height="1"></td>
    <td width="187" align="center"><?php require_once('includes/subnav_news_home.php'); ?>
	<br>

    <td width="1" bgcolor="#8585B7"><img src="../../images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="188" height="19">&nbsp;</td>
    <td width="1"><img src="../../images/pixel.gif" width="1" height="1"></td>
    <td width="188">&nbsp;</td>
    <td width="1"><img src="../../images/pixel.gif" width="1" height="1"></td>
    <td width="188">&nbsp;</td>
    <td width="1"><img src="../../images/pixel.gif" width="1" height="1"></td>
    <td width="187">&nbsp;</td>
    <td width="1"><img src="../../images/pixel.gif" width="1" height="1"></td>
  </tr>
</table>
<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr bgcolor="#CCCCCC">
    <td colspan="2"><img src="../../images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr>
    <td width="696" height="40" align="center" valign="middle" bgcolor="EDEDED" class="text1"><P>&copy; <?php echo date("Y") ?> First American SMS (800) 767-7832<br>
        <a href="http://www.firstamprs.com/content/privacy-information" class="text1" onClick="flvFPW1(this.href,'legal','width=980,height=600,scrollbars=yes',1);return document.MM_returnValue">Privacy Policies & Legal Notice</a><STRONG><br>
    </STRONG></P>
    </td>
    <td width="55" align="center" valign="middle" bgcolor="#EDEDED" class="text1"><a href="#top" class="text1">Top</a></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td width="696" colspan="2"><img src="../../images/pixel.gif" width="1" height="1"></td>
  </tr>
</table>
<p>&nbsp;</p>
</body>
</html>
<?php 
}
?>