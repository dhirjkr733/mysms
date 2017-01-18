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
$ftp_info = array (
	"directory"=>LOGO_FTP_DIR,
	"username"=>DEFAULT_FTP_USER,
	"password"=>DEFAULT_FTP_PASS,
	"server"=>DEFAULT_FTP_SITE
	);
$directory_listing = getDirectoryListing($ftp_info);
if (is_array($directory_listing)) usort($directory_listing, "sort_directory_by_name_asc");
include_once($_SERVER['DOCUMENT_ROOT'].'/cms/config1.inc.php'); // stores important required info
include_once($displaytools); // required for output
// #CMS_Start - DO NOT ALTER THIS LINE
$edit_ary = array (
	"chunk1" => array (
		"title"=>"Logos Content",
		"description"=>"Multiple Content Paragraphs with optional headings. Optional picture at top of paragraph, aligned right. Empty fields are ignored. To delete content simply update with empty values.",		
		"display_type"=>"title_paragraph_picture_right",		
		"blanks"=>"1",		
		"table_name"=>"logos",
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
<script language="javascript">
function getFile(directory,filename) {
	frm = document.getfile;
	frm.d.value = directory;
	frm.f.value = filename;
	frm.submit();
}
</script>
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
    <td width="188" height="300"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/subnav_documents.php'); ?></td>
    <td width="1" bgcolor="#CCCCCC"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
        <tr bgcolor="#FFCC00" class="textbody">
          <td bgcolor="#FFCC00"><table width="515" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="textbody"><b>Logos</b></td>
              <td width="250" align="right">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="text1"><?php content_display("chunk1","<p>","</p>"); ?></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="text1">&nbsp;</td>
        </tr>
      </table>
      <table width="525"  border="0" align="center" cellpadding="5" cellspacing="1">
<?php 
if ((count($directory_listing) < 1) || (!is_array($directory_listing))) {
?>
		<tr bgcolor="#FFFFFF">
          <td colspan="3" align="center" class="text1">There are no files available for this product.</td>
        </tr>
<?php
} else {
	foreach ($directory_listing as $key=>$value) {
		if (!is_null($value)) {
?>      
        <tr bgcolor="#CCCCCC">
          <td colspan="2" class="textbody"><b><?php print $value['name']; ?></b></td>
          <td width="110" align="center" class="text1">&nbsp;</td>
        </tr>
<?php
			if (count($value['sub_dir']) < 1) {
?>
		<tr bgcolor="#EDEDED">
          <td colspan="3" align="center" class="text1">There are no files available for this product.</td>
        </tr>
<?php
			} else {
				usort($value['sub_dir'], "sort_directory_by_name_asc");
				foreach($value['sub_dir'] as $sub_key=>$sub_value) {
					if (!is_null($sub_value)) {
						$size = intval($sub_value['size']);
						if ($size > 1048576) {
							$size = intval($size/1048576);
							$suffix = 'Mb';
						} elseif ($size > 1024) {
							$size = intval($size/1024);
							$suffix = 'k';
						} else {
							$suffix = 'b';
						}				
?>
		<tr bgcolor="#EDEDED">
          <td width="334" class="text1"><?php print $sub_value['name']; ?> </td>
          <td width="80" class="text1"><?php print "$size"."$suffix"; ?></td>
          <td width="110" align="center" class="text1"><?php print "<img src=\"/images/arrow4.gif\" width=\"4\" height=\"17\" align=\"absmiddle\"> <a href=\"#\" onClick=\"javascript:getFile('{$value['name']}','{$sub_value['name']}');\" class=\"text1\">Download</a>"; ?></td>
        </tr>
<?php
					}
				}
			}
		}
	}
}
?>
        </table>      
<!--       <table width="525"  border="0" align="center" cellpadding="5" cellspacing="1" id="pagelinks">
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
<form id='getfile' name='getfile' method="POST" action="/extranet/downloads/download_file.php">
<input type="hidden" name="f" id="f">
<input type="hidden" name="d" id="d">
<input type="hidden" name="type" id="type" value='Logo'>
</form>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/footer.php'); ?>
<p>&nbsp;</p>
</body>
</html>