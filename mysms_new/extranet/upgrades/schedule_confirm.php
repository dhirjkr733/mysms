<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php'); ?>
<?php 
ob_start();
session_start();
header("Cache-control: private");
$confirm = false;
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
} else {
	$error_msg = "";
	//validate registration form
	$error_msg = validate_form("scheduleupgrade");
	if ($error_msg !== "") {
		//failed - return to form with error messages
		$return_form = $_POST;
		include_once('schedule_upgrade.php');
	} else {
		//passed - process request
		$logged_in_userid = $_SESSION['userid'];
		$firstname = $_POST['firstname'];
		$lastname = $_POST['lastname'];
		$title = $_POST['title'];
		$company = $_POST['company'];
		$address = $_POST['address'];
		$city = $_POST['city'];
		$state = $_POST['state'];
		if ($state === "CA") {
			$county = $_POST['county'];
		} else {
			$county = "";
		}
		$zip = $_POST['zip'];
		$phone = fix_phone_in("phone");
		$alt_phone = fix_phone_in("alt_phone");
		$email = $_POST['email'];
		$comments = $_POST['comments'];
		$signup_date = date("Ymd");
		$computer_details = $_SERVER['HTTP_USER_AGENT'];
		$ip_address = $_SERVER['REMOTE_ADDR'];
		//add to db 
		$user_array = Array (
					'logged_in_userid'=>$logged_in_userid,
					'firstname'=>$firstname,
					'lastname'=>$lastname,
					'title'=>$title,
					'company'=>$company,
					'address'=>$address,
					'city'=>$city,
					'state'=>$state,
					'county'=>$county,
					'zip'=>$zip,
					'phone'=>$phone,
					'alt_phone'=>$alt_phone,
					'email'=>$email,
					'comments'=>$comments,
					'signup_date'=>$signup_date,
					'computer_details'=>$computer_details,
					'ip_address'=>$ip_address
					);
		$result = insertUpgradeRequest($user_array);
		if (!$result) {
			include_once($_SERVER['DOCUMENT_ROOT'].'/extranet/upgrades/schedule_error.php');
		} else {
			$phone = fix_phone_out($phone);
			$alt_phone = fix_phone_out($alt_phone);
			//notify registration admin
			$today = date("F j, Y, g:i a");
			$mailmsg = "
			You have received a request to schedule an upgrade from MySMS.
			Received: $today.
	
			First Name = $firstname
			Last Name = $lastname
			Title = $title
			Company = $company
			Address = $address
			City = $city
			State = $state
			County = $county
			Zip = $zip
			Phone = $phone
			Alt Phone = $alt_phone
			Email = $email
			Comments = $comments

			Logged in User Id = $logged_in_userid
			Computer Details = $computer_details
			IP Address = $ip_address
			";
			if ($state == 'CA') {
				$emails_sql = "SELECT DISTINCT email FROM representatives,repdb,counties WHERE representatives.id = repdb.rep_id AND counties.id = repdb.county_id AND state_id = 'CA' AND counties.heading = '$county'";
			} else {
				$emails_sql = "SELECT DISTINCT email FROM representatives,repdb,counties WHERE representatives.id = repdb.rep_id AND state_id = '$state'";					
			}
			$emails_result = getEmailList($emails_sql);
			
			mail(SOFTWARE_SUPPORT_EMAIL.$emails_result,"MySMS Request for Scheduling my Upgrade",$mailmsg,"From: ".ADMINISTRATION_EMAIL."\r\n");
			$confirm = true;
		}
	}
}
if ($confirm) {
	//show confirmation screen
	ob_end_flush();
include_once($_SERVER['DOCUMENT_ROOT'].'/cms/config1.inc.php'); // stores important required info
include_once($displaytools); // required for output
// #CMS_Start - DO NOT ALTER THIS LINE
$edit_ary = array (
	"chunk1" => array (
		"title"=>"Schedule My Upgrade Confirmation Content",
		"description"=>"Multiple Content Paragraphs with optional headings. Optional picture at top of paragraph, aligned right. Empty fields are ignored. To delete content simply update with empty values.",		
		"display_type"=>"title_paragraph_picture_right",		
		"blanks"=>"1",		
		"table_name"=>"schedule_upgrade_confirm",
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
.uploadinputs {	width: 220px;
}
.uploadinputs2 {	width: 355px;
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
    <td width="188" height="300"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/subnav_upgrades.php'); ?></td>
    <td width="1" bgcolor="#CCCCCC"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
        <tr bgcolor="#FFCC00" class="textbody">
          <td bgcolor="#FFCC00"><table width="515" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="textbody"><b>Schedule My Upgrade <font color="#CC0000"></font></b></td>
              <td width="250" align="right">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="text1"><?php content_display("chunk1","<p>","</p>"); ?></td>
        </tr>
      </table>
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
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/footer.php'); ?>
<p>&nbsp;</p>
</body>
</html>
<?php 
}
?>