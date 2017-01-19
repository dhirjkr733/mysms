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
include($_SERVER['DOCUMENT_ROOT'].'/cms/config1.inc.php'); // stores important required info
/* include($displaytools); */ // required for output
// #CMS_Start - DO NOT ALTER THIS LINE
/*
$edit_ary = array (
	"chunk1" => array (
		"title"=>"Online Support Content",
		"description"=>"Multiple Content Paragraphs with optional headings. Optional picture at top of paragraph, aligned right. Empty fields are ignored. To delete content simply update with empty values.",		
		"display_type"=>"title_paragraph_picture_right",		
		"blanks"=>"1",		
		"table_name"=>"online_support",
		"heading_color"=>"000000"		
		)
	);
*/
// #CMS_End - DO NOT ALTER THIS LINE
// CMS Start & Add lines must immediately preceed and follow edit_ary
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html xmlns:MSIE>
<head>
<title>First American SMS</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="/mysms.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
<!--
function emptyFields(form) {
	for(i=0;i<form.length;i++) {
		if((form.elements[i].type == "textarea" || form.elements[i].type == "text")) {
			var elementName = "Default"+form.elements[i].name;
			var defaultValueField = document.getElementById(elementName);
		
			if(defaultValueField) {
				// check if we have a default value for this field
				if(defaultValueField.value == form.elements[i].value) {
					// If the value is same as default do not save it
					form.elements[i].value = "";
				}
			}
		}
	}
}
function emptyField(element) {
	var elementName = "Default"+element.name;
	var defaultValueField = document.getElementById(elementName);
	if(defaultValueField) {
		// check if we have a default value for this field
		if(defaultValueField.value == element.value) {
			element.value = ""
		}
	}
}
//-->
</script>

</head>

<body leftmargin="5" topmargin="0" marginwidth="0" marginheight="0">
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/header.php'); ?>

<a name=top></a>
<script language="JavaScript">
<!--
var javaEnabled = "false";
//-->
</script>
        <style>
@media all {
        MSIE\:CLIENTCAPS {
                behavior:url(#default#clientcaps)
     }
}
</style>
<MSIE:CLIENTCAPS ID="oClientCaps" />

<script language="JavaScript">
<!--
bMSvmAvailable = oClientCaps.isComponentInstalled("{08B0E5C0-4FCB-11CF-AAA5-00401C608500}", "ComponentID");
if (bMSvmAvailable && oClientCaps.javaEnabled)
        javaEnabled = "true"
//-->
</script>

<script language="JavaScript">
<!--
bName = navigator.appName;
bVer = parseInt(navigator.appVersion);
if ((bName == "Microsoft Internet Explorer" && bVer == 2) || (bName == "Netscape" && bVer == 3)) {
	ver = "e2n3";
} else {
	ver = "other";
}
if (ver == "e2n3") {
} else {
	var scwidth=0; var scheight=0; var winwidth=0; var winheight=0;
	if (window.screen) {
		if(window.innerWidth) {
			// NS4
			scwidth = screen.availWidth;
			scheight = screen.availHeight;
			winwidth = window.innerWidth;
			winheight = window.innerHeight;
		} else if (screen && screen.width && document.body) {
			// IE4
			scwidth = screen.width;
			scheight = screen.height;
			winwidth = document.body.offsetWidth;
			winheight = document.body.offsetHeight;
		}
	}
	url = document.location.protocol + '//' + document.location.host + '/javaScriptTester.tmpl?' + 'SessionInfo=59144285:7D652943269A114&Portal=smschat&enabled=true' + '&screenWidth=' + scwidth + '&screenHeight=' + scheight + '&windowWidth=' + winwidth + '&windowHeight=' + winheight + '&javaEnabled=' + javaEnabled;;
	dummy = new Image;
	dummy.src = url;
}
//-->
</script>

<script language="JavaScript">
<!--
function popup(url, title, width, height) {
	window.open(url, "help", "width=" + width + ",height=" + height + ",scrollbars=yes,toolbar=no;locationbar=no;statusbar=no,resizable=yes");
	return false;
}
//-->
</script>


<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="188" height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="188" height="300"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/subnav_support_dev.php'); ?></td>
    <td width="1" bgcolor="#CCCCCC"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF">
    
    <table width="451"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
		<tr bgcolor="#FFCC00" class="textbody">
		  <td bgcolor="#FFCC00"><table width="515" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td class="textbody"><b>First American SMS Chat Support<font color="#CC0000"></font></b></td>
			  <td width="250" align="right">&nbsp;</td>
			</tr>
	</table>
        	</td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td valign="top" class="text1"><?php /* content_display("chunk1","<p>","</p>"); */ ?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td valign="top" class="text1">
          
          
<table cellpadding=0 cellspacing=0 border=0 width=525>
	<tr>
		<td align=center valign=top width=525 bgcolor=#ffffff>
			<table cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td height=20></td>
				</tr>
			</table>

<form action="https://broker.GoToAssist.com/servlet/dispatch/ds/queryPost.flow" method=POST name="QuestionEntry" >
<!--form action="/ds/queryPost.flow" method=POST name="QuestionEntry" -->
<!--input type=hidden name="SessionInfo" value="59144285:7D652943269A114:null"-->
<input type=hidden name="Portal" value="smschat">
<input type=hidden name="Template" value="ds/questionEntry.tmpl">
<input type=hidden name="Form" value="smschatSmartBox">

<table cellpadding=0 cellspacing=0 border=0 width=451>
	<tr>
		<td><font face="Verdana,Arial,Helvetica" size=2><b>Live representatives are online and standing by!</b></font></td>
	</tr>
	<tr>
		<td height=4></td>
	</tr>
	<tr>
		<td height=4></td>
	</tr>
	<tr>
		<td><font face="Verdana,Arial,Helvetica" size=1>Meet your representative on-screen and get answers to your questions in real time.</font></td>
	</tr>
</table>

	
<table cellpadding=0 cellspacing=0 border=0 width=451>
					            <tr>
                                    
                                                                                                                                                                                                            <td>
                        <font face="Verdana,Arial,Helvetica" size=1><b>Name:</b><br>
                        <input type=text size=18 style="font: normal 10 verdana,arial,helvetica;width:156;height:17;" name="Name_Full" value=""></font></td>
            </tr>
            <tr>
                <td height=4></td>
            </tr>
							            <tr>
                                                                                                            
                                                                                                                                    <td>
                        <font face="Verdana,Arial,Helvetica" size=1><b>Company:</b><br>
                        <input type=text size=18 style="font: normal 10 verdana,arial,helvetica;width:156;height:17;" name="CompanyName" value=""></font></td>
            </tr>
	    <tr>                                                                                                            
		<td>
                        <font face="Verdana,Arial,Helvetica" size=1><b>Product:</b><br>
			<!--input type=text size=18 style="font: normal 10 verdana,arial,helvetica;width:156;height:17;" name="CustomField1" value=""-->
			<SELECT NAME="CustomField1">
				<OPTION VALUE="Please Select a Product" SELECTED>Please Select a Product</OPTION>
				<OPTION VALUE="ClosingTracker">ClosingTracker</OPTION>
				<OPTION VALUE="DocNet">DocNet</OPTION>
				<OPTION VALUE="Other">Other</OPTION>
				<OPTION VALUE="StreamLine/SL Accounting">StreamLine/SL Accounting</OPTION>
				<OPTION VALUE="Trust 32">Trust 32</OPTION>
				<OPTION VALUE="TrustLink">TrustLink</OPTION>
				<OPTION VALUE="VISION/VISION Accounting">VISION/VISION Accounting</OPTION>
			</SELECT>
			</font>
		</td>
            </tr>
            <tr>
                <td height=4></td>
            </tr>
			</table>


<table cellpadding=0 cellspacing=0 border=0 width=451>
	<tr>
		<td align="left"><font face="Verdana,Arial,Helvetica" size=1><b>Type your question below and click Continue.</b></font></td>
	</tr>
	<tr>
		<td height=2></td>
	</tr>
	<tr>
		<td><font face="Verdana,Arial,Helvetica" size=1><textarea name=Question cols=53 rows=5 wrap=virtual style="font: 10 verdana,arial,helvetica;height:70;width:451;margin-top:2;"></textarea></font></td>
	</tr>
	<tr>
		<td valign=bottom align"left" height=40><input type=submit name="Continue" value="Continue"></td>
	</tr>
</form>
</table>

		</td>
	</tr>
</table>


		  </td>
        </tr>
        
      </table>
		  </td>
        </tr>
        
      </table>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/footer.php'); ?>
<p>&nbsp;</p>
</body>
</html>
