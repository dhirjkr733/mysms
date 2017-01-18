<?php
ini_set('max_execution_time','120');
ob_start();
session_start();
header("Cache-control: private");
require_once($_SERVER['DOCUMENT_ROOT'].'/includes/mysms_fns.php');
switch ($_POST['type']) {
	case 'Newsletter':
	default:
		$frmaction = "frm.action = '/public/news/newsletter.php';";
		$subnav = '/public/includes/subnav_news.php';
		break;
}

if (isset($_POST["tmpfile"])) {
	session_write_close();
	$tmpfile = urldecode($_POST['tmpfile']);
	$select_file = strval(urldecode($_POST['select_file']));
	$select_file = str_replace(" ","_",$select_file);
	header("Content-Type:application/force-download");
	header("Content-Length:".filesize($tmpfile));
	header("Content-Disposition:attachment;filename=$select_file;");
	header("Pragma: cache");
	header('Expires: '.date('r', time()+60*60));
	header('Last-Modified: '.date('r', time()));
	ob_end_flush();
	readfile_chunked($tmpfile);
	if(file_exists($tmpfile)) {
		unlink($tmpfile);
	}
	exit;
} elseif (isset($_POST["fetchfile"])) {
	$download_completed = false;
	$type = $_POST['type'];
	$select_file = urldecode($_POST['f']);
	$ftp_dir = urldecode($_POST['d']);
	$product = $_POST['product'];
	$randval = (double)microtime()*1000000;
	$tmpfile = FTP_TEMP_DIR . $select_file . "." . $randval;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>First American SMS</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="/mysms.css" rel="stylesheet" type="text/css">
<script language="javascript">
function backPage() {
	frm = document.downloaded;
	<?php print $frmaction; ?>
	frm.submit();
}
function writeMesg(text) {
	var x=document.getElementById('mesg').rows;
	var y=x[0].cells;
	y[0].innerHTML=text;
}
function writeMesgResults(text) {
	var x=document.getElementById('mesg_results').rows;
	var y=x[0].cells;
	y[0].innerHTML=text;
}
function dhd_fn_progress_bar_update(intCurrentPercent) {
	document.getElementById('progress_bar_complete').style.width = intCurrentPercent+'%';
	document.getElementById('progress_bar_complete').innerHTML = intCurrentPercent+'%';
}
</script>
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
    <td width="188" height="300"><?php require_once($_SERVER['DOCUMENT_ROOT'].$subnav); ?>
        <br>
    </td>
    <td width="1" bgcolor="#CCCCCC"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
        <tr bgcolor="#FFCC00" class="textbody">
          <td bgcolor="#FFCC00"><table width="515" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="textbody"><b>Download File</b></td>
              <td width="250" align="right">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="text1">
	          <p>
	          	<ol>
	          		<li>Please wait while the system retrieves your file.  The amount of time will vary depending on the file size.</li>
	          		<li>You will be prompted to Open, Run or Save this file.</li>
	          		<li>After opening, running or saving this file, use the <b>click here</b> link to continue - DO NOT use your browser's Back button.</li>
	          	</ol>
	          </p>
	          <p>Note: If Internet Explorer displays a message that this site is blocked from downloading files to your computer, go to the Support <a href="/coming_soon.php" target="_blank">Knowledgebase</a> and view the solutions for MySMS Downloads.</p>
	      </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="text1">&nbsp;</td>
        </tr>
      </table>
      <table width="525"  border="0" align="center" cellpadding="5" cellspacing="1" id="fetching">
        <tr bgcolor="#CCCCCC">
          <td colspan="2" class="textbody"><b>Preparing <?php print $select_file ?> for download...</b></td>
        </tr>
		<tr bgcolor="#EDEDED">
          <td colspan="3" align="center" class="text1">
			<form id="downloaded" name="downloaded" method="POST" action="download_file.php">
			<table width="100%" border="0" cellpadding="0" cellspacing="0" id='mesg'>
          	<tr bgcolor="#EDEDED" align="center">
          	  <td id='progress_bar_complete' bgcolor="#FFFFFF" class="text1" align="center">&nbsp;</td>
			</tr>
			</table>
			<input type="hidden" name="tmpfile" value="<?php print urlencode($tmpfile); ?>">
			<input type="hidden" name="select_file" value="<?php print urlencode($select_file); ?>">
			<input type="hidden" name="product" value="<?php print $product; ?>">
			<input type="hidden" name="type" value="<?php print $type; ?>">
			</form>
		  </td>
		</tr>
		<tr bgcolor="#FFFFFF">
          <td colspan="3" align="center" class="text1"><table width=100% border="0" cellpadding="0" cellspacing="0" id='mesg_results'>
          	<tr bgcolor="#EDEDED" align="center">
          	  <td bgcolor="#FFFFFF" width="100%" class="text1">&nbsp;</td>
          	</tr>
          	</table></td>
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
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/footer.php'); ?>
<p>&nbsp;</p>
<?php
	if (($type !== 'Software Upgrade') || (check_registered($product,$ftp_dir,$_SESSION['userid']))) {
		db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
		if ($product != '') {
			$ftp_info = getFTP($product, $type);
		} else {
			/*$ftp_info = array (
				"directory"=>$ADDITIONAL_FTP_TYPES[$type],
				"username"=>DEFAULT_FTP_USER,
				"password"=>DEFAULT_FTP_PASS,
				"server"=>DEFAULT_FTP_SITE
			);*/
			$ftp_info['directory'] = $ADDITIONAL_FTP_TYPES[$type];
		}
		//$ftp_conn = myftp_connect($ftp_info['directory'],$ftp_info['username'],$ftp_info['password'],$ftp_info['server']);
		$ftp_conn = myftp_connect($ftp_info['directory'],DEFAULT_FTP_USER,DEFAULT_FTP_PASS,DEFAULT_FTP_SITE);
		if (!$ftp_conn) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nFTP: Could not connect to file resource. ftpconn=$ftp_conn");
			print "<script language=\"javascript\">writeMesg('Could not connect to file resource.')</script>\n";
		} else {
			if (!@ftp_chdir($ftp_conn,$ftp_dir)) {
				@ftp_close($ftp_conn);
				sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nFTP: Could not access $ftp_dir.");
				print "<script language=\"javascript\">writeMesg('Could not access specified directory.')</script>\n";
			} else {

				// get the size of the remote file 
				$fs = ftp_size($ftp_conn, $select_file); 
				// Initate the download
				$tot = 0;
				$ret = @ftp_nb_get($ftp_conn,$tmpfile,$select_file,FTP_BINARY);
				while ($ret == FTP_MOREDATA) {
					clearstatcache(); // <- this is important
					$dld = filesize($tmpfile); 
					if ( $dld > 0 ){ 
						// calculate percentage 
						$i = ceil(($dld/$fs)*100); 
						if ($i !== $tot) {				
							fn_progress_bar($i);
							$tot = $i;
						}
					}

					// Continue downloading...
					$ret = ftp_nb_continue($ftp_conn);
				}
				if ($ret != FTP_FINISHED) {
					@ftp_close($ftp_conn);
					sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nFTP: There was an error downloading $select_file.");
					print "<script language=\"javascript\">writeMesgResults('There was an error fetching the file...<br><a href=\"#\" onclick=\"javascript:backPage()\">Click here</a> to continue.')</script>\n";
					exit(1);
				} else {
					@ftp_close($ftp_conn);
					$download_completed = true;
					print "<script language=\"javascript\">writeMesgResults('Downloading file...<br><span class=\"dltext\">After download, <a href=\"#\" onclick=\"javascript:backPage()\">click here</a> to continue.<br>Do not use your browser\\'s Back button.</span>')</script>\n";
				}
			}
		}
	} else {
		print "<script language=\"javascript\">writeMesg('You must <a href=\"#\" onclick=\"javascript:backPage()\">register</a> before downloading this file.')</script>\n";
	}
	if ($download_completed !== false) {
?>
<script language="javascript">
if (document.downloaded.product) {
	document.downloaded.submit();
}
</script>
<?php
	}
?>
</body>
</html>
<?php
} else {
	$select_file = $_POST['f'];
	$ftp_dir = $_POST['d'];
	$product = $_POST['product'];
	$type = $_POST['type'];
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>First American SMS</title>
 
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="/mysms.css" rel="stylesheet" type="text/css">
<script language="javascript">
function nextPage() {
	frm = document.downloaded;
	frm.submit();
}
</script>
</head>

<body leftmargin="5" topmargin="0" marginwidth="0" marginheight="0" onload="nextPage();">


<?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/header.php'); ?>
<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="188" height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF">&nbsp;</td>
    <td width="1" bgcolor="#FFFFFF"><img src="/images/pixel.gif" width="1" height="1"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF">
    <td width="188" height="300"><?php require_once($_SERVER['DOCUMENT_ROOT'].$subnav); ?></td>
    <td width="1" bgcolor="#CCCCCC"><img src="/images/pixel.gif" width="1" height="1"></td>
    <td colspan="5" valign="top" bgcolor="#FFFFFF"><table width="525"  border="0" align="center" cellpadding="5" cellspacing="0" id="desc">
        <tr bgcolor="#FFCC00" class="textbody">
          <td bgcolor="#FFCC00"><table width="515" border="0" cellspacing="0" cellpadding="0">
            <tr>
              <td class="textbody"><b>Download File</b></td>
              <td width="250" align="right">&nbsp;</td>
            </tr>
          </table></td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="text1">
	          <p>
	          	<ol>
	          		<li>Please wait while the system retrieves your file.  The amount of time will vary depending on the file size.</li>
	          		<li>You will be prompted to Open, Run or Save this file.</li>
	          		<li>After opening, running or saving this file, use the <b>click here</b> link to continue - DO NOT use your browser's Back button.</li>
	          	</ol>
	          </p>
	          <p>Note: If Internet Explorer displays a message that this site is blocked from downloading files to your computer, go to the Support <a href="http://kb.firstamsms.com/selfserve/SelfServe/SSMain.aspx" target="_blank">Knowledgebase</a> and view the solutions for MySMS Downloads.</p>
	      </td>
        </tr>
        <tr bgcolor="#FFFFFF">
          <td class="text1">&nbsp;</td>
        </tr>
      </table>
      <table width="525"  border="0" align="center" cellpadding="5" cellspacing="1" id="fetching">
        <tr bgcolor="#CCCCCC">
          <td colspan="2" class="textbody"><b>Fetching <?php print $select_file ?>...</b></td>
        </tr>
		<tr bgcolor="#EDEDED">
          <td colspan="3" align="center" class="text1">
			<form id="downloaded" name="downloaded" method="POST" action="download_file.php">
			<table width=100% border="0" cellpadding="0" cellspacing="0" id='mesg'>
          	<tr bgcolor="#EDEDED" align="center">
          	  <td class="text1">&nbsp;</td>
			</tr>
			</table>
			<input type="hidden" name="d" value="<?php print urlencode($ftp_dir); ?>">
			<input type="hidden" name="f" value="<?php print urlencode($select_file); ?>">
			<input type="hidden" name="product" value="<?php print $product; ?>">
			<input type="hidden" name="type" value="<?php print $type; ?>">
			<input type="hidden" name="fetchfile" value="fetchfile">
			</form>
		  </td>
		</tr>
		<tr bgcolor="#FFFFFF">
          <td colspan="3" align="center" class="text1"><table width=100% border="0" cellpadding="0" cellspacing="0" id='mesg_results'>
          	<tr bgcolor="#EDEDED" align="center">
          	  <td bgcolor="#FFFFFF" width="100%" class="text1">&nbsp;</td>
          	</tr>
          	</table></td>
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
<?php require_once($_SERVER['DOCUMENT_ROOT'].'/public/includes/footer.php'); ?>
<p>&nbsp;</p>
</body>
</html>
<?php
}
?>