<?php require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php'); ?>
<?php
$error_msg = "";
//validate registration form
$error_msg = validate_form("register");
if ($error_msg !== "") {
	//failed - return to form with error messages
	$return_form = $_POST;
	include_once('register.php');
} else {
	//passed - process registrant
	$email = $_POST['email'];
	$password = $_POST['password'];
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
	$default_product = $_POST['default_product'];
	$signup_date = date("Ymd");
	$registration_status = 'Pending';
	$computer_details = $_SERVER['HTTP_USER_AGENT'];
	$ip_address = $_SERVER['REMOTE_ADDR'];
	//add to db as pending registrant
	$user_array = Array (
				'email'=>$email,
				'password'=>$password,
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
				'default_product'=>$default_product,
				'signup_date'=>$signup_date,
				'registration_status'=>$registration_status,
				'computer_details'=>$computer_details,
				'ip_address'=>$ip_address
				);
	$result = insertUser($user_array);
	if (!$result) {
		include_once($_SERVER['DOCUMENT_ROOT'].'/public/register/register_error.php');
	} else {
		$phone = fix_phone_out($phone);
		$fax = fix_phone_out($fax);
		//notify registration admin
		$today = date("F j, Y, g:i a");
		$mailmsg = "
		You have a pending registration request for MySMS.
		Received: $today.
		Id: $result

		Email = $email
		Password = $password
		Firstname = $firstname
		Lastname = $lastname
		Title = $title
		Company = $company
		Address = $address
		City = $city
		State = $state
		County = $county
		Zip = $zip
		Phone = $phone
		Fax = $fax
		Default Product = $default_product
		Signup Date = $signup_date
		Registration Status = $registration_status
		Computer Details = $computer_details
		IP Address = $ip_address
		";
		mail(REGISTRATION_ADMIN_EMAIL,"MySMS New Registration Request",$mailmsg,"From: ".ADMINISTRATION_EMAIL."\r\n");
		//show confirmation screen
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
    <td width="188" height="300"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/subnav_logregister.php'); ?>
    <br>
    <?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/subnav_logregister.php'); ?></td>
    <td width="1" bgcolor="#CCCCCC"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
      <tr bgcolor="#FFCC00" class="textbody">
        <td bgcolor="#FFCC00"><table width="515" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="321" class="textbody"><b>Register for MySMS </b></td>
              <td width="194" align="right">&nbsp;</td>
            </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td valign="top" bgcolor="#FFFFFF" class="text1">
          <p>Thank you for registering for MySMS. We are certain that you will find this site to be a valuable resource for news and information about your First American SMS system or service. </p>
          <p>Since MySMS is designed for active users of First American SMS systems, your registration request has been sent to our corporate office and will be reviewed by a member of our administrative staff. Once your registration is reviewed and approved, you will receive an email confirmation with your login and password.</p>
          <p>Welcome to MySMS!</p></td>
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
}
?>