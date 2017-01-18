<?php 
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php');
db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
$sqlstr = "SELECT CONCAT(firstname,' ',lastname) as fullname, 
		company, 
		email,
		signup_date,
		DATE(last_login) as last_login, 
		(TO_DAYS(last_login) - TO_DAYS(signup_date)) as signup_to_last, 
		(TO_DAYS(NOW()) - TO_DAYS(last_login)) as today_to_last, 
		registration_status, DECODE(password,'" . SALT . "') as password FROM users";
		
$result = @mysql_query ($sqlstr);
if (!$result) {
	sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
	$count = 0;
	$output_str = "A database error occurred while generating your user report. Please <a href=\"user_reports.php\">try again</a>.";
	print($output_str);
	exit;
} else {

	$total_records = mysql_num_rows($result);
	if ($total_records > 0) {
	
		$output_str = "<html>\n";
		$output_str .= "<head>\n";
		$output_str .= "<title>MySMS User Report</title>\n";
		$output_str .= "</head>\n";
		$output_str .= "<body>\n";
		$output_str .= "<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
		$output_str .= "  <tr><th>MySMS User Report</th></tr>";
		$output_str .= "</table>";
		$output_str .= "<table width=\"100%\" border=\"1\" cellspacing=\"0\" cellpadding=\"0\">";
		$output_str .= "  <tr>";		
		$output_str .= "    <th>Registrant First and Last Name</th>";
		$output_str .= "    <th>Company Name</th>";
		$output_str .= "    <th>Email Address</th>";
		$output_str .= "    <th>Date First Signed Up</th>";
		$output_str .= "    <th>Date of Last Login</th>";
		$output_str .= "    <th># of days between sign up and last login</th>";
		$output_str .= "    <th># of days between last login and today's date</th>";
		$output_str .= "    <th>Registration Status</th>";
		$output_str .= "    <th>Password</th>";
		$output_str .= "  </tr>";

		$cvs_str = "MySMS User Report\n";
		$cvs_str .= "Registrant First and Last Name\t";
		$cvs_str .= "Company Name\t";
		$cvs_str .= "Email Address\t";
		$cvs_str .= "Date First Signed Up\t";
		$cvs_str .= "Date of Last Login\t";
		$cvs_str .= "# of days between sign up and last login\t";
		$cvs_str .= "# of days between last login and today's date\t";
		$cvs_str .= "Registration Status\t";
		$cvs_str .= "Password\t\n";
		
		while ($row = mysql_fetch_assoc($result)) {
			$fullname = stripslashes($row['fullname']);
			$company = stripslashes($row['company']);
			$email = stripslashes($row['email']);
			$signup_date = stripslashes($row['signup_date']);
			$last_login = stripslashes($row['last_login']);
			$today_to_last = stripslashes($row['today_to_last']);
			$signup_to_last = stripslashes($row['signup_to_last']);
			$registration_status = stripslashes($row['registration_status']);
			$password = stripslashes($row['password']);
		
			$output_str .= "  <tr>";
			$output_str .= "    <td>$fullname</td>";
			$output_str .= "    <td>$company</td>";
			$output_str .= "    <td>$email</td>";
			$output_str .= "    <td>$signup_date</td>";
			$output_str .= "    <td>$last_login</td>";
			$output_str .= "    <td>$signup_to_last</td>";
			$output_str .= "    <td>$today_to_last</td>";
			$output_str .= "    <td>$registration_status</td>";
			$output_str .= "    <td>$password</td>";
			$output_str .= "  </tr>";
						
			$cvs_str .= "$fullname\t";
			$cvs_str .= "$company\t";
			$cvs_str .= "$email\t";
			$cvs_str .= "$signup_date\t";
			$cvs_str .= "$last_login\t";
			$cvs_str .= "$signup_to_last\t";
			$cvs_str .= "$today_to_last\t";			
			$cvs_str .= "$registration_status\t";			
			$cvs_str .= "$password\t\n";
		}
		
		$output_str .= "  </table>";
		$output_str .= "  </body>";
		$output_str .= "  </html>";
		
		header("Content-length: " . strlen($output_str));
		//header("Content-length: " . strlen($cvs_str));
		
		header("Content-Type: application/vnd.ms-excel");
		header("Content-Disposition:attachment; filename=user_report.xls");
		header("Pragma: no-cache");
		header("Expires: 0");
		print($output_str);
		// print($cvs_str);
		exit;			 
	}
	else {
		$output_str = "There were no records that matched your query. Please <a href=\"user_.php\">try again</a>.";
		print($output_str);
		exit;
	}
}
?>