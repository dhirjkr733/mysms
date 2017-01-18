<?php 
// Turn off all error reporting
error_reporting(0);
ob_start();
session_start();

require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php');
header("Cache-control: private");
$confirm = false;
//print_r($_COOKIE);
$logged_in = checkUser($_SESSION['userid']);

/*
if(!$_SESSION['userid']){
  $_SESSION['logged_in'] 	= '1';
  $_SESSION['change_password'] 	= '';
  $_SESSION['userid'] 		= $_POST['userid'];
  $_SESSION['email'] 		= $_POST['email'];
  $_SESSION['firstname'] 	= $_POST['firstname'];
  $_SESSION['lastname'] 	= $_POST['lastname'];
  $_SESSION['default_state'] 	= $_POST['state'];
  $_SESSION['default_product'] 	= 'VISION';
  $logged_in 			= 1;//Force logged_in = 1 so it can pass login check - 7/05/2006	
}
*/

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
	$error_msg = validate_form("uploaddocuments");
        
	if ($error_msg !== "") {
		//failed - return to form with error messages
		$return_form = $_POST;
		include_once ('upload_documents.php');
	} else {
 		// check for attachment
		if (($_FILES['attachment']['name'] != "") && ($_FILES['attachment']['tmp_name'] != "none")) { // empty form submission still passes some usesless values
			$upload_errors = array( 1 => 'The uploaded file exceeds the upload_max_filesize directive for this server.', 'The uploaded file exceeds the MAX_FILE_SIZE allowed for this form.', 'The uploaded file was only partially uploaded', 'No file was uploaded');
			$new_filename = "UID".$_SESSION['userid']."_".$_FILES['attachment']['name'];
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
			include_once ('upload_documents.php');
		} else {
			//passed - process request
			$logged_in_userid = $_SESSION['userid'];
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$company = $_POST['company'];
			$state = $_POST['state'];
			if ($state === "CA") {
				$county = $_POST['county'];
			} else {
				$county = "";
			}
			$phone = fix_phone_in("phone");
			$email = $_POST['email'];
			$comments = $_POST['comments'];
			$signup_date = date("Ymd");
			$computer_details = $_SERVER['HTTP_USER_AGENT'];
			$ip_address = $_SERVER['REMOTE_ADDR'];
	 		
	 		/*add to db 
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
				include_once($_SERVER['DOCUMENT_ROOT'].'/extranet/feedback/change_request_error.php');
			} else {
			*/
				$phone = fix_phone_out($phone);
				//notify registration admin
				$today = date("F j, Y, g:i a");
				$mailmsg = "
				You have received an uploaded document from MySMS.
				Received: $today.

				First Name = $firstname
				Last Name = $lastname
				Company = $company
				State = $state
				County = $county
				Zip = $zip
				Phone = $phone
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
				if ($attachment !== "") {
					$attachment_array = array(UPLOADED_FILES_TEMP_DIR.$new_filename);
					sendAttachment(UPLOADED_DOCUMENT_EMAIL.','.$emails_result,"MySMS Uploaded Document",$mailmsg,"From: ".ADMINISTRATION_EMAIL,$attachment_array);
					if (file_exists(UPLOADED_FILES_TEMP_DIR.$new_filename)) {
						unlink(UPLOADED_FILES_TEMP_DIR.$new_filename);
					}
				} else {
					mail(UPLOADED_DOCUMENT_EMAIL.','.$emails_result,"MySMS Uploaded Document",$mailmsg,"From: ".ADMINISTRATION_EMAIL."\r\n");					
				}
				$confirm = true;
			//}
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
		"title"=>"Upload Documents Confirmation Content",
		"description"=>"Multiple Content Paragraphs with optional headings. Optional picture at top of paragraph, aligned right. Empty fields are ignored. To delete content simply update with empty values.",		
		"display_type"=>"title_paragraph_picture_right",		
		"blanks"=>"1",		
		"table_name"=>"upload_documents_confirmation",
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
    <td width="188" height="300"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/subnav_implementation.php'); ?></td>
    <td width="1" bgcolor="#CCCCCC"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
      <tr bgcolor="#FFCC00" class="textbody">
        <td bgcolor="#FFCC00"><table width="515" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="321" class="textbody"><b>Upload Documents &amp; Logos </b></td>
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
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/footer.php'); ?>
<p>&nbsp;</p>
</body>
</html>
<?php
}
?>