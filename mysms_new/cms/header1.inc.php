<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");    // Date in the past
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");  // always modified
header("Cache-Control: no-store, no-cache, must-revalidate");  // HTTP/1.1
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");                          // HTTP/1.0
// assumes there is an images directory relative to this file with a black.gif and trans.gif in it
?>

<html>
	<head>
		<title><?php echo $page_title; ?></title>
		
		<?php 
			//echo "<META http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">";
			if ($style_sheet) { echo " <link href=\"$style_sheet\" rel=\"stylesheet\" type=\"text/css\">"; } 
			if ($logout_time && $sess_login && $sess_password) { echo "\n		<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"$logout_time;URL=login.php?auto_logout=1\">\n"; } 
		?>
		<script language="JavaScript" type="text/JavaScript" src="jumpmenu.js"></script>

	</head>
	
<body>
  <A NAME="top"></a>
  <table width="600" border="0" cellspacing="0" cellpadding="5" align="center">
	<tr>
	  <td colspan="3" align="center">
	   <font class="small_spaced">
	   <?php echo $app_title; ?></font></td>
	</tr>
	<tr>
	  <td valign="TOP">
	   <font class="smaller">
	   <?php $today = time()+$s_time_offset; echo date("l, M j",$today); ?></font></td>
	  <td valign="TOP">
	   <font class="smaller">
	   <?php 
	   if ($utype==1) { echo "Admin "; } if ($fname) { echo "User: $fname"; } 
	   if (($last_login != "") && ($last_login != "12/31/69, 4:00pm PST")) { echo "<BR>Last login:  $last_login"; }
	   ?>&nbsp;
	  </font></td>
	  <td align="right" valign="TOP">
	   <font class="smaller">
	  	  <?php include($nav); ?>
	   </font></td>
	</tr>
	<tr>
	  <td colspan="3" valign="TOP" bgcolor="<?php echo $td_bg_color; ?>">
  
