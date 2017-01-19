<?php
ob_start();
session_start();

//error_reporting(E_ALL);
//ini_set('display_errors', '1');
$this_page_title = "Manage Editors";
 // use on all pages for session mgmt!
include("config1.inc.php"); // stores important required info 
  
                               // echo $sess_login = $login;
			//	echo $sess_password = $password;
                        //	echo $time_last_verified = time(); // seconds since epoch
			//	echo $utype = $type;
			//	echo $uid = $u_id;
			//	echo $fname = $firstname;
                          //  echo    $sess_login =  $_SESSION["sess_login"];
                            //echo  $sess_password =  $_SESSION["sess_password"];
                            //echo  $time_last_verified = $_SESSION["time_last_verified"];
                            //echo  $utype =  $_SESSION["utype"];
                            //echo  $uid = $_SESSION["uid"];
                             //echo $fname = $_SESSION["fname"];
                                
//echo $login;  die;
$page_title .= " - "; $page_title .= $this_page_title;  // additional title for this page
//echo $auth_header; echo $$header; echo $formtools; die;
include($auth_header);  // authorization stuff referenced in config file, can override default
//echo 'test'; echo $auth_header; die;
include($header); // HTML header include referenced in config file or could override here
include($formtools);  // verification routines

// form values in array
// - array used with form_field, form_validation
// - array ("name" => array ("label"=>"", "error"=>"_error", "default_value"=>"", "size"=>"", "maxlength"=>"50", "type"=>"text", "required"=>"", "msg"=>"", "validate"=>""))
// - form field elements - key of first dimension is "name"
$form_fields_ary = array (
	"first_name" 		=> array ("label"=>"First Name",			"error"=>"",		"value"=>"$first_name",		"size"=>"30", "maxlength"=>"30", "type"=>"text",				"required"=>"Required", "msg"=>"",	"validate"=>"check_full,strip_spaces,strip_bad_char"),
	"last_name" 		=> array ("label"=>"Last Name",				"error"=>"",		"value"=>"$last_name",		"size"=>"30", "maxlength"=>"30", "type"=>"text",				"required"=>"Required", "msg"=>"",	"validate"=>"check_full,strip_spaces,strip_bad_char"),
	"login" 			=> array ("label"=>"Login",					"error"=>"",		"value"=>"$login",		"size"=>"20", "maxlength"=>"20", "type"=>"text",				"required"=>"Required", "msg"=>"",	"validate"=>"check_full,strip_spaces,strip_bad_char"),
	"password" 			=> array ("label"=>"Password",				"error"=>"",		"value"=>"$password",	"size"=>"20", "maxlength"=>"20", "type"=>"text",				"required"=>"Required", "msg"=>"",	"validate"=>"check_full,strip_spaces"),
	"notes" 			=> array ("label"=>"Notes",					"error"=>"",		"value"=>"$notes",		"size"=>"3", "maxlength"=>"35", "type"=>"text_area",			"required"=>"", "msg"=>"General information about this editor",	"validate"=>"strip_spaces"),
	"activated" 		=> array ("label"=>"Activated",				"error"=>"",		"value"=>"$activated",	"size"=>"40", "maxlength"=>"50", "type"=>"view_only",			"required"=>"", "msg"=>"",	"validate"=>""),
	"last_access" 		=> array ("label"=>"Last Access",			"error"=>"",		"value"=>"$last_access","size"=>"40", "maxlength"=>"50", "type"=>"view_only",			"required"=>"", "msg"=>"",	"validate"=>""),
	"last_update" 		=> array ("label"=>"Last Update",			"error"=>"",		"value"=>"$last_update","size"=>"40", "maxlength"=>"50", "type"=>"view_only",			"required"=>"", "msg"=>"",	"validate"=>""),
	"title" 			=> array ("label"=>"Editable Pages",		"error"=>"",		"value"=>"",				"size"=>"",		"maxlength"=>"",		"type"=>"title",				"required"=>"", 		"msg"=>"",	"validate"=>""),
	"page_id"			=> array ("label"=>"",						"error"=>"", 		"value"=>"$page_id", 	"size"=>"40",	"maxlength"=>"50",		"type"=>"page_list_select",	"required"=>"", 		"msg"=>"",	"validate"=>""),
);
//editor_id,first_name,last_name,login,password,notes,activated,type,last_access,last_update

// populate pulldown, page specific wording here
$change_id_label = "editor_id";
$select_existing_default = "Select Editor...";
$entity_label = "editor";
$entity_label_cap = ucfirst($entity_label);

// pulldown query, excluding type=1 (admin)
$select_existing_query = "SELECT editor_id,concat(last_name,', ',first_name) AS name FROM editor WHERE type!=1 ORDER BY last_name ASC"; // NOTE: showing ALL active records (no status flag)

// set default button action
$but_name = "add";
$but_value = "   Add   ";

// do field verification AND inserting/updating
if ($update || $add) {
		
	// check fields
	form_validation($form_fields_ary);
	// protect against same duplicate logins when adding
	if ($add) {
		$protect_sql = "SELECT editor_id FROM editor WHERE (first_name='$first_name' AND last_name='$last_name') AND type!=1";
		if (($protect_result = mysql_query($protect_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__)) && mysql_num_rows($protect_result)) {
			list($val1) = mysql_fetch_row($protect_result);
			//if ($val1 != $editor_id) {
				$error[] = "Editor name is already in use - please choose another";
				$form_fields_ary[first_name][value] = ""; // manually clear value
				$form_fields_ary[last_name][value] = ""; // manually clear value
			//}
		}
	}
	
	if (!$error) {
		
		// update vars with array values and clear out array variables so they don't populate form
		while (list($key_name, $sa) = each($form_fields_ary)) {
			$$key_name = $form_fields_ary[$key_name][value];
			unset ($form_fields_ary[$key_name][value]);
		}
		reset($form_fields_ary);
		
		// INSERT new
		if ($add) {
			$sql2 = "INSERT INTO editor (editor_id,first_name,last_name,login,password,notes,activated,type,last_access,last_update) VALUES (NULL,'$first_name','$last_name','$login',ENCODE('$password','$crypt_pass'),'$notes',NOW(),2,NULL,NOW())";
			//editor_id,first_name,last_name,login,password,notes,activated,type,last_access,last_update
			$result2 = mysql_query($sql2,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			$editor_id = mysql_insert_id ($db_conn);

			// insert page assignments
			if ($page_id != "") { // none causes empty set array
				//echo "page_id=$page_id, count page_id =".count($page_id);
				$sql4 = "INSERT INTO access (access_id,editor_id,page_id,last_update) VALUES ";
				// step through 
				while (list($key_v, $val_v) = each($HTTP_POST_VARS["page_id"])) { // just using var name idn't work because using array names to assign values screwed up the array, but this reference may bypass any cleaned values? register globals config directive should be set? 
					if ($val_v != "") { // guards against set array val of nothing/none
						$sql4 .= "(NULL,$editor_id,$val_v,NULL),";
						$real_val=1; // flag to do insert below
					}
				}
				if ($real_val) {
					$sql4 = substr($sql4, 0, -1); // take last , off
					//echo " sql4=$sql4 ";
					$result4 = mysql_query($sql4,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);   
				}
				$page_id = ""; // clear passed values
				$HTTP_POST_VARS["page_id"] = "";
			}
			$success = "$entity_label_cap successfully added.";
		}
	
		// UPDATE existing
		if ($update) {
			$sql = "UPDATE editor SET first_name='$first_name',last_name='$last_name',login='$login',password=ENCODE('$password','$crypt_pass'),notes='$notes',last_update=NOW() WHERE editor_id=$editor_id";
			$result = mysql_query($sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);

			// delete then add page assignments
			$delete_query2 = "DELETE FROM access WHERE editor_id=$editor_id"; 
			$resultd2 = mysql_query($delete_query2,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);

			if ($page_id != "") { // none causes empty set array
				$sql4 = "INSERT INTO access (access_id,editor_id,page_id,last_update) VALUES ";
				// step through 
				while (list($key_v, $val_v) = each($HTTP_POST_VARS["page_id"])) { // just using var name idn't work because using array names to assign values screwed up the array, but this reference may bypass any cleaned values? register globals config directive should be set? 
					if ($val_v != "") { // guards against set array val of nothing/none
						$sql4 .= "(NULL,$editor_id,$val_v,NOW()),";
						$real_val=1; // flag to do insert below
					}
				}
				if ($real_val) {
					$sql4 = substr($sql4, 0, -1); // take last , off
					$result4 = mysql_query($sql4,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);   
				}
				$page_id = ""; // clear passed values
				$HTTP_POST_VARS["page_id"] = "";
			}

			$success = "$entity_label_cap successfully updated.";
		}
	}
	// set button to update if problem otherwise defaults to add
	elseif ($update) {
		$but_name = "update";
		$but_value = "   Update   ";
	}
}

// get and populate existing data
if ($change) {
	
	// query for data, set values for display
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

	$but_name = "update";
	$but_value = "   Update   ";
}

// confirm delete
if ($confirm_delete) {
	$warning[] = "You are about to delete the following editor. Are you sure?";
	$but_name = "delete";
	$but_value = "   Yes, DELETE now   ";
}

// do delete
if ($delete) {
	$delete_query3 = "DELETE FROM editor WHERE editor_id=$editor_id"; 
	$result3 = mysql_query($delete_query3,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);

	// remove page assignments
	$delete_query2 = "DELETE FROM access WHERE editor_id=$editor_id"; 
	$result2 = mysql_query($delete_query2,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
	$success = "$entity_label_cap successfully deleted.";

	// clear out array values
	while (list($key_name, $sa) = each($form_fields_ary)) {
		unset ($form_fields_ary[$key_name][value]);
	}
	reset($form_fields_ary);
}

?>
				            <table align="center" width="100%">
				              <tr> 
				                <td align="center"><font class="bigger_even"><?php echo $this_page_title; ?></font></td>
				              </tr>
				              <tr> 
				                <td align="center"><img src="<?php print $path_sys_images;?>images/black.gif" width="100%" height="1"><BR><BR></td>
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
				              // show success message
				              if ($success) {
				              ?>
				              <tr> 
				                <td align="center"><font class="warning"> 
				                  <?php echo "$success"; ?></font></td>
				              </tr>
				              <?php 
				              }
				              // show change conditionally
				              if (!$change && !$confirm_delete && !$error) {
				              	select_existing("$select_existing_query", "$change_id_label", "$select_existing_default");
				              }
				              // change message
				              if ($change) {
				              ?>
				              <tr>
				                <td> 
				                  Change <?php echo "$entity_label"; ?> below:</td>
				              </tr>
				              <?php 
				              }
				              // show form fields almost always
				              ?>
				              <FORM method="post" action="<?php echo $PHP_SELF?>">
				              <INPUT TYPE="hidden" NAME="<?php echo $change_id_label ?>" VALUE="<?php echo $$change_id_label ?>">
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
				              <tr>
				                <td align="center"> 
				                  <input type="submit" name="<?php echo $but_name ?>" value="<?php echo $but_value ?>">
				                  <?php
				                  if ($change) { echo " or <input type=\"submit\" name=\"confirm_delete\" value=\"Delete\">"; }
				                  ?><BR><BR></td>
				              </tr>
				              </form>
				            </table>
<?php

// footer include referenced in config
include($footer);

?>


