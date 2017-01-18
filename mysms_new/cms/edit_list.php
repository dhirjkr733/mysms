<?php

$this_page_title = "Editable Pages";
session_start(); // use on all pages for session mgmt!
include("config1.inc.php"); // stores important required info
$page_title .= " - "; $page_title .= $this_page_title;  // additional title for this page
include($auth_header);  // authorization stuff referenced in config file, can override default
include($header); // HTML header include referenced in config file or could override here
include($formtools);  // verification routines

// form values in array
// - array used with form_field, form_validation
// - array ("name" => array ("label"=>"", "error"=>"_error", "default_value"=>"", "size"=>"", "maxlength"=>"50", "type"=>"text", "required"=>"", "msg"=>"", "validate"=>""))
// - form field elements - key of first dimension is "name"
$form_fields_ary = array (
	"page_id"	=> array ("label"=>"",	"error"=>"", "value"=>"$page_id", "size"=>"40",	"maxlength"=>"50",	"type"=>"page_list_view",	"required"=>"", 		"msg"=>"",	"validate"=>""),
);
//editor_id,first_name,last_name,login,password,notes,activated,type,last_access,last_update

// get editor_id from set session
$editor_id = $uid;

/*
// get and populate existing data
$sql = "SELECT first_name,last_name,login,DECODE(password,'$crypt_pass') AS password,notes,DATE_FORMAT(DATE_ADD(activated, INTERVAL $s_time_offset SECOND),'%W, %M %e, %Y, %l:%i %p') AS activated,DATE_FORMAT(DATE_ADD(last_access, INTERVAL $s_time_offset SECOND),'%W, %M %e, %Y, %l:%i %p') AS last_access,DATE_FORMAT(DATE_ADD(last_update, INTERVAL $s_time_offset SECOND),'%W, %M %e, %Y, %l:%i %p') AS last_update FROM editor WHERE editor_id=$editor_id";
if (($result = mysql_query($sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__)) && mysql_num_rows($result)) {
	$result_ary = mysql_fetch_array($result); // assign results
	while (list($key_name, $sa) = each($form_fields_ary)) { // step through array and set array values using queried data
		$form_fields_ary[$key_name][value] = "$result_ary[$key_name]";
	}
	reset($form_fields_ary);
}

// get page assignments
$sql3 = "SELECT page_id FROM access WHERE editor_id=$editor_id";
if (($result3 = mysql_query($sql3,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__)) && mysql_num_rows($result)) {
	while (list($pg_id) = mysql_fetch_row($result3)) { 
		// tried passing as $form_fields_ary["page_id"][value] but couldn't get to work in function, so doing separate special case using global value
		$exist_pg_id[$pg_id] = $pg_id;
	}
	reset($form_fields_ary);
}
*/
?>
				            <table align="center" width="100%">
				              <tr> 
				                <td align="center"><?php if ($fname) { echo $fname."'s &nbsp;"; } ?>
				                <font class="bigger_even"><?php echo $this_page_title; ?></font></td>
				              </tr>
				              <tr> 
				                <td align="center"><img src="<?php print $path_sys_images;?>images/black.gif" width="100%" height="1"><BR></td>
				              </tr>
				              <?php
				              // show any errors
				              if ($error) {
				              ?>
				              <tr> 
				                <td>  
				                  Oops! We had the following problems:<font class="warning">
				                  <UL COMPACT>
				                  <?php 
				                  while (list($key, $val) = each($error)) {
				                  	echo "<LI>$val</LI>\n";
				                  } 
				                  ?></UL></font>
				                  Please make the necessary corrections below:</td>
				              </tr>
				              <?php 
				              }
				              // show any warnings
				              if ($warning) {
				              ?>
				              <tr> 
				                <td>  
				                  Careful! Please be aware of the following:<font class="warning">
				                  <UL COMPACT>
				                  <?php 
				                  while (list($key, $val) = each($warning)) {
				                  	echo "<LI>$val</LI>\n";
				                  } 
				                  ?></UL></font>
				                  Review the information below and continue with caution:</td>
				              </tr>
				              <?php 
				              }
				              // show form fields 
				              ?>
				              <tr>
				                <td>
						            <table border="0" width="100%" cellspacing="1" cellpadding="3" bgcolor="<?php echo $td_bg_color; ?>">
						              <?php
						              // output form
						              reset($form_fields_ary);
						              while (list($name, $sa) = each($form_fields_ary)) { 
						              	form_field("$name","$sa[label]","$sa[error]","$sa[value]","$sa[size]","$sa[maxlength]","$sa[type]","$sa[required]","$sa[msg]");
						              }
						              ?>
						            </table>
				                </td>
				              </tr>
				            </table>
<?php

// footer include referenced in config
include($footer);

?>


