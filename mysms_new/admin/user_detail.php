<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php'); ?>
<?php 
ob_start();
session_start();
header("Cache-control: private");
$logged_in = checkUser($_SESSION['userid'],true);
if (!$logged_in) { // already logged in?
	$_SESSION = array();
	if (isset($_COOKIE[session_name()])) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
	ob_end_flush();
	if ($login_error == "") $login_error = "Your session has expired. Please <a href=\"/admin/index.php\">log in again</a>.";
	include_once($_SERVER['DOCUMENT_ROOT'].'/admin/login_error.php');
	exit();
} else {
	ob_end_flush();
	if (isset($return_form)) {// must have failed validation
		$user_info = $return_form;
	} else {
		$user_info = getUser($_POST['id']);
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
              <td class="textbody"><b>Edit MySMS Registrant</b></td>
              <td align="right">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
<?php
	if ($user_info['registration_status'] === "Profile Update") {
		$profile_log_sql = "SELECT * FROM profile_log WHERE usersid = '{$_POST['id']}' ORDER BY modified DESC LIMIT 1";
		$profile_log_results = @mysql_query($profile_log_sql);
		if ($profile_log_results) {
			while ($profile_log_row = mysql_fetch_assoc($profile_log_results)) {
				foreach($profile_log_row as $key => $val) {
					if ((trim($val) != '') && (trim($val) != '--')) {
						$pl_log[$key] = trim($val);
					}
				}
			}
		}
		if (is_array($pl_log)) {
			if (count($pl_log) > 2) {
				$col_counter = 0;
				if (array_key_exists("email",$pl_log)) $label["E-mail Address:"] = $pl_log['email'];
				if (array_key_exists("password",$pl_log)) $label["Password:"] = '********';
				if (array_key_exists("firstname",$pl_log)) $label["First Name:"] = $pl_log['firstname'];
				if (array_key_exists("lastname",$pl_log)) $label["Last Name:"] = $pl_log['lastname'];
				if (array_key_exists("title",$pl_log)) $label["Title:"] = $pl_log['title'];
				if (array_key_exists("company",$pl_log)) $label["Company:"] = $pl_log['company'];
				if (array_key_exists("address",$pl_log)) $label["Address:"] = $pl_log['address'];
				if (array_key_exists("city",$pl_log)) $label["City:"] = $pl_log['city'];
				if (array_key_exists("state",$pl_log)) $label["State:"] = $pl_log['state'];
				if (array_key_exists("zip",$pl_log)) $label["Zip:"] = $pl_log['zip'];
				if (array_key_exists("phone",$pl_log)) $label["Phone:"] = fix_phone_out($pl_log['phone']);
				if (array_key_exists("fax",$pl_log)) $label["Fax:"] = fix_phone_out($pl_log['fax']);
				if (array_key_exists("default_product",$pl_log)) $label["Default Product:"] = $pl_log['default_product'];
				if (array_key_exists("clientid",$pl_log)) $label["Client ID:"] = $pl_log['clientid'];
				
				if (array_key_exists("modified",$pl_log)) $label["Modified:"] = convert_datetime($pl_log['modified'], 'Y-m-d H:i:s');
				$rec_count = count($label);
					
?>		
	  <tr bgcolor="#FFFFFF">
        <td valign="top" bgcolor="#FFFFFF" class="text1"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="1">
			<tr bgcolor="#CCCCCC">
			  <td colspan="2" class="textbody"><b>Modified Fields (old information)</b></td>
			</tr>
<?php
				foreach($label as $k => $v) {
					// if the remainder of $col_counter divided by 2 == 0 then start a new row
					if($col_counter % 2 == 0) {
?>
			<tr bgcolor="#EDEDED">
<?php
		}
?>
			  <td width="50%" class="text1">
			  	<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="1">
			  	<tr>
			  		<td width="110" align="left" class="text1"><?php print $k; ?></td>
			  		<td align="left" class="text1"><?php print $v; ?></td>
			  	</tr>
			  	</table>
			  </td>
<?php
					// if it's on the last item of the array, add an extra column to complete the row
					// only if it is on the first column of the table
					if($col_counter == ($rec_count - 1)) {
						if($col_counter % 2 == 0) {
?>
			  <td width="50%" class="text1">
			  	<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="1">
			  	<tr>
			  		<td width="110" align="left" class="text1">&nbsp;</td>
			  		<td align="left" class="text1">&nbsp;</td>
			  	</tr>
			  	</table>
			  </td>
<?php
						}
					}
					// if the remainder of $i divided by 2 !=0 then end row
					if($col_counter % 2 != 0) {
?>			  
			</tr>
<?php
					}
					// increment $col_counter so it knows to close the table
					$col_counter++;
				}
?>
			<tr bgcolor="#FFFFFF" class="textbody">
              <td colspan="2" align="left" valign="top" class="text1">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
<?php
			}
		}
	}
?>
      <tr bgcolor="#FFFFFF">
        <td valign="top" bgcolor="#FFFFFF" class="text1"><p>Use this form to edit this MySMS Registrant. <b><br>
              <font color="#CC0000">* 
          Required Fields</font></b></p>         
        <?php if(isset($error_msg)) print "<p><font color=\"#CC0000\">$error_msg</font></p>"; ?>
          </td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td class="text1">&nbsp;</td>
      </tr>
    </table>
      <table width="100%"  border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#FFFFFF" id="desc">
        <tr bgcolor="#EDEDED">
          <td valign="top" bgcolor="#FFFFFF" class="textbody">
          <?php
          	if (is_array($user_info)) {
          		form_edit_user($user_info);
          	} else {
          		print "Invalid member id. No user returned.";
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
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/footer.php'); ?>
<p>&nbsp;</p>
</body>
</html>
