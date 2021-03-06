<?php



$this_page_title = "Training Facility Directory";

session_start(); // use on all pages for session mgmt!

include("config1.inc.php"); // stores important required info

//include($alt_inc); // further customization

$page_title .= " - "; $page_title .= $this_page_title;  // additional title for this page

include($auth_header);  // authorization stuff referenced in config file, can override default

include($header); // HTML header include referenced in config file or could override here

include($formtools);  // verification routines



// form values in array

// - array used with form_field, form_validation

// - array ("name" => array ("label"=>"", "error"=>"_error", "default_value"=>"", "size"=>"", "maxlength"=>"50", "type"=>"text", "required"=>"", "msg"=>"", "validate"=>""))

// - form field elements - key of first dimension is "name"

$form_fields_ary = array (

	"heading" 		=> array ("label"=>"Name",				"error"=>"",		"value"=>"$heading",		"size"=>"30", "maxlength"=>"75", "type"=>"text", "required"=>"Required", "msg"=>"",	"validate"=>"check_full,strip_spaces,strip_bad_char"),

	"address1" 		=> array ("label"=>"Address 1",			"error"=>"",		"value"=>"$address1",		"size"=>"30", "maxlength"=>"50", "type"=>"text", "required"=>"", "msg"=>"",	"validate"=>"strip_spaces,strip_bad_char"),

	"address2" 		=> array ("label"=>"Address 2",			"error"=>"",		"value"=>"$address2",		"size"=>"30", "maxlength"=>"50", "type"=>"text", "required"=>"", "msg"=>"",	"validate"=>"strip_spaces,strip_bad_char"),

	"phone" 		=> array ("label"=>"Phone",				"error"=>"",		"value"=>"$phone",			"size"=>"20", "maxlength"=>"10", "type"=>"text", "required"=>"", "msg"=>"Area Code Number",	"validate"=>"strip_spaces,clean_us_phone"),

	"ext" 			=> array ("label"=>"Ext",				"error"=>"",		"value"=>"$ext",			"size"=>"20", "maxlength"=>"4", "type"=>"text", ""),

	"fax" 			=> array ("label"=>"Fax",				"error"=>"",		"value"=>"$fax",			"size"=>"20", "maxlength"=>"20", "type"=>"text", "required"=>"", "msg"=>"Area Code Number",	"validate"=>"strip_spaces,clean_us_phone"),

	"closest_airport" 		=> array ("label"=>"Closest Airport",			"error"=>"",		"value"=>"$closest_airport",		"size"=>"30", "maxlength"=>"75", "type"=>"text", ""),

	"alternate_airports" 		=> array ("label"=>"Alternate Airports",				"error"=>"",		"value"=>"$alternate_airports",			"size"=>"3", "maxlength"=>"100", "type"=>"text_area",""),

	"places_of_interest_link" 	=> array ("label"=>"Places of Interest Link",			"error"=>"",		"value"=>"$places_of_interest_link",		"size"=>"30", "maxlength"=>"100", "type"=>"text", "")
);



// populate pulldown, page specific wording here

$change_id_label = "id";

$select_existing_default = "Select Facility...";

$entity_label = "facility";

$entity_label_cap = ucfirst($entity_label);



// pulldown query, excluding type=1 (admin)

$select_existing_query = "SELECT id,heading FROM facilities_directory ORDER BY heading ASC "; // NOTE: showing ALL active records (no status flag)


// set default button action

$but_name = "add";

$but_value = "   Add   ";



// do field verification AND inserting/updating

if ($update || $add) {



	// check fields

	form_validation($form_fields_ary);

	// protect against same duplicate logins when adding

	if ($add) {

		$protect_sql = "SELECT id FROM facilites_directory WHERE heading='$heading'";

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



		// step through category array and make string

		if ($categories != "") {

		  while (list($key, $val) = each($HTTP_POST_VARS["categories"])) { // step through array and set array values using queried data

			  if ($val != "") { $category_str .= $val.$delimiter; }

		  }

		  $cutoff = strlen($delimiter); // DON'T strip off last delimiter because tags need to be surrounded for search

		  $category_str = substr($category_str, 0, -$cutoff); // strip last space

		}



		// INSERT new

		if ($add) {

			$sql2 = "INSERT INTO facilities_directory (heading,address1,address2,phone,ext,fax,closest_airport,alternate_airports,places_of_interest_link) VALUES ('$heading','$address1','$address2','$phone','$ext','$fax','$closest_airport','$alternate_airports','$places_of_interest_link')";

			$result2 = mysql_query($sql2,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);

			$editor_id = mysql_insert_id ($db_conn);



			$success = "$entity_label_cap successfully added.";

		}



		// UPDATE existing

		if ($update) {

			$sql = "UPDATE facilities_directory SET
				heading='$heading',
				address1='$address1',
				address2='$address2',
				phone='$phone',
				ext='$ext',
				fax='$fax',
				closest_airport='$closest_airport',
				alternate_airports='$alternate_airports',
				places_of_interest_link='$places_of_interest_link'
				WHERE id=$id";

			$result = mysql_query($sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);



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

	$sql = "SELECT * FROM facilities_directory WHERE id=$id";

	if (($result = mysql_query($sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__)) && mysql_num_rows($result)) {

		$result_ary = mysql_fetch_array($result); // assign results

		while (list($key_name, $sa) = each($form_fields_ary)) { // step through array and set array values using queried data

			$form_fields_ary[$key_name][value] = "$result_ary[$key_name]";

		}

		reset($form_fields_ary);

	}



	$but_name = "update";

	$but_value = "   Update   ";

}



// confirm delete

if ($confirm_delete) {

	$warning[] = "You are about to delete the following $entity_label. Are you sure?";

	$but_name = "delete";

	$but_value = "   Yes, DELETE now   ";

}



// do delete

if ($delete) {

	$delete_query3 = "DELETE FROM facilities_directory WHERE id=$id";

	$result3 = mysql_query($delete_query3,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);



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
				              if ($change)	{
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"drivingdb_edit.php?id=".$_REQUEST["id"]."\">Driving Directions</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"hoteldb_edit.php?id=".$_REQUEST["id"]."\">Nearest Hotels</A></font>\n";
													echo "</td>\n</tr>\n";
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





