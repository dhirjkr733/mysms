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
include($displaytools); // required for output
// #CMS_Start - DO NOT ALTER THIS LINE
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
// #CMS_End - DO NOT ALTER THIS LINE
// CMS Start & Add lines must immediately preceed and follow edit_ary
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
    <td width="188" height="300"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/subnav_support.php'); ?></td>
    <td width="1" bgcolor="#CCCCCC"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
        <tr bgcolor="#FFCC00" class="textbody">
          <td bgcolor="#FFCC00"><table width="515" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="textbody"><b>SMS Online Support<font color="#CC0000"></font></b></td>
              <td width="250" align="right">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td valign="top" class="text1"><?php content_display("chunk1","<p>","</p>"); ?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td valign="top" class="text1">
		                <script language="JavaScript">
<!--
function setJS() {
	document.QuestionEntry.JavaScript.value = "true";
}
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
			<form name="logmeinsupport" action="https://secure.logmeinrescue.com/Customer/Code.aspx" method="post" id="logmeinsupport">
                 <p> 
                <b><font color="red">
					<script type="text/javascript">
						var response = pullQueryString();
						response = response.substring(22);
	
						if(response.toLowerCase().indexOf("pincode_missing") > -1 ){
							document.write("Assisted service can be obtained by first contacting  support at 1 (800) 767-7831." + "<br />");
						}
						else if(response.toLowerCase().indexOf("pincode_invalid") > -1){
							document.write("The PIN code you have entered is invalid." + "<br />");
						}
						else if(response.toLowerCase().indexOf("pincode_expired") > -1){
							document.write("The PIN code you have entered is expired." + "<br />");
						}
						else if(response.toLowerCase().indexOf("pincode_error") > -1){
							document.write("The PIN code you have entered is invalid." + "<br />");
						}
						else if(response.toLowerCase().indexOf("pincode_alreadyused") > -1){
							document.write("The PIN code you have entered has already been used." + "<br />");
						}
						else{
							document.write(response) + "<br />";
						}
					</script>
				</font></b>
				<input type="hidden" name="tracking0" maxlength="64" /> <!-- optional -->
				<input type="hidden" name="language" maxlength="5" /> <!-- optional -->
				<input type="hidden" name="hostederrorhandling" value="1" />
				<input type="text" name="Code" /><br /><br />
                <input type=image name="Live Experts Now!" value="submit" onClick="setJS();" src="/images/bt_clickhere.gif" width="56" height="56" border="0" />
              </form>
		  
		  </td>
        </tr>
        
      </table>
      <table width="525"  border="0" align="center" cellpadding="5" cellspacing="1" id="files">
        <tr bgcolor="#EDEDED" class="text1">
          <td colspan="3" bgcolor="#FFFFFF" class="text1">&nbsp;</td>
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
