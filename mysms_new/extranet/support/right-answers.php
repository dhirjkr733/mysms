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

if ($testmode) {
	$formAction = 'http://design2.rightanswers.com:5080/firstam/ss/index.jsp';
} else {
	$formAction = 'http://65.200.65.98/portal/ss/';
}
?><html>
<head>
<title>Right Answers Right Now</title>
<script type="text/javascript">
	function generateRightAnswersToken () {
		var myForm=document.createElement('form');
		var myInput=document.createElement('input');
		myInput.type = 'hidden';
		myInput.name = 'mysmstoken';
		myInput.value = '<?php echo generateRightAnswersToken();?>';
		
		document.body.appendChild(myForm);
		myForm.action = '<?php echo $formAction; ?>';
		myForm.method = 'POST';
		myForm.appendChild(myInput);
		myForm.submit();
	}
</script>
</head>
<body onload="generateRightAnswersToken();">
</body>
</html>