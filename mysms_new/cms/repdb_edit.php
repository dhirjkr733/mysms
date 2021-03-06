<?php


$this_page_title = "Implementation Coordinator Contact Area";

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

	"rep_id" 		=> array ("label"=>"Representative ID",	
								"error"=>"",		
								"value"=>$_REQUEST["rep_id"],			
								"size"=>"30", 
								"maxlength"=>"100", 
								"type"=>"text", 
								"required"=>"", 
								"msg"=>"", 
								"alt_type" => array(
												"type"=>"show_description",	
												"alt_table"=>"representatives", 
												"alt_field"=>"heading"
												)
						),
	
	"state_id" 		=> array ("label"=>"State",				"error"=>"",		"value"=>"$state_id",			"size"=>"30", "maxlength"=>"50", "type"=>"state_pulldown",			"required"=>""),

	"region_id" 		=> array ("label"=>"Region",		"error"=>"",		"value"=>"$region_id",			"size"=>"30", "maxlength"=>"100", "type"=>"region_pulldown",		"required"=>"", "msg"=>""),
	
	"county_id" 		=> array ("label"=>"County",		"error"=>"",		"value"=>"$county_id",			"size"=>"30", "maxlength"=>"100", "type"=>"county_pulldown",		"required"=>"", "msg"=>""),

	"product" 		=> array ("label"=>"Product",		"error"=>"",		"value"=>"$product",			"size"=>"30", "maxlength"=>"100", "type"=>"product_pulldown",		"required"=>"", "msg"=>"")

);


// populate pulldown, page specific wording here

$change_id_label = "id";

$select_existing_default = "Select Area...";

$select_existing_default_value = "rep_id";

$entity_label = "area";

$entity_label_cap = ucfirst($entity_label);



// pulldown query, excluding type=1 (admin)

$select_existing_query = "SELECT repdb.id, CONCAT_WS(' - ', representatives.heading, repdb.state_id, regions.heading, counties.heading, repdb.product) as heading FROM repdb LEFT JOIN representatives ON repdb.rep_id = representatives.id LEFT JOIN regions ON repdb.region_id = regions.id LEFT JOIN counties ON repdb.county_id = counties.id WHERE repdb.rep_id = '".$_REQUEST["rep_id"]."' ORDER BY heading"; // NOTE: showing ALL active records (no status flag)
$select_existing_query2 = "SELECT representatives.heading, repdb.state_id, regions.heading, counties.heading, repdb.product FROM repdb LEFT JOIN representatives ON repdb.rep_id = representatives.id LEFT JOIN regions ON repdb.region_id = regions.id LEFT JOIN counties ON repdb.county_id = counties.id WHERE repdb.rep_id = '".$_REQUEST["rep_id"]."' ORDER BY repdb.state_id, regions.heading, counties.heading"; // NOTE: showing ALL active records (no status flag)

// set default button action

$but_name = "add";

$but_value = "   Add   ";



// do field verification AND inserting/updating

if ($update || $add) {

		

	// check fields

	form_validation($form_fields_ary);

	// protect against same duplicate logins when adding

	if ($add) {

		$protect_sql = "SELECT id FROM repdb WHERE rep_id='$rep_id' AND state_id='$state_id' AND region_id='$region_id' AND county_id='$county_id' AND product='$product'";

		if (($protect_result = mysql_query($protect_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__)) && mysql_num_rows($protect_result)) {

			$num_rows = mysql_num_rows($protect_result);

			if ($num_rows > 0) {

				$error[] = "Duplicate Data - please try again";

			}

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

			$sql2 = "INSERT INTO repdb (id,rep_id,state_id,region_id,county_id,product) VALUES (NULL,'$rep_id','$state_id','$region_id', '$county_id', '$product')";

			$result2 = mysql_query($sql2,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);

			$editor_id = mysql_insert_id ($db_conn);

			

			$success = "$entity_label_cap successfully added.";

		}

	

		// UPDATE existing

		if ($update) {

			$sql = "UPDATE repdb SET rep_id='$rep_id',state_id='$state_id',region_id='$region_id',county_id='$county_id',product='$product'  WHERE id=$id";

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
	if ($id) {

		$sql = "SELECT * FROM repdb WHERE id=$id";
		

		if (($result = mysql_query($sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__)) && mysql_num_rows($result)) {

			$result_ary = mysql_fetch_array($result); // assign results

			while (list($key_name, $sa) = each($form_fields_ary)) { // step through array and set array values using queried data

				$form_fields_ary[$key_name][value] = "$result_ary[$key_name]";

			}

			reset($form_fields_ary);

		}
		if (!$result_ary["rep_id"]) {
			$select_existing_query2 = "SELECT representatives.heading, repdb.state_id, regions.heading, counties.heading, repdb.product FROM repdb LEFT JOIN representatives ON repdb.rep_id = representatives.id LEFT JOIN regions ON repdb.region_id = regions.id LEFT JOIN counties ON repdb.county_id = counties.id WHERE repdb.rep_id = '".$_REQUEST["rep_id"]."' ORDER BY repdb.state_id, regions.heading, counties.heading"; // NOTE: showing ALL active records (no status flag)
		}
		else {
			$select_existing_query2 = "SELECT representatives.heading, repdb.state_id, regions.heading, counties.heading, repdb.product FROM repdb LEFT JOIN representatives ON repdb.rep_id = representatives.id LEFT JOIN regions ON repdb.region_id = regions.id LEFT JOIN counties ON repdb.county_id = counties.id WHERE repdb.rep_id = '".$result_ary["rep_id"]."' ORDER BY repdb.state_id, regions.heading, counties.heading"; // NOTE: showing ALL active records (no status flag)
		}
	}
	else {
		$error[] = "Please select an area";
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

	$delete_query3 = "DELETE FROM repdb WHERE id=$id"; 

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

				              if ((!$confirm_delete) && ((!$change && !$error) || ($change && $error[0] == "Please select an area"))) {

				              	select_existing("$select_existing_query", "$change_id_label", "$select_existing_default", "change", "$select_existing_default_value");

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

						              	form_field("$name","$sa[label]","$sa[error]","$sa[value]","$sa[size]","$sa[maxlength]","$sa[type]","$sa[required]","$sa[msg]", $sa["alt_type"]);

						              }
									  echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
									  echo "<font class=\"smaller\"><A HREF=\"edit_page.php?page_id=73\">Implementation Coordinators</A></font>\n";
									  echo "</td>\n</tr>\n";

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

				            				              <br><br>
				            				              
							<table align="center" width="100%">
				              <tr>

				                <td>

						            <table border="0" width="100%" cellspacing="1" cellpadding="3" bgcolor="<?php echo $td_bg_color; ?>">
						            <tr>
						            	<td align="center" class="smaller">Implementation Coordinator</td>
						            	<td align="center" class="smaller">State</td>
						            	<td align="center" class="smaller">Region</td>
						            	<td align="center" class="smaller">County</td>
						            	<td align="center" class="smaller">Product</td>
						            </tr>
						            <?php
						              	// output existing data table
								      	show_existing("$select_existing_query2", "$td_bg_color2");

						              ?>
						            </table>

				                </td>

				              </tr>		
				             </table>						

<?php



// footer include referenced in config

include($footer);



?>





