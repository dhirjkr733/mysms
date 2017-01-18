

<?php
$me = $_SERVER['PHP_SELF'];  
$Apathweb = explode("/", $me);  
$myFileName = array_pop($Apathweb);  
$pathweb = implode("/", $Apathweb);  
$myURL = "http://".$_SERVER['HTTP_HOST'].$pathweb."/".$myFileName;
$file = basename($PHP_SELF); 
$dir = explode("/",dirname($PHP_SELF)); //$dir[1] will be name of directory, if "" then u r in root
?>


<a name="top"></a>
<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" class="headerbg">
      <table width="755" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="330"><a href="/index.php"><img src="/images/firstamsms.gif" width="317" height="62" hspace="0" border="0" /></a></td>
          <td width="425" align="right">
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="420" height="80">
              <param name="movie" value="/swf/servingtheindustry.swf" />
              <param name="wmode" value="transparent" />
              <param name="quality" value="high" />
              <embed src="/swf/servingtheindustry.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="420" height="80" wmode="transparent"></embed>
            </object>
          </td>
        </tr>
      </table>
    </td>
  </tr>
  <tr>
    <td height="23" bgcolor="#0F1477"><img src="/images/topnav_empty.gif" width="755" height="23"></td>
  </tr>
</table>
<table width="755" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="5">&nbsp;</td>
    <td width="654" height="23" valign="middle" class="text1"><a href="/admin/user_summary.php" class="text1">Admin Home </a>&nbsp;&nbsp;
    <?php 
    if ($_SESSION['logged_in'] === true) {
    	print "<a href=\"/admin/mysms_settings.php\" class=\"text1\">Site Admin </a>&nbsp;&nbsp;";
    	print "<a href=\"/admin/ftp_settings.php\" class=\"text1\">Product Admin </a>&nbsp;&nbsp;";
		print "<a href=\"/admin/user_reports.php\" class=\"text1\">User Report </a>&nbsp;&nbsp;";
    }
    ?></td>
    <td width="92" align="right" valign="middle" class="text1">
    <?php if ($_SESSION['logged_in'] === true) print "<a href=\"".APPLICATION_HOME_PAGE."?logout=logout\" class=\"text1\">Log Out</a>"; ?></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td colspan="3"><img src="/images/spacer.gif" width="1" height="1"></td>
  </tr>
</table>
