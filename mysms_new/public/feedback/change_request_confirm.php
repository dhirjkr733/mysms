<?php
// Turn off all error reporting
error_reporting(0);
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php');
ob_start();
header("Cache-control: private");
$confirm = false;

$error_msg = "";
//validate registration form
$error_msg = validate_form("changerequest");
if ($error_msg !== "") {
	//failed - return to form with error messages
	$return_form = $_POST;
	include_once('change_request.php');
} else {
 	// check for attachment
	if (($_FILES['attachment']['name'] != "") && ($_FILES['attachment']['tmp_name'] != "none")) { // empty form submission still passes some usesless values
		$upload_errors = array( 1 => 'The uploaded file exceeds the upload_max_filesize directive for this server.', 'The uploaded file exceeds the MAX_FILE_SIZE allowed for this form.', 'The uploaded file was only partially uploaded', 'No file was uploaded');
		$new_filename = "UID".$_POST['sessionid']."_".$_FILES['attachment']['name'];
		if (move_uploaded_file($_FILES['attachment']['tmp_name'], (UPLOADED_FILES_TEMP_DIR . $new_filename))) {
			$attachment = $_FILES['attachment']['name'];
		}
		else {
			$error_msg = "Sorry, the file \"".$_FILES['attachment']['name']."\" <B>failed to upload</B> properly.<br>\n";
			$error_msg .= "Specific upload error: ".$upload_errors[$_FILES['attachment']['error']]."<br>\n";
		}
	}
	else {
		$attachment = '';
	}
	if ($error_msg !== "") {		
		//failed - return to form with error messages
		$return_form = $_POST;
		include_once ('change_request.php');
	} else {
		//passed - process request
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
		$fax = fix_phone_in("fax");
		$email = $_POST['email'];
		$comments = $_POST['comments'];
		$signup_date = date("Ymd");
		$computer_details = $_SERVER['HTTP_USER_AGENT'];
		$ip_address = $_SERVER['REMOTE_ADDR'];
		$product = $_POST['product'];
		$other_product = $_POST['other_product'];
		//add to db 
		$user_array = Array (
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
					'fax'=>$fax,
					'email'=>$email,
					'product'=>$product,
					'other_product'=>$other_product,
					'comments'=>$comments,
					'attachment'=>$attachment,
					'signup_date'=>$signup_date,
					'computer_details'=>$computer_details,
					'ip_address'=>$ip_address
					);
		$result = insertSoftwareChangeRequest($user_array);
		if (!$result) {
			include_once($_SERVER['DOCUMENT_ROOT'].'/public/register/change_request_error.php');
		} else {
			$phone = fix_phone_out($phone);
			$fax = fix_phone_out($fax);
			//notify registration admin
			$today = date("F j, Y, g:i a");
			$mailmsg = "
			You have received a request for a software change from MySMS.
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
			Fax = $fax
			Email = $email
			Product - $str_iaminterestedin
			Other Product - $str_referredby
			Comments = $comments
	
			Logged in User Id = $logged_in_userid
			Computer Details = $computer_details
			IP Address = $ip_address
			";
			//if ($state == 'CA') {
				//$emails_sql = "SELECT DISTINCT email FROM representatives,repdb,counties WHERE representatives.id = repdb.rep_id AND counties.id = repdb.county_id AND state_id = 'CA' AND counties.heading = '$county'";
			//} else {
				//$emails_sql = "SELECT DISTINCT email FROM representatives,repdb,counties WHERE representatives.id = repdb.rep_id AND state_id = '$state'";					
			//}
			//$emails_result = getEmailList($emails_sql);
			
			if ($attachment !== "") {
				$attachment_array = array(UPLOADED_FILES_TEMP_DIR.$new_filename);
				sendAttachment(SOFTWARE_CHANGE_EMAIL.$emails_result,"MySMS Request for Software Change",$mailmsg,"From: ".ADMINISTRATION_EMAIL,$attachment_array);
				if (file_exists(UPLOADED_FILES_TEMP_DIR.$new_filename)) {
					unlink(UPLOADED_FILES_TEMP_DIR.$new_filename);
				}
			} else {
				//mail(SOFTWARE_CHANGE_EMAIL.$emails_result,"MySMS Request for Software Change",$mailmsg,"From: ".ADMINISTRATION_EMAIL."\r\n");
				mail(SOFTWARE_CHANGE_EMAIL,"MySMS Request for Software Change",$mailmsg,"From: ".ADMINISTRATION_EMAIL."\r\n");
			}
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
		"title"=>"Software Change Request Confirm",
		"description"=>"Multiple Content Paragraphs with optional headings. Optional picture at top of paragraph, aligned right. Empty fields are ignored. To delete content simply update with empty values.",		
		"display_type"=>"title_paragraph_picture_right",		
		"blanks"=>"1",		
		"table_name"=>"public_change_confirm",
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


<?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/header.php'); ?>
<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="188" height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="188" height="300"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/subnav_feedback.php'); ?><br>
	<?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/subnav_logregister.php'); ?>
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
        <td valign="top" bgcolor="#FFFFFF" class="text1"><?php content_display("chunk1","<p>","</p>"); ?></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td class="text1">&nbsp;</td>
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
<?php 
}
?>