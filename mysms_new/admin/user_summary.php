<?php 
ob_start();
session_start();
header("Cache-control: private");
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php');
$logged_in = checkUser($_SESSION['userid'],true);
$login_error = "";
if (isset($_POST['login'])) {// coming from login form
	if ((trim($_POST["email"]) !== "") && (trim($_POST['password']) !== "")) {
		db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
		$email = quote_smart($_POST["email"]);
		$password = $_POST["password"];
		$login_sql = "SELECT id,email,firstname,lastname 
				FROM admin 
				WHERE email=$email AND password=ENCODE('$password','".SALT."')";
		$login_result = mysql_query($login_sql);
		if ($login_result) {
			if (mysql_num_rows($login_result) > 0) {
				$user = mysql_fetch_array($login_result);
				$logged_in = true;
				$_SESSION['admin'] = true;
				$_SESSION['logged_in'] = true;
				$_SESSION['userid'] = $user['id'];
				$_SESSION['email'] = $user['email'];
				$_SESSION['firstname'] = $user['firstname'];
				$_SESSION['lastname'] = $user['lastname'];
			} else {
				$login_error = "Your username or password was incorrect. Please <a href=\"index.php\">click here</a> to try again.";
			}
		} else {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			$login_error = "There was an error retrieving your account information. Please <a href=\"index.php\">try again</a>.";	
		}
	} else {
		$login_error = "Your E-mail Address and/or MySMS Password was missing. Please <a href=\"index.php\">try again</a>.";	
	}		
}
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
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	$limit='';
	$criteria='';
	switch ($_POST['searchby']) {
		case "clientid":
			$criteria = " AND clientid LIKE '{$_POST['searchterm']}%'";
			break;
		case "date":
			$datefrom = $_POST['from_year']."-". $_POST['from_month']."-".$_POST['from_day'];
			$dateto = $_POST['to_year']."-". $_POST['to_month']."-".$_POST['to_day'];
			if (($datefrom !== "--") || ($dateto !== "--")) {
				if ($datefrom !== $dateto) {
					if ($datefrom !== "--") {
						$criteria .= " AND signup_date >= '$datefrom'";
					}
					if ($dateto !== "--") {
						$criteria .= " AND signup_date <= '$dateto'";
					}
				} else {
					$criteria .= " AND TO_DAYS(signup_date) = TO_DAYS('$datefrom')";
				}
			}			
			break;
		case "alpha":
			$criteria = " AND lastname LIKE '{$_POST['alpha']}%'";
			break;
		case "registration_status":
			if ($_POST['registration_status'] === "All") {
				$criteria = " AND registration_status != ''";
			} else {
				$criteria = " AND registration_status='{$_POST['registration_status']}'";
			}
			break;
		case "company":
			$criteria = " AND company LIKE '%{$_POST['company_name']}%'";
			break;
		case "firstname":
			$criteria = " AND firstname LIKE '%{$_POST['searchterm']}%'";
			break;
		case "lastname":
			$criteria = " AND lastname LIKE '%{$_POST['searchterm']}%'";
			break;
		case "email":
			$criteria = " AND email LIKE '%{$_POST['searchterm']}%'";
			break;
		default:
			$criteria = " AND registration_status='Profile Update' OR registration_status='Pending'";
			break;
	}
	if($_POST['sortby'] != "") {
		$orderby = $_POST['sortby']." ".$_POST['direction'];
	} else {
		$orderby = "registration_status DESC,signup_date DESC";
	}
	if ((isset($_POST['limit'])) && ($_POST['limit'] !== "")) {
		if ($_POST['limit'] !== 0) {
			$this_limit = "{$_POST['limit']}, ".USER_SUMMARY_MAX_RECORDS_RETURNED;
		} else {
			$this_limit = USER_SUMMARY_MAX_RECORDS_RETURNED;
		}
	} else {
		$this_limit = USER_SUMMARY_MAX_RECORDS_RETURNED;
	}
	$sql = "SELECT id, firstname, lastname, city, state, company, registration_status
			FROM users
			WHERE id !='' $criteria";
	$findcount = @mysql_query ($sql);
	//echo $sql;
	if (!$findcount) {
		sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
		$count = 0;
		$mesg = "A database error occurred while retrieving your query results. Please <a href=\"user_summary.php\">try again</a>.";
	} else {
		$total_records = mysql_num_rows($findcount);
		if ($total_records > 0) {
			$sql .= " ORDER BY $orderby LIMIT $this_limit";
			$limited_results = @mysql_query($sql);
			if(!$limited_results) {
				$count=0;
			} else {
				$count = mysql_num_rows($limited_results);
			}
		} else {
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
function sortColumn(fld) {
	frm=document.action_form;
	if (frm.sortby.value != fld) {
		frm.sortby.value = fld;
	} else {
		if (frm.direction.value == 'DESC') {
			frm.direction.value = 'ASC';
		} else {
			frm.direction.value = 'DESC';
		}
	}
	frm.submit();	
}
function getLastName(letter) {
	frm=document.action_form;
	frm.action='user_summary.php';
	frm.alpha.value = letter;
	frm.searchby.value = 'alpha';
	frm.limit.value = '';
	frm.sortby.value = 'lastname';
	frm.direction.value = 'ASC';
	frm.submit();	
}
function getRegStat(){
	frm=document.regstat;
	frm.submit();
}
function getCompanyName(){
	frm=document.compname;
	frm.submit();
}
function getPage(num) {
	frm=document.action_form;
	frm.action='user_summary.php';
	frm.limit.value = num;
	frm.submit();	
}
function editMember(num) {
	frm=document.action_form;
	frm.action='user_detail.php';
	frm.id.value = num;
	frm.submit();	
}
function deleteMember(num) {
	frm=document.action_form;
	frm.action='user_delete.php';
	frm.id.value = num;
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
              				<td class="textbody"><b>MySMS Registrant Summary</b></td>
              				<td align="right">&nbsp;</td>
            			</tr>
        			</table>
				</td>
      		</tr>
      		<tr bgcolor="#FFFFFF">
        		<td valign="top" bgcolor="#FFFFFF" class="text1"><p><a href='user_add.php'>Add a new user.</a></p><p>Please enter your search criteria below.</p></td>
      		</tr>
    	</table>
    	<table width="100%" bgcolor="#000000" border="0" align="center" cellpadding="2" cellspacing="1" id="prev">
      		<tr valign="middle">
        		<td valign="middle" align="center" bgcolor="#FFFFFF" class="textbody">
        <form name="search1" id="search1" method="POST" action="user_summary.php">
        			<table border="0" cellpadding="0" cellspacing="5">
						<tr>
							<td align="left" class="textbody">Search:</td>
							<td align="left" class="textbody"><input type="text" name="searchterm" value="<?php print $_POST['searchterm']; ?>"></td>
						</tr>
						<tr>
							<td align="left" class="textbody">&nbsp;</td>
							<td align="left" class="textbody"><input type="radio" name="searchby" value="clientid"<?php if ($_POST['searchby'] == 'clientid') print " checked"; ?>> Client ID</td>
						</tr>
						<tr>
							<td align="left" class="textbody">&nbsp;</td>
							<td align="left" class="textbody"><input type="radio" name="searchby" value="firstname"<?php if ($_POST['searchby'] === 'firstname') print " checked"; ?>> First Name</td>
						</tr>
						<tr>
							<td align="left" class="textbody">&nbsp;</td>
							<td align="left" class="textbody"><input type="radio" name="searchby" value="lastname"<?php if ($_POST['searchby'] === 'lastname') print " checked"; ?>> Last Name</td>
						</tr>
						<tr>
							<td align="left" class="textbody">&nbsp;</td>
							<td align="left" class="textbody"><input type="radio" name="searchby" value="email"<?php if ($_POST['searchby'] === 'email') print " checked"; ?>> E-mail Address</td>
						</tr>
						<tr>
							<td colspan="2" align="right" class="textbody"><input type="submit" name="Submit" value="Submit"></td>
						</tr>
					</table>
		</form>
				</td>
       			<td valign="middle" align="center" bgcolor="#FFFFFF" class="textbody">
        	<form name="search2" id="search2" method="POST" action="user_summary.php">
        			<table border="0" cellpadding="0" cellspacing="5">
        				<tr>
        					<td valign="middle" align="left" colspan="2" class="textbody">Signup Date Range:</td>
        				</tr>
        				<tr>
        					<td align="left" class="textbody">From:</td>
        					<td align="left" class="textbody">
        				<select name="from_month">
        					<option value=""<?php if ($_POST['from_month']=="") print " selected"; ?>>Month</option>
        					<option value="01"<?php if ($_POST['from_month']=="01") print " selected"; ?>>Jan</option>
        					<option value="02"<?php if ($_POST['from_month']=="02") print " selected"; ?>>Feb</option>
        					<option value="03"<?php if ($_POST['from_month']=="03") print " selected"; ?>>Mar</option>
        					<option value="04"<?php if ($_POST['from_month']=="04") print " selected"; ?>>Apr</option>
        					<option value="05"<?php if ($_POST['from_month']=="05") print " selected"; ?>>May</option>
        					<option value="06"<?php if ($_POST['from_month']=="06") print " selected"; ?>>Jun</option>
        					<option value="07"<?php if ($_POST['from_month']=="07") print " selected"; ?>>Jul</option>
        					<option value="08"<?php if ($_POST['from_month']=="08") print " selected"; ?>>Aug</option>
        					<option value="09"<?php if ($_POST['from_month']=="09") print " selected"; ?>>Sep</option>
        					<option value="10"<?php if ($_POST['from_month']=="10") print " selected"; ?>>Oct</option>
        					<option value="11"<?php if ($_POST['from_month']=="11") print " selected"; ?>>Nov</option>
        					<option value="12"<?php if ($_POST['from_month']=="12") print " selected"; ?>>Dec</option>
        				</select>/
        				<select name="from_day">
        					<option value=""<?php if ($_POST['from_day']=="") print " selected"; ?>>Day</option>
        					<option value="01"<?php if ($_POST['from_day']=="01") print " selected"; ?>>01</option>
        					<option value="02"<?php if ($_POST['from_day']=="02") print " selected"; ?>>02</option>
        					<option value="03"<?php if ($_POST['from_day']=="03") print " selected"; ?>>03</option>
        					<option value="04"<?php if ($_POST['from_day']=="04") print " selected"; ?>>04</option>
        					<option value="05"<?php if ($_POST['from_day']=="05") print " selected"; ?>>05</option>
        					<option value="06"<?php if ($_POST['from_day']=="06") print " selected"; ?>>06</option>
        					<option value="07"<?php if ($_POST['from_day']=="07") print " selected"; ?>>07</option>
        					<option value="08"<?php if ($_POST['from_day']=="08") print " selected"; ?>>08</option>
        					<option value="09"<?php if ($_POST['from_day']=="09") print " selected"; ?>>09</option>
        					<option value="10"<?php if ($_POST['from_day']=="10") print " selected"; ?>>10</option>
        					<option value="11"<?php if ($_POST['from_day']=="11") print " selected"; ?>>11</option>
        					<option value="12"<?php if ($_POST['from_day']=="12") print " selected"; ?>>12</option>
        					<option value="13"<?php if ($_POST['from_day']=="13") print " selected"; ?>>13</option>
        					<option value="14"<?php if ($_POST['from_day']=="14") print " selected"; ?>>14</option>
        					<option value="15"<?php if ($_POST['from_day']=="15") print " selected"; ?>>15</option>
        					<option value="16"<?php if ($_POST['from_day']=="16") print " selected"; ?>>16</option>
        					<option value="17"<?php if ($_POST['from_day']=="17") print " selected"; ?>>17</option>
        					<option value="18"<?php if ($_POST['from_day']=="18") print " selected"; ?>>18</option>
        					<option value="19"<?php if ($_POST['from_day']=="19") print " selected"; ?>>19</option>
        					<option value="20"<?php if ($_POST['from_day']=="20") print " selected"; ?>>20</option>
        					<option value="21"<?php if ($_POST['from_day']=="21") print " selected"; ?>>21</option>
        					<option value="22"<?php if ($_POST['from_day']=="22") print " selected"; ?>>22</option>
        					<option value="23"<?php if ($_POST['from_day']=="23") print " selected"; ?>>23</option>
        					<option value="24"<?php if ($_POST['from_day']=="24") print " selected"; ?>>24</option>
        					<option value="25"<?php if ($_POST['from_day']=="25") print " selected"; ?>>25</option>
        					<option value="26"<?php if ($_POST['from_day']=="26") print " selected"; ?>>26</option>
        					<option value="27"<?php if ($_POST['from_day']=="27") print " selected"; ?>>27</option>
        					<option value="28"<?php if ($_POST['from_day']=="28") print " selected"; ?>>28</option>
        					<option value="29"<?php if ($_POST['from_day']=="29") print " selected"; ?>>29</option>
        					<option value="30"<?php if ($_POST['from_day']=="30") print " selected"; ?>>30</option>
        					<option value="31"<?php if ($_POST['from_day']=="31") print " selected"; ?>>31</option>
        				</select>/
        				<select name="from_year">
        					<option value=""<?php if ($_POST['from_year']=="") print " selected"; ?>>Year</option>
        					<?php
        						$yr = date("Y") + 0;
        						for($i=$yr;$i>2003;$i--) {
        							print "<option value=\"$i\"";
        							if ((int)$_POST['from_year']===$i) print " selected";
        							print ">$i</option>\n";
        						}
        					?>
        				</select>
        					</td>
        				</tr>
        				<tr>
        					<td align="left" class="textbody">To:</td>
        					<td align="left" class="textbody">
        				<select name="to_month">
        					<option value=""<?php if ($_POST['to_month']=="") print " selected"; ?>>Month</option>
        					<option value="01"<?php if ($_POST['to_month']=="01") print " selected"; ?>>Jan</option>
        					<option value="02"<?php if ($_POST['to_month']=="02") print " selected"; ?>>Feb</option>
        					<option value="03"<?php if ($_POST['to_month']=="03") print " selected"; ?>>Mar</option>
        					<option value="04"<?php if ($_POST['to_month']=="04") print " selected"; ?>>Apr</option>
        					<option value="05"<?php if ($_POST['to_month']=="05") print " selected"; ?>>May</option>
        					<option value="06"<?php if ($_POST['to_month']=="06") print " selected"; ?>>Jun</option>
        					<option value="07"<?php if ($_POST['to_month']=="07") print " selected"; ?>>Jul</option>
        					<option value="08"<?php if ($_POST['to_month']=="08") print " selected"; ?>>Aug</option>
        					<option value="09"<?php if ($_POST['to_month']=="09") print " selected"; ?>>Sep</option>
        					<option value="10"<?php if ($_POST['to_month']=="10") print " selected"; ?>>Oct</option>
        					<option value="11"<?php if ($_POST['to_month']=="11") print " selected"; ?>>Nov</option>
        					<option value="12"<?php if ($_POST['to_month']=="12") print " selected"; ?>>Dec</option>
        				</select>/
        				<select name="to_day">
        					<option value=""<?php if ($_POST['to_day']=="") print " selected"; ?>>Day</option>
        					<option value="01"<?php if ($_POST['to_day']=="01") print " selected"; ?>>01</option>
        					<option value="02"<?php if ($_POST['to_day']=="02") print " selected"; ?>>02</option>
        					<option value="03"<?php if ($_POST['to_day']=="03") print " selected"; ?>>03</option>
        					<option value="04"<?php if ($_POST['to_day']=="04") print " selected"; ?>>04</option>
        					<option value="05"<?php if ($_POST['to_day']=="05") print " selected"; ?>>05</option>
        					<option value="06"<?php if ($_POST['to_day']=="06") print " selected"; ?>>06</option>
        					<option value="07"<?php if ($_POST['to_day']=="07") print " selected"; ?>>07</option>
        					<option value="08"<?php if ($_POST['to_day']=="08") print " selected"; ?>>08</option>
        					<option value="09"<?php if ($_POST['to_day']=="09") print " selected"; ?>>09</option>
        					<option value="10"<?php if ($_POST['to_day']=="10") print " selected"; ?>>10</option>
        					<option value="11"<?php if ($_POST['to_day']=="11") print " selected"; ?>>11</option>
        					<option value="12"<?php if ($_POST['to_day']=="12") print " selected"; ?>>12</option>
        					<option value="13"<?php if ($_POST['to_day']=="13") print " selected"; ?>>13</option>
        					<option value="14"<?php if ($_POST['to_day']=="14") print " selected"; ?>>14</option>
        					<option value="15"<?php if ($_POST['to_day']=="15") print " selected"; ?>>15</option>
        					<option value="16"<?php if ($_POST['to_day']=="16") print " selected"; ?>>16</option>
        					<option value="17"<?php if ($_POST['to_day']=="17") print " selected"; ?>>17</option>
        					<option value="18"<?php if ($_POST['to_day']=="18") print " selected"; ?>>18</option>
        					<option value="19"<?php if ($_POST['to_day']=="19") print " selected"; ?>>19</option>
        					<option value="20"<?php if ($_POST['to_day']=="20") print " selected"; ?>>20</option>
        					<option value="21"<?php if ($_POST['to_day']=="21") print " selected"; ?>>21</option>
        					<option value="22"<?php if ($_POST['to_day']=="22") print " selected"; ?>>22</option>
        					<option value="23"<?php if ($_POST['to_day']=="23") print " selected"; ?>>23</option>
        					<option value="24"<?php if ($_POST['to_day']=="24") print " selected"; ?>>24</option>
        					<option value="25"<?php if ($_POST['to_day']=="25") print " selected"; ?>>25</option>
        					<option value="26"<?php if ($_POST['to_day']=="26") print " selected"; ?>>26</option>
        					<option value="27"<?php if ($_POST['to_day']=="27") print " selected"; ?>>27</option>
        					<option value="28"<?php if ($_POST['to_day']=="28") print " selected"; ?>>28</option>
        					<option value="29"<?php if ($_POST['to_day']=="29") print " selected"; ?>>29</option>
        					<option value="30"<?php if ($_POST['to_day']=="30") print " selected"; ?>>30</option>
        					<option value="31"<?php if ($_POST['to_day']=="31") print " selected"; ?>>31</option>
        				</select>/
        				<select name="to_year">
        					<option value=""<?php if ($_POST['to_year']=="") print " selected"; ?>>Year</option>
        					<?php
        						$yr = date("Y") + 0;
        						for($i=$yr;$i>2003;$i--) {
        							print "<option value=\"$i\"";
        							if ((int)$_POST['to_year']===$i) print " selected";
        							print ">$i</option>\n";
        						}
        					?>
        				</select>
        					</td>
        				</tr>
        				<tr>
        					<td colspan="2" class="textbody">&nbsp;</td>
        				</tr>
        				<tr>
        					<td align="left" class="textbody"><input type="hidden" name="searchby" value="date"></td>
        					<td align="right" class="textbody"><input type="submit" name="Submit" value="Submit"></td>
        				</tr>
					</table>
			</form>
				</td>
      		</tr>
      		<tr valign="middle"><form name="compname" id="compname" method="POST" action="user_summary.php"><?php $companies = getCompanies(); ?>
        		<td colspan="2" valign="middle" align="center" bgcolor="#FFFFFF" class="textbody">Company Name:
              <select name="company_name" class="textbody" onchange="javascript:getCompanyName();"><?php $company_name = $_POST['company_name']; ?>
              	<option value=""<?php if ($company_name === "") print " selected"; ?>>Select...</option>
              	<?php 
              		foreach ($companies as $comp) {
              			if ($company_name === $comp) {
              				print "<option value=\"$comp\" selected>$comp</option>";
              			} else {
              				print "<option value=\"$comp\">$comp</option>";
              			}
              		}
              	?>
              </select>
              <input type="hidden" name="searchby" value="company">
			  	</td></form>
      		</tr>
      		<tr valign="middle">
        		<td colspan="2" valign="middle" align="center" bgcolor="#FFFFFF" class="textbody">Last Name:&nbsp;
        	<a href="javascript:getLastName('A');">A</a>&nbsp;
        	<a href="javascript:getLastName('B');">B</a>&nbsp;
        	<a href="javascript:getLastName('C');">C</a>&nbsp;
        	<a href="javascript:getLastName('D');">D</a>&nbsp;
        	<a href="javascript:getLastName('E');">E</a>&nbsp;
        	<a href="javascript:getLastName('F');">F</a>&nbsp;
        	<a href="javascript:getLastName('G');">G</a>&nbsp;
        	<a href="javascript:getLastName('H');">H</a>&nbsp;
        	<a href="javascript:getLastName('I');">I</a>&nbsp;
        	<a href="javascript:getLastName('J');">J</a>&nbsp;
        	<a href="javascript:getLastName('K');">K</a>&nbsp;
        	<a href="javascript:getLastName('L');">L</a>&nbsp;
        	<a href="javascript:getLastName('M');">M</a>&nbsp;
        	<a href="javascript:getLastName('N');">N</a>&nbsp;
        	<a href="javascript:getLastName('O');">O</a>&nbsp;
        	<a href="javascript:getLastName('P');">P</a>&nbsp;
        	<a href="javascript:getLastName('Q');">Q</a>&nbsp;
        	<a href="javascript:getLastName('R');">R</a>&nbsp;
        	<a href="javascript:getLastName('S');">S</a>&nbsp;
        	<a href="javascript:getLastName('T');">T</a>&nbsp;
        	<a href="javascript:getLastName('U');">U</a>&nbsp;
        	<a href="javascript:getLastName('V');">V</a>&nbsp;
        	<a href="javascript:getLastName('W');">W</a>&nbsp;
        	<a href="javascript:getLastName('X');">X</a>&nbsp;
        	<a href="javascript:getLastName('Y');">Y</a>&nbsp;
        	<a href="javascript:getLastName('Z');">Z</a>
        		</td>
      		</tr>
      		<tr valign="middle"><form name="regstat" id="regstat" method="POST" action="user_summary.php">
        		<td colspan="2" valign="middle" align="center" bgcolor="#FFFFFF" class="textbody">Registration Status:
              <select name="registration_status" class="textbody" onchange="javascript:getRegStat();"><?php $registration_status = $_POST['registration_status']; ?>
              	<option value=""<?php if ($registration_status === "") print " selected"; ?>>Select...</option>
                <option value="Pending"<?php if ($registration_status === "Pending") print " selected"; ?>>Pending</option>
                <option value="Approved"<?php if ($registration_status === "Approved") print " selected"; ?>>Approved</option>
                <option value="Credit Hold"<?php if ($registration_status === "Credit Hold") print " selected"; ?>>Credit Hold</option>
                <option value="Inactive"<?php if ($registration_status === "Inactive") print " selected"; ?>>Inactive</option>
                <option value="Denied"<?php if ($registration_status === "Denied") print " selected"; ?>>Denied</option>
                <option value="Profile Update"<?php if ($registration_status === "Profile Update") print " selected"; ?>>Profile Update</option>
                <option value="All"<?php if ($registration_status === "All") print " selected"; ?>>All</option>
              </select>
              <input type="hidden" name="searchby" value="registration_status">
			  	</td></form>
      		</tr>
    	</table>
    	<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="1" id="prev">
      		<tr>
       	  		<td width="30%" align="left" valign="middle" class="text1">
       	  	<?php 
       	  		if ($total_records > USER_SUMMARY_MAX_RECORDS_RETURNED) { 
                	$prev = (int)$_POST['limit'] - USER_SUMMARY_MAX_RECORDS_RETURNED;
                     if ($prev >= 0) {
                     	print "<a href=\"javascript:getPage('$prev')\">previous</a>";
	                 } else {
                      	print "previous";
                     }
       	  		} else {
                	print "previous";
                }
       	  	?>	</td>
       	  		<td width="30%" align="center" valign="middle" class="text1">
       	  	<?php 
       	  		if ($count > 0) { 
       	  			$from_record = (int)$_POST['limit'] + 1;
                	$to_record = (int)$_POST['limit'] + $count;
               	 	print "$from_record to $to_record of $total_records";
       	  		}
       	  	?>	</td>
       	  		<td width="30%" align="right" valign="middle" class="text1">
       	  	<?php 
       	  		if ($total_records > USER_SUMMARY_MAX_RECORDS_RETURNED) { 
                	$next = (int)$_POST['limit'] + USER_SUMMARY_MAX_RECORDS_RETURNED;
                    if ($next < $total_records) {
                    	print "<a href=\"javascript:getPage('$next')\">next</a>";
                    } else {
                    	print "next";
                    }
       	  		} else {
                   	print "next";
                }
       	  	?>	</td>
       		</tr>
		</table>
    		<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="1" id="results">
				<tr bgcolor="#CCCCCC" class="textbody">
				  <td><b>Co Name</b></td>
				  <td><b>City</b></td>
				  <td><b>State</b></td>
				  <td><b>Last Name</b></td>
				  <td><b>First Name</b></td>
				  <td><b>Status </b></td>
				  <td align="center"><b>Action</b></td>
				</tr>
        <?php 
        	if ($count > 0) {
        		while ($row = mysql_fetch_array($limited_results)) {
        ?>
				<tr bgcolor="#EDEDED" class="text1">
				  <td class="text1"><?php print $row['company']; ?></td>
				  <td class="text1"><?php print $row['city']; ?></td>
				  <td class="text1"><?php print $row['state']; ?></td>
				  <td class="text1"><?php print $row['lastname']; ?></td>
				  <td class="text1"><?php print $row['firstname']; ?></td>
				  <td class="text1"><?php print $row['registration_status']; ?></td>
				  <td align="center" class="text1" valign="center">
					<?php
							print "<a href=\"javascript:editMember({$row['id']});\" class=\"text1\">Edit</a>\n";
							print "<br>";
							print "<a href=\"javascript:deleteMember({$row['id']});\" class=\"text1\">Delete</a>\n";
					?></td>
				</tr>
        <?php
        		}
        ?>
				<tr bgcolor="#CCCCCC" class="textbody">
				  <td><b>Co Name</b></td>
				  <td><b>City</b></td>
				  <td><b>State</b></td>
				  <td><b>Last Name</b></td>
				  <td><b>First Name</b></td>
				  <td><b>Status </b></td>
				  <td align="center"><b>Action</b></td>
				</tr>
        <?php
        	} else {
        ?>
        		<tr bgcolor="#EDEDED" class="text1"><td colspan="7" class="text1">There were no records that matched your query.</td></tr>
        <?php
        	}
        ?>
    		</table>
    		<table width="100%"  border="0" align="center" cellpadding="5" cellspacing="1" id="prev">
      			<tr>
       	  			<td width="30%" align="left" valign="middle" class="text1">
       	  	<?php 
       	  		if ($total_records > USER_SUMMARY_MAX_RECORDS_RETURNED) { 
                	$prev = (int)$_POST['limit'] - USER_SUMMARY_MAX_RECORDS_RETURNED;
                     if ($prev >= 0) {
                     	print "<a href=\"javascript:getPage('$prev')\">previous</a>";
	                 } else {
                      	print "previous";
                     }
       	  		} else {
                	print "previous";
                }
       	  	?>		</td>
       	  			<td width="30%" align="center" valign="middle" class="text1">
       	  	<?php 
       	  		if ($count > 0) { 
       	  			$from_record = (int)$_POST['limit'] + 1;
                	$to_record = (int)$_POST['limit'] + $count;
               	 	print "$from_record to $to_record of $total_records";
       	  		}
       	  	?></td>
       	  			<td width="30%" align="right" valign="middle" class="text1">
       	  	<?php 
       	  		if ($total_records > USER_SUMMARY_MAX_RECORDS_RETURNED) { 
                	$next = (int)$_POST['limit'] + USER_SUMMARY_MAX_RECORDS_RETURNED;
                    if ($next < $total_records) {
                    	print "<a href=\"javascript:getPage('$next')\">next</a>";
                    } else {
                    	print "next";
                    }
       	  		} else {
                   	print "next";
                }
       	  	?>		</td>
       			</tr>
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
<input type="hidden" name="id">
<input type="hidden" name="searchby" value="<?php print $_POST['searchby']; ?>">
<input type="hidden" name="sortby" value="<?php print $_POST['sortby']; ?>">
<input type="hidden" name="direction" value="<?php print $_POST['direction']; ?>">
<input type="hidden" name="limit" value="<?php print $_POST['limit']; ?>">
<input type="hidden" name="email" value="<?php print $_POST['email']; ?>">
<input type="hidden" name="registration_status" value="<?php print $_POST['registration_status']; ?>">
<input type="hidden" name="company_name" value="<?php print $_POST['company_name']; ?>">
<input type="hidden" name="alpha" value="<?php print $_POST['alpha']; ?>">
<input type="hidden" name="searchterm" value="<?php print $_POST['searchterm']; ?>">
<input type="hidden" name="from_month" value="<?php print $_POST['from_month']; ?>">
<input type="hidden" name="from_day" value="<?php print $_POST['from_day']; ?>">
<input type="hidden" name="from_year" value="<?php print $_POST['from_year']; ?>">
<input type="hidden" name="to_month" value="<?php print $_POST['to_month']; ?>">
<input type="hidden" name="to_day" value="<?php print $_POST['to_day']; ?>">
<input type="hidden" name="to_year" value="<?php print $_POST['to_year']; ?>">
</form>
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/footer.php'); ?>
<p>&nbsp;</p>
</body>
</html>
<?php
}
?>