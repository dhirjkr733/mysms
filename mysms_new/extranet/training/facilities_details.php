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
$facility = getFacility($_POST['fid']);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>First American SMS</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="/mysms.css" rel="stylesheet" type="text/css">
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
    <td width="188" height="300"><?php require_once($_SERVER['DOCUMENT_ROOT'].'/extranet/includes/subnav_training.php'); ?></td>
    <td width="1" bgcolor="#CCCCCC"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
      <tr bgcolor="#FFCC00" class="textbody">
        <td bgcolor="#FFCC00"><table width="515" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td width="321" class="textbody"><b>Training Facilities</b></td>
              <td width="194" align="right"><span class="text1"><img src="/images/arrow4.gif" width="4" height="17" align="absmiddle"><a href="facilities.php" class="text1"> Back </a></span></td>
            </tr>
        </table></td>
      </tr>
      <tr bgcolor="#FFFFFF">
        <td valign="top" class="text1"><?php if (!is_array($facility)) print "Error fetching location."; ?></td>
      </tr>   
      <tr bgcolor="#FFFFFF">
        <td valign="top" class="text1"><p class="textbody"><b class="textbody">
        	<?php 
        		print $facility['heading']."</b><br>\n";
        		if ($facility['address1'] !== "") print $facility['address1']."<br>\n";
        		if ($facility['address2'] !== "") print $facility['address2']."<br>\n";
        		if ($facility['phone'] !== "") {
        			print "Phone: ".fix_phone_out($facility['phone']);
        			if ($facility['ext'] !== "") print "Ext. ".$facility['ext'];
        			print "<br>\n";
        		}
        		if ($facility['fax'] !== "") print "Fax: ".fix_phone_out($facility['fax'])."<br>\n";
        	?>	
              <br>
              <a href="#driving">Driving directions</a> | <a href="#airports">Airports</a> | <a href="#hotels">Hotels</a> | <a href="<?php print $facility['places_of_interest_link']; ?>" target="_blank">Places of Interest</a></p>
          <p><b><a name="driving"></a>Driving Directions </b></p>
          <?php 
          		if (is_array($facility['driving_directions'])) {
          			foreach ($facility['driving_directions'] as $key=>$value) {
          				print "<p>{$value['heading']}<br>";
          				print $value['directions']."</p>";
          			}
          		}
          ?>
          <p><b><a name="airports"></a>Airports</b></p>
        	<?php 
        		if ($facility['closest_airport'] !== "") {
        			print "<p>{$facility['closest_airport']}<br>\n";
        			print "Alternate Airports: ";
        			if ($facility['alternate_airports'] !== "") {
        				print $facility['alternate_airports'];
        			} else {
        				print "None";
        			}
        			print "</p>\n";
        		}
        	?>		
          <p><b><a name="hotels"></a>Hotels</b></p>
          <?php 
          		if (is_array($facility['hotels'])) {
          			$rate_counter = 0;
          			foreach ($facility['hotels'] as $key=>$value) {
          				print "<p>{$value['heading']}";
		        		if ($value['address1'] !== "") print "<br>\n".$value['address1'];
		        		if ($value['address2'] !== "") print "<br>\n".$value['address2'];
		        		if ($value['phone'] !== "") {
		        			print "<br>\nPhone: ".fix_phone_out($value['phone']);
		        			if ($value['ext'] !== "") print "Ext. ".$value['ext'];
		        		}
		        		if ($value['fax'] !== "") print "<br>\nFax: ".fix_phone_out($value['fax']);
		        		if ($value['SMS_rate'] !== "") {
		        			$rate_counter++;
		        			print "<br>\nSMS rate: ".$value['SMS_rate']."&#8224;";
		        		}
		        		if ($value['notes'] !== "") print "<br>\n".$value['notes'];
		        		print "</p>";
          			}
          		}
          ?>
          <p><?php if ($rate_counter > 0) print "&#8224; Rates subject to change."; ?></p></td>
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