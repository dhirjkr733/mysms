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
<html xmlns:msie="">
<head>
    <title>First American SMS</title>
    <meta http-equiv="content-type" content="text/html; charset=iso-8859-1">
    <link href="/mysms.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
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
<style type="text/css">
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
input[type="text"] {
	font: normal 10px/normal verdana,arial,helvetica;width:156px;height:17px;
}

input[type="select"] {
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
.small {
	font-family: verdana,arial,helvetica;
	text-align:left;
	font-size: x-small;
	font-weight: normal;
	font-style: normal;
}
</style>
<script type="text/javascript" src="https://secure.logmeinrescue-enterprise.com/InstantChat/InstantChat.aspx">
</script>
<script type="text/javascript">
        function loadInstantChat(){
            var ICLoader = new RescueInstantChatLoader();
            ICLoader.ICContainer = "ICContainer";
            ICLoader.HostedCSS = "https://secure.logmeinrescue-enterprise.com/InstantChat/Standard/InstantChat.css";
            ICLoader.HostedLanguagesForChatOnlyMode = "https://secure.logmeinrescue-enterprise.com/InstantChat/LanguagesForChatOnlyMode.js";
            ICLoader.HostedLanguagesForAppletMode = "https://secure.logmeinrescue-enterprise.com/InstantChat/LanguagesForAppletMode.js";
            ICLoader.EntryID = "1008186568";
            ICLoader.Name = document.getElementById("inputYourName").value; /* optional */
            ICLoader.Comment1 = document.getElementById("inputCompanyName").value; /* optional */
            ICLoader.Comment2 = document.getElementById("inputProduct").value; /* optional */
            ICLoader.Comment3 = document.getElementById("inputComment").value; /* optional */
            ICLoader.Tracking0 = ""; /* optional */
            ICLoader.Language = ""; /* optional */
            ICLoader.HostedErrorHandler = function(ErrorName){} /* optional */
            ICLoader.Start();}
        function handleRebootOrRefresh(){
            if ((window.location + "").indexOf("rescuewebsessionid") != -1){document.getElementById("ICContainer").style.display=""; loadInstantChat();} /* optional */
            if (window.location.hash.length == webSessionIdLength + 1){document.getElementById("ICContainer").style.display=""; loadInstantChat();} /* optional */
        }
</script>
</head>
<body onload="handleRebootOrRefresh();" leftmargin="5" topmargin="0" marginwidth="0" marginheight="0">
    <?php //require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/header.php'); ?><?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/header.php'); ?><a name="top"></a> <script language="JavaScript" type="text/javascript">
<!--
var javaEnabled = "false";
//-->
</script><script language="JavaScript" type="text/javascript">
<!--
function popup(url, title, width, height) {
	window.open(url, "help", "width=" + width + ",height=" + height + ",scrollbars=yes,toolbar=no;locationbar=no;statusbar=no,resizable=yes");
	return false;
}
//-->
</script><script language="JavaScript" type="text/javascript">
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
			<table width="451" border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
				<tr bgcolor="#FFCC00" class="textbody">
					<td bgcolor="#FFCC00">
						<table width="515" border="0" cellspacing="0" cellpadding="0">
							<tr>
								<td class="textbody"><strong>First American SMS Chat Support</strong></td>
								<td width="250" align="right">&nbsp;</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="text1"><?php //content_display("chunk1","<p>","</p>"); ?></td>
				</tr>
				<tr bgcolor="#FFFFFF">
					<td valign="top" class="text1">
						<table cellpadding="0" cellspacing="0" border="0" width="525">
							<tr>
								<td align="left" valign="top" width="525" bgcolor="#FFFFFF">
									<table cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td height="20"></td>
										</tr>
									</table>
									<table cellpadding="0" cellspacing="0" border="0" width="451">
										<tr>
											<td><font face="Verdana,Arial,Helvetica" size="2"><strong>Live representatives are online and standing by!</strong></font></td>
										</tr>
										<tr>
											<td height="4">&nbsp;</td>
										</tr>
										<tr>
											<td height="4">
												<noscript>
													<div style="position: absolute; left: 0px; top: 0px; width: 700px; height: 700px; z-index: 1;">
														To use the Instant Chat feature, please ensure you have JavaScript enabled in your web browser.<br />
														Once you have enabled JavaScript, please refresh this page.
													</div>
												</noscript>
											</td>
										</tr>
										<tr>
											<td class="small">Meet your representative on-screen and get answers to your questions in real time.</td>
										</tr>
										<tr>
											<td height="4">&nbsp;</td>
										</tr>
									</table>
									<div id="ChannelForm" style=" padding: 20px;">
										Name:<br />
										<input id="inputYourName" type="text" maxlength="64" style="width: 200px;"><br />
										<br />
										Company:<br />
										<input id="inputCompanyName" type="text" maxlength="256" style="width: 200px;"><br />
										<br />
										Product:<br />
										<select id= "inputProduct" name="inputProduct" style="width: 200px;">
											<option value="" selected="selected"></option>
											<option value="ClosingTracker">ClosingTracker</option>
											<option value="DocNet">DocNet</option>
											<option value="Other">Other</option>
											<option value="StreamLine/SL Accounting">StreamLine/SL Accounting</option>
											<option value="Trust32">Trust32</option>
											<option value="Trust Link">Trust Link</option>
											<option value="VISION/VISION Accounting">VISION/VISION Accounting</option>
										</select><br />
										<br />
										Type your question below and click Continue.<br />
										<textarea id="inputComment" cols="53" rows="5"></textarea><br />
										<br />
										<input type="button" value="Continue" onclick="document.getElementById('ICContainer').style.display=''; loadInstantChat(1);">
									</div>
									<div id="ErrorForm" style="clear: both;width: 300px; background-color: #303030; color:#fff; padding: 20px; display: none"></div>
									<div id="ICContainer" style="position: absolute; left: 0px; top: 0px; width: 400px; height: 500px; display: none"></div>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table><?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/footer.php'); ?>
<p>&nbsp;</p>
</body>
</html>
