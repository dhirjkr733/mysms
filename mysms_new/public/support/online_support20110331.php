<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/cms/config1.inc.php'); // stores important required info
include_once($displaytools); // required for output
// #CMS_Start - DO NOT ALTER THIS LINE
$edit_ary = array (
	"chunk1" => array (
		"title"=>"First American SMS Online Support",
		"description"=>"Multiple Content Paragraphs with optional headings. Optional picture at top of paragraph, aligned right. Empty fields are ignored. To delete content simply update with empty values.",		
		"display_type"=>"title_paragraph_picture_right",		
		"blanks"=>"1",		
		"table_name"=>"public_online_support",
		"heading_color"=>"000000"		
		)
	);
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

<style>
html {
    direction: ltr;
}

.nav {
text-decoration: none;
color: #000033
}

a.nav:hover {
text-decoration: underline;
}
<?php // loginmein stuff*/
/*
input[type="text"] {
	font: normal 10px/normal verdana,arial,helvetica;width:156px;height:17px;
}

input[type="button"] {
	font: normal 10px/normal verdana,arial,helvetica;
	background:#b11515;
	color:#fff;
	border:0;
	padding:5px 8px;
	-webkit-border-radius: 10px; 
	-moz-border-radius: 10px;
	border-radius: 10px;
}

table {
	font: bold 11px/normal verdana,arial,helvetica;
	text-align:left;
}
*/
?>
</style>
<?php // loginmein stuff*/
/*

<script type="text/javascript"
src="https://secure.logmeinrescue.com/InstantChat/InstantChat.aspx"></script>
  <script type="text/javascript">
    function loadInstantChat(sessionType)
    {
      // Show Instant Chat
      document.getElementById("InstantChatDiv").style.display = "";
      // Hide Channel form
      document.getElementById("ChannelForm").style.display = "none";
      // Hide PIN Code form
      document.getElementById("PinForm").style.display = "none";
      // Hide Language dropdown
      document.getElementById("LanguageForm").style.display = "none";
      var ICLoader = new RescueInstantChatLoader();
      ICLoader.ICContainer = "InstantChatDiv";
      ICLoader.HostedCSS = "http://YourSite/yourstylesheet.css";
      ICLoader.HostedLanguagesForChatOnlyMode = "http://[YourSite]/LanguagesForChatOnlyMode.js";
      ICLoader.HostedLanguagesForAppletMode = "http://[YourSite]/LanguagesForAppletMode.js";
      // sessionType == 0, we are after REBOOT
      // Channel session
      if (sessionType == 1)
          ICLoader.EntryID = "123456789";
      // Private Session
      if (sessionType == 2)
      {
        var pin = document.getElementById("inputPinCode").value;
        if ((pin.length != 6) || isNaN(pin))
        {
          handleError("Private code should be a 6-digit number!");
          return; 
        }
        else
          ICLoader.PrivateCode = document.getElementById("inputPinCode").value;
      }
      ICLoader.Name = document.getElementById("inputYourName").value;
      ICLoader.Comment1 = document.getElementById("inputEmailAddress").value;
      ICLoader.Comment2 = document.getElementById("inputPhoneNumber").value;
      ICLoader.Comment3 = document.getElementById("inputCompanyName").value;
      ICLoader.Comment4 = document.getElementById("inputLocation").value;
      ICLoader.Comment5 = document.getElementById("inputComment").value;
      ICLoader.Tracking0 = "TestForm01";
      ICLoader.Language = document.getElementById("inputLanguageSelect").value;
      // Error + No Technician available notification handling
      ICLoader.HostedErrorHandler = function(ErrorName)
      {
        switch(ErrorName)
        {
          case "NOTECHAVAILABLE": handleError("Currently no technicians are available.
 Please check back later."); break;
          case "NOTECHWORKING": handleError("Sorry, we're closed. No technicians are
 available at this time. Please check back later during our hours of operation."); break;
          case "INVALID_PARAMETERS": handleError("Invalid parameters supplied.
 Please contact your support provider."); break;
          case "SESSIONALREADYSTARTED": handleError("A session using this PIN Code
 has already been started. Please ask your support provider for a new PIN Code."); break;
          case "UCONNECTIONERROR": handleError("Unknown connection error occurred."); break;
          case "ERRNOSUCHSSESSION": handleError("The support session cannot be started.");
 break;
          case "ERRNOSUCHENTRY": handleError("The online support session cannot be started.
 Please contact your support provider directly."); break;
          case "ERRCODEDOESNOTEXIST": handleError("PIN Code does not exist.
 Please contact your support provider."); break;
          case "ERRCODEEXPIRED": handleError("PIN Code has expired.
 Please contact your support provider."); break;
          case "ERRNOTEXPIRED": handleError("Technician or company does not exist.
 Please contact your support provider."); break;
          case "ERRMISSINGTECHLICENSE": handleError("The support session cannot be started.
 The technician is not configured to support this type of device."); break;
        }
      }
      ICLoader.Start();
    }
    // Start automatically Instant Chat after REBOOT
    function handleRebootOrRefresh()
    {
      if ((window.location + "").indexOf("rescuewebsessionid") != -1)
           loadInstantChat(0);
      if (window.location.hash.length == webSessionIdLength + 1)
           loadInstantChat(0);
    }
    // Show error messages
    function handleError(ErrorDescription)
    {
      // Hide Instant Chat
      document.getElementById("InstantChatDiv").style.display = "none";
      // Show ErrorForm
      var ef = document.getElementById("ErrorForm");
      ef.style.display = "";
      ef.innerHTML = ErrorDescription;
    }
  </script>
*/
?>
</head>

<?php // loginmein stuff*/
/*
<body onload="handleRebootOrRefresh();" leftmargin="5" topmargin="0" marginwidth="0" marginheight="0">
*/
?>
<body leftmargin="5" topmargin="0" marginwidth="0" marginheight="0">
<?php //require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/header.php'); ?>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/header.php'); ?>

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

<script language="JavaScript">
function validate_required(field,alerttxt)
{
	with (field)
	{
  		if (value==null||value=="")
  		{
  			alert(alerttxt);
			field.focus();
			return false;
  		}
  		else
  		{
  			return true;
  		}
	}
}
</script>


<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="188" height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="188" height="300"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/subnav_support.php'); ?></td>
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
          <td valign="top" class="text1"><?php // content_display("chunk1","<p>","</p>"); ?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td valign="top" class="text1">
<!-- BEGIN NEW STUFF -->          
<!--          
<table cellpadding="0" cellspacing="0" border="0" width="525">
	<tr>
		<td align="left" valign="top" width="525" bgcolor="#ffffff">
<?php /*
			<noscript>
			    <div style="position: absolute; left: 0px; top: 0px; width: 700px; height: 700px; z-index:
			1;">
			      To use the Instant Chat feature, please ensure you have JavaScript enabled in your
			web browser.<br />
			      Once you have enabled JavaScript, please refresh this page.
			    </div>
			  </noscript> 
			  <div id="ChannelForm" style=" padding: 20px;">
			    Your Name<br />
			    <input id="inputYourName" type="text" maxlength="64" style="width: 200px;" /><br /><br />
			    Email Address<br />
			    <input id="inputEmailAddress" type="text" maxlength="512" style="width: 200px;" /><br
			/><br />
			    Phone Number<br />
			    <input id="inputPhoneNumber" type="text" maxlength="512" style="width: 200px;" /><br /><br />
			    Company Name<br />
			    <input id="inputCompanyName" type="text" maxlength="256" style="width: 200px;" /><br /><br />
			    Location<br />
			    <input id="inputLocation" type="text" maxlength="64" style="width: 200px;" /><br /><br />
			    Comment<br />
			    <input id="inputComment" type="text" maxlength="64" style="width: 200px;" /><br /><br
			/>
			    <input type="button" value="Start Chat Now" onclick="loadInstantChat(1);" />
			  </div>
			  <div id="PinForm" style="float:left; padding: 20px;">
			    Enter your 6 digit PIN code<br />
			    <input id="inputPinCode" type="text" maxlength="64" style="width: 200px;" /><br /><br
			/>
			    <input type="button" value="Connect to technician" onclick="loadInstantChat(2);" />
			  </div>
			  <div id="LanguageForm" style="float:left; padding: 20px;">
			    Select Chat<br />interface language<br />
			    <select id="inputLanguageSelect" style="width: 200px;">
			      <option value="en">English</option>
			      <option value="es">Español</option>
			      <option value="de">Deutsch</option>
			      <option value="fr">Français</option>
			      <option value="it">Italiano</option>
			      <option value="nl">Nederlands</option>
			      <option value="pt">Português</option>
			      <option value="pt-br">Português (Br)</option>
			      <option value="hu">Magyar</option>
			      <option value="ru">Pусско</option>
			      <option value="ja">日本語</option>
			      <option value="ko">한국어</option>
			      <option value="zh">汉语</option>
			      <option value="zh-tw">漢語</option>
			      <option value="ar"> العربيّة </option
			      <option value="tr">Türk</option>
			      <option value="pl">Polski</option>
			      <option value="fi">Suomalainen</option>
			      <option value="sv">Svensk</option>
			      <option value="no">Norsk</option>
			      <option value="he"> עִברִי</option>
			      <option value="da">Dansk</option>
			      <option value="cs">Česky</option>
			    </select>
			  </div>
			  <div id="ErrorForm" style="clear: both;width: 300px; background-color: #303030; color:#fff; padding: 20px; display: none"></div>
			  <div id="InstantChatDiv" style="width: 285px; height: 259px; display: none"></div>
*/ ?>
		</td>
	</tr>
</table>
-->
<!-- END NEW STUFF -->
<!-- BEGIN OLD STUFF -->
<table cellpadding=0 cellspacing=0 border=0 width=525>
	<tr>
		<td align=center valign=top width=525 bgcolor=#ffffff>
			<table cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td height=20></td>
				</tr>
			</table>

<form action="https://broker.GoToAssist.com/servlet/dispatch/ds/queryPost.flow" method=POST name="QuestionEntry" onsubmit="return validate_required(CustomField1, 'Please select a Product before continuing.')">
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
				<!--OPTION VALUE="Please Select a Product" SELECTED>Please Select a Product</OPTION-->
				<OPTION VALUE="" SELECTED></OPTION>
				<OPTION VALUE="ClosingTracker">ClosingTracker</OPTION>
				<OPTION VALUE="DocNet">DocNet</OPTION>
				<OPTION VALUE="Other">Other</OPTION>
				<OPTION VALUE="StreamLine/SL Accounting">StreamLine/SL Accounting</OPTION>
				<OPTION VALUE="Trust32">Trust32</OPTION>
				<OPTION VALUE="Trust Link">Trust Link</OPTION>
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
<!-- END OLD STUFF -->
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
