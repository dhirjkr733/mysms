<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php'); ?>
<?php
$msg = "";
db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
if (valid_email($_POST["email"])) {
	$email_sql = "SELECT email,firstname,DECODE(password,'".SALT."') as password FROM admin WHERE email=".quote_smart($_POST["email"]);
	$email_result = @mysql_query($email_sql);
	$email_count = @mysql_num_rows($email_result);
	if ($email_count !== 0) {
		$row = mysql_fetch_array($email_result);
		$msg = "Thank you. A copy of your login information will be e-mailed to you shortly.";
		$mailmsg = "
Dear {$row['firstname']},

This information has been sent at your request and is for use at ".APPLICATION_ADMIN_HOME_PAGE." 

Your password for MySMS is {$row['password']}

If you have any questions regarding your login, please contact us at ".ADMINISTRATION_EMAIL."

";
		mail($row['email'],"MySMS Login Reminder",$mailmsg,"From: ".ADMINISTRATION_EMAIL."\r\n");
	} else {
		$msg = "There is no account registered under the Email Address provided.";
	}
} else {
	$msg .= "There is no account registered under the Email Address provided.";
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
              <td class="textbody"><b>Forgot Your Password?</b></td>
              <td align="right">&nbsp;</td>
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
