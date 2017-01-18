<?php
include_once($_SERVER['DOCUMENT_ROOT'].'/cms/config1.inc.php'); // stores important required info
include_once($displaytools); // required for output
// #CMS_Start - DO NOT ALTER THIS LINE
$edit_ary = array (
	"chunk1" => array (
		"title"=>"Vendor Links Content",
		"description"=>"Multiple Content Paragraphs with optional headings. Optional picture at top of paragraph, aligned right. Empty fields are ignored. To delete content simply update with empty values.",		
		"display_type"=>"title_paragraph_picture_right",		
		"blanks"=>"1",		
		"table_name"=>"public_vendorlinks",
		"heading_color"=>"000000"		
		)
	);
// #CMS_End - DO NOT ALTER THIS LINE
// CMS Start & Add lines must immediately preceed and follow edit_ary
$edit_ary["chunk2"] = array (
		"title"=>"Vendor Links Directory",
		"description"=>"Vendor Links summary list.",		
		"display_type" => array (
			"name"=>"directory_summary_ext_link_data_rows",
			"entry_type"=>"edit_one",
			"change_id_label"=>"id",
			"display_label"=>"vendor",
			"select_existing_default"=>"Select Vendor...",
			"select_existing_query"=>"SELECT id,heading FROM vendor_links_directory",
			"heading_color"=>"#000000",
			"display_sort_by_field"=>"heading",
			"link_text"=>"Go"
			),		
		"blanks"=>"1",		
		"table_name"=>"vendor_links_directory",		
		);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>First American SMS</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="/mysms.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="5" topmargin="0" marginwidth="0" marginheight="0">
	<SCRIPT language=JavaScript src="../js/mysms_array.js" type=text/javascript></SCRIPT>
	<SCRIPT language=JavaScript src="../js/mysms.js" type=text/javascript></SCRIPT>
  <a name="top"></a>


<?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/header.php'); ?>
<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="188" height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="188" height="300"><?php // require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/subnav_support.php'); ?><!--<br>-->
	<?php //require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/subnav_logregister.php'); ?><br />
	<a style="margin-left:10px;font-size:13px;text-decoration:underline;" href="javascript:history.back()">&laquo; Back</a><br>
	</td>
    <td width="1" bgcolor="#CCCCCC"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
        <tr bgcolor="#FFCC00" class="textbody">
          <td bgcolor="#FFCC00"><table width="515" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="textbody"><b>Industry Links <font color="#CC0000"></font></b></td>
              <td width="250" align="right">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="text1"><?php content_display("chunk1","<p>","</p>"); ?> </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="text1">&nbsp;</td>
        </tr>
        
      </table>

	<table width="525"  border="0" align="center" cellpadding="5" cellspacing="1">
      <tr bgcolor="#FFCC00" class="textbody">
        <td width="403"><b>Vendor Name </b></td>
        <td width="99" align="center"><b>Website</b></td>
      </tr>
      <?php content_display("chunk2","","<td class=\"text1\">"); ?>
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
