<?php 
// Turn off all error reporting
error_reporting(0);
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
include_once($_SERVER['DOCUMENT_ROOT'].'/cms/config1.inc.php'); // stores important required info
include_once($displaytools); // required for output
// #CMS_Start - DO NOT ALTER THIS LINE
$edit_ary = array (
	"chunk1" => array (
		"title"=>"Software Change Request Content",
		"description"=>"Multiple Content Paragraphs with optional headings. Optional picture at top of paragraph, aligned right. Empty fields are ignored. To delete content simply update with empty values.",		
		"display_type"=>"title_paragraph_picture_right",		
		"blanks"=>"1",		
		"table_name"=>"software_change_request",
		"heading_color"=>"000000"		
		)
	);
// #CMS_End - DO NOT ALTER THIS LINE
// CMS Start & Add lines must immediately preceed and follow edit_ary
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


<?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/header.php'); ?>
<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="188" height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="188" height="300"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/subnav_feedback.php'); ?><br>
	
	
	<table width="170" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top">
    <td width="25" height="20"><img src="/images/arrow1.gif" width="21" height="17"></td>
    <td><span class="headline">Contact Us</span></td>
  </tr>
  <tr valign="top">
    <td height="39">&nbsp;</td>
    <td class="text1"><table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" id="subnav">
        <tr valign="top">
					<td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
				</tr>
				<tr valign="top">
          <td width="10"><img src="/images/arrow2.gif" width="4" height="17"></td>
          <td><a href="/public/contact/helpdesk_sms.php">Help Desk</a></td>
        </tr>
				<tr valign="top">
					<td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
				</tr>
				<tr valign="top">
          <td width="10"><img src="/images/arrow2.gif" width="4" height="17"></td>
          <td><a href="/public/contact/helpdesk_trustacct.php">Trust Acct Help Desk</a></td>
        </tr>
				<tr valign="top">
					<td height="5" colspan="2"><img src="/images/spacer.gif" width="1" height="5"></td>
				</tr>
				<tr valign="top">
          <td width="10"><img src="/images/arrow2.gif" width="4" height="17"></td>
          <td><a href="/public/contact/helpdesk_1099.php">1099 Help Desk</a><br><br></td>
        </tr>
    </table></td>
  </tr>
	<tr valign="top">
	    <td width="25" height="20"><img src="/images/arrow1.gif" width="21" height="17"></td>
	    <td><a href="/extranet/index.php"><img src="/images/ft_mysmshome.gif" width="79" height="17" border="0"></a></td>
	  </tr>
</table>



</td>
    <td width="1" bgcolor="#CCCCCC"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
      <tr bgcolor="#FFCC00" class="textbody">
        <td bgcolor="#FFCC00"><table width="515" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="321" class="textbody"><b>Software Change Request</b></td>
              <td width="194" align="right">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td valign="top" bgcolor="#FFFFFF" class="text1"><?php content_display("chunk1","<p>","</p>"); ?> <b>
              <font color="#CC0000">*          Required Fields</font></b>
          <?php if(isset($error_msg)) print "<p><font color=\"#CC0000\">$error_msg</font></p>"; ?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td class="text1">&nbsp;</td>
      </tr>
    </table>
      <table width="525"  border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" id="desc">
        <tr bgcolor="#EDEDED">
          <td valign="top" bgcolor="#FFFFFF" class="textbody">
          <?php
          	if((isset($return_form))) {
          		form_changerequest($_SESSION['userid'],$return_form);
          	} else {
          		form_changerequest($_SESSION['userid']);
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
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/footer.php'); ?>
<p>&nbsp;</p>
</body>
</html>
