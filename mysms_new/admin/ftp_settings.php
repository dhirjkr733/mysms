<?php 
ob_start();
session_start();
header("Cache-control: private");
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php');
$logged_in = checkUser($_SESSION['userid'],true);
if (!$logged_in) {
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
	ob_end_flush();
	if ($login_error == "") $login_error = "Your session has expired. Please <a href=\"/admin/index.php\">log in again</a>.";
	include_once($_SERVER['DOCUMENT_ROOT'].'/admin/login_error.php');
} else {
	ob_end_flush();
	$findcount = getFTP();
	//echo $sql;
	if (!$findcount) {
		$count = 0;
		$mesg = "A database error occurred while retrieving your query results. Please <a href=\"user_summary.php\">try again</a>.";
	} else {
		$count = count($findcount);
		if ($count == 0) {
			$count=0;
			$mesg = "There were no records that matched your query. Please <a href=\"user_summary.php\">try again</a>.";
		} 
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
<script language="javascript">
function editFTP(num) {
	frm=document.action_form;
	frm.action='ftp_detail.php';
	frm.ftpid.value = num;
	frm.submit();	
}
function deleteFTP(num) {
	frm=document.action_form;
	frm.action='delete_ftp_confirmation.php';
	frm.ftpid.value = num;
	frm.submit();	
}
</script>
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
    <td colspan="7" valign="top" bgcolor="#FFFFFF">
		<table width="755"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
      		<tr bgcolor="#FFCC00" class="textbody">
        		<td bgcolor="#FFCC00">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
            			<tr>
              				<td class="textbody"><b>MySMS FTP Administration</b></td>
              				<td align="right">&nbsp;</td>
            			</tr>
        			</table>
				</td>
      		</tr>
      		<tr bgcolor="#FFFFFF">
        		<td valign="top" bgcolor="#FFFFFF" class="text1"><p><a href="ftp_add.php">Add new FTP location.</a></p></td>
      		</tr>
    	</table>
    		<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="1" id="results">
				<tr bgcolor="#CCCCCC" class="textbody">
				  <td><b>Product</b></td>
				  <!--<td><b>FTP Server</b></td>-->
				  <td><b>Directory</b></td>
				  <td><b>Type</b></td>
				  <td align="center"><b>Action</b></td>
				</tr>
        <?php 
        	if ($count > 0) {
        		foreach ($findcount as $key=>$row) {
        ?>
				<tr bgcolor="#EDEDED" class="text1">
				  <td class="text1"><?php print $row['product']; ?></td>
				  <!--<td class="text1"><?php print $row['server']; ?></td>-->
				  <td class="text1"><?php print $row['directory']; ?></td>
				  <td class="text1"><?php print $row['type']; ?></td>
				  <td align="center" class="text1" valign="center">
				  	<?php 
				  		print "<a href=\"javascript:editFTP({$row['id']});\" class=\"text1\">Edit</a>\n";
				  		print "<br>";
				  		print "<a href=\"javascript:deleteFTP({$row['id']});\" class=\"text1\">Delete</a>\n";
				  	?></td>
				</tr>
        <?php
        		}
        ?>
				<tr bgcolor="#CCCCCC" class="textbody">
				  <td><b>Product</b></td>
				  <!--<td><b>FTP Server</b></td>-->
				  <td><b>Directory</b></td>
				  <td><b>Type</b></td>
				  <td align="center"><b>Action</b></td>
				</tr>
        <?php
        	} else {
        ?>
        		<tr bgcolor="#EDEDED" class="text1"><td colspan="4" class="text1">There were no records that matched your query.</td></tr>
        <?php
        	}
        ?>
    		</table>
      <!-- <table width="525"  border="0" align="center" cellpadding="5" cellspacing="1" id="pagelinks">
        <tr bgcolor="#FFFFFF">
          <td width="310" class="textbody">Page <a href="#">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">5</a> </td>
          <td width="192" align="right" class="textbody"><a href="#">Previous</a> | <a href="#">Next</a> </td>
        </tr>
      </table> -->
	  	</td>
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
<form name="action_form" id="action_form" method="POST">
<input type="hidden" name="ftpid">
</form>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/footer.php'); ?>
<p>&nbsp;</p>
</body>
</html>
<?php
}
?>