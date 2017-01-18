<?php

// Various functions useful for dealing with forms


// Form Field CONTENT Generator
// - spits out text, etc. form field

function form_field_content ($chunk, $title, $table_name, $description="", $display_type="", $blanks="") {
	
    global $max_file_size, $error, $path_images, $path_articles, $die_mesg, $PHP_SELF, $db_conn, $db_name, $default_blanks, $change, $update, $add, $confirm_delete, $crypt_pass, $s_time_offset, $c_time_zone, $error_ctd, $td_bg_error, $td_bg_color, $td_bg_color2, $path_sys_images, $abs_path, $remote_path;
    
    // show chunk title & description, spans
	if (!$confirm_delete) {
		$result .= "  						            <tr valign=\"top\">\n  						              <td colspan=\"2\" align=\"center\"";
		//if ($error) { $result .= " bgcolor=\"$td_bg_error\""; }
		//elseif ($td_bg_color2) { $result .= " bgcolor=\"$td_bg_color2\""; }
		$result .= ">\n";
		$result .= "    						               $title";
		if ($description != "") { $result .= "\n    						              <font class=\"smaller_faded\"><BR>$description</font>"; }
		$result .= "</td>\n						              </tr>\n";    
	}

    // if table_name is NOT an array containing specifics, assume you use all table columns and existing column names
    if (!is_array($table_name)) {
    	// some display types need to edit info in a different way as defined in display_type array
    	//print_r($display_type);
    	if (is_array($display_type) && ($display_type['entry_type']=="edit_one") && !$change && !$confirm_delete) { // for more data-intensive applications
    		
			global $die_mesg, $db_conn, $show_search, $change_id_label, $PHP_SELF;
			
    		$query = $display_type['select_existing_query'];
    		$name = $display_type['change_id_label'];
    		$selected = $display_type['select_existing_default'];
    		$entity_label = $display_type['display_label'];
    		$label_flag="change";
    		$label_flag_cap = ucfirst($label_flag);
    		
    		//select_existing($display_type['select_existing_query'], $display_type['change_id_label'], $display_type['select_existing_default']); // values set in optional display_type array
			//select_existing ($query, $name, $selected="Select...", $label_flag="change"){
			
			
			// show pulldown if rows less than limit, showing ALL active/disabled records per passed query
			if ($query && ($sql_result = mysql_query($query,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__)) && (mysql_num_rows($sql_result) >= 1)) {
				$result .=  "  						                <tr>\n  						                  <td colspan=\"2\">\n";
				$result .=  "  						                    <SELECT name=\"$name\">\n";
				$result .=  "  						                      <option SELECTED value=\"\">$selected</option>\n";
				while (list($key,$val) = mysql_fetch_row($sql_result)) {
					// limit size of displayed name/pulldown
					$max_length = 40;
					if (strlen($val) > $max_length) { 
						$val = substr ($val, 0, $max_length);
						$val .= "..."; 
					}
					$result .=  "  						                      <option value=\"$key\">$val</option>\n";
				}
				$result .=  "  						                    </SELECT>\n";
				$result .=  "				                  and <input type=\"submit\" name=\"change\" value=\"$label_flag_cap\"> or<BR>";
				
				$result .=  "</td>\n				              </tr>\n";
			}
			$result .=  "  						                <tr>\n  						                  <td colspan=\"2\">\n				                  Add new $entity_label below:</td>\n				              </tr>\n";
			$blanks = 1; // reset so only one empty field shows up below regardless of how set
			$no_display = 1; // prevents data from populating below
    	}
    	// default edit display
		// get fields from table
		if ($change || $confirm_delete) { // get only passed record
		   $tb_sql = "SELECT * FROM $table_name WHERE ".$display_type['change_id_label']."=".$_REQUEST[$display_type['change_id_label']]; 
		   $blanks = 0;
		   $result .= "    						              <input type=\"hidden\" name=\"".$display_type['change_id_label']."\" value=\"".$_REQUEST[$display_type['change_id_label']]."\">\n"; // used to pass value for delete
		} 
		else { $tb_sql = "SELECT * FROM $table_name ORDER BY id"; } // gets all records
		//echo "tb_sql=$tb_sql";
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>$tb_sql<BR>File: $PHP_SELF, Line: ".__LINE__);
		// make total number of rows
		if (!$no_display) { $exist_rows = mysql_num_rows($tb_result); }
		//if ($blanks=="" && $blanks<0) { $blanks=$default_blanks; }
		if ($blanks=="" && $blanks!=0) { $blanks=$default_blanks; }
		//if ($blanks < 1 && (!$change && !$confirm_delete)) { $blanks=1; }
		if ($blanks==0 && $exist_rows==0) { $blanks=1; }
		$total_rows = $blanks + $exist_rows;
		
		for ($ii = 0; $ii < $total_rows; $ii++) { 
			 $i = 0;
			 //$num_fields_cnt = mysql_num_fields($tb_result) -1;
			 $result_ary = mysql_fetch_array($tb_result);
			 while ($i < mysql_num_fields($tb_result)) {
				$field_info = mysql_fetch_field($tb_result,$i); // populate existing data
				$field_len = mysql_field_len($tb_result,$i);
				$field_name_display = str_replace ("_"," ",$field_info->name);
				$field_name_display = ucwords($field_name_display);
				if (!$no_display) { $value = $result_ary[$field_info->name]; }
				
				// skip id/order row completely if database type entry
				if (($display_type['entry_type']!="edit_one") || ($field_info->name!="id")) {
				// first TD
				$result .= "  						            <tr valign=\"top\">\n  						              <td";
				if ($td_bg_color2) { $result .= " bgcolor=\"$td_bg_color2\""; }
				$result .= ">\n";
				if ($field_info->name=="id") { $result .= "    						              ID/Order:"; }
				else { $result .= "    						              ".$field_name_display.":"; }
				//if ($msg || $required) { $result .= "\n    						              <font class=\"smaller_faded\"><BR>($required$msg)</font>"; }
				$result .= "</td>\n";
		
				// second TD
				$result .= "  						              <td";
				if ($td_bg_color2) { $result .= " bgcolor=\"$td_bg_color2\""; }
				$result .= ">\n";
				$cur_order = $ii+1;
				if ($field_info->name=="id" && $change) { $result .= "    						              <input type=\"hidden\" name=\"".$chunk."[".$cur_order."][".$field_info->name."]\" value=\"".$value."\">".$value; }
				elseif ($field_info->name=="id") { $result .= "    						              <input type=\"hidden\" name=\"".$chunk."[".$cur_order."][".$field_info->name."]\" value=\"".$cur_order."\">".$cur_order; }
				
				// image upload, note different posted var names due to uploading bug not handling multi-dimensional arrays
				elseif ($field_info->name=="image") { 
				   // check that correct directory exist
				   if (file_exists($abs_path . $path_images)) {
					   $result .= "    						              <input type=\"hidden\" name=\"".$chunk."[".$cur_order."][".$field_info->name."]\" value=\"1\">\n"; // used to indicate there is an image associated with this chunk
					   $result .= "    						              <SELECT name=\"".$chunk."_".$cur_order."_image1\">\n";	
					   $result .= "    						               <OPTION value=\"\" SELECTED>Select an existing image file:</option>\n";
   
					   // get images directory listing and show in pulldown
					   $got_image = "";
					   $open_dir = opendir($abs_path . $path_images);
					   while ($file = readdir($open_dir)) {
						   if ($file != "." && $file != "..") {
							   $result .= "    						               <OPTION value=\"$file\">$file</option>\n";
							   $got_image = 1;							
						   }
					   }
					   if ($got_image=="") { $result .= "    						               <OPTION value=\"\">(none available)</option>\n"; }								
					   $result .= "    						              </SELECT>\n";	
					   
					   // upload image stuff		
					   $result .= "    						              <font class=\"smaller\">\n";			
					   $result .= "    						              <BR>or enter the path manually:<BR>\n";			
					   $result .= "    						              <input type=\"text\" size=\"30\" maxlength=\"250\" name=\"".$chunk."_".$cur_order."_image2\" value=\"$value\">\n";			
					   $result .= "    						              <BR>or select a file to upload:<BR>\n";			
					   if (($max_file_size)<(1024*1024)) { $f_size = number_format(($max_file_size/1024), 0, '.', '')." kb"; }
					   else { $f_size = number_format(($max_file_size/(1024*1024)), 1, '.', '')." mb"; }
					   $result .= "    						              <font class=\"smaller_faded\">($f_size max file size)</font>\n";
					   if (!stristr($result,"<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$max_file_size\"><BR>")) {
					   		$result .= "    						              <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$max_file_size\"><BR>\n";			
					   }
					   $result .= "    						              <input type=\"file\" enctype=\"multipart/form-data\" name=\"".$chunk."_".$cur_order."_image3\"><BR>\n";			
					   $result .= "    						              </font>";			
				   }
				   else {
					   $result .= "    						              <font class=\"smaller_faded\">(WARNING: The needed image directory(s) are missing. Make sure the following directory exist: \"".$path_images."\". Seek help below.)</font>";
				   }
				}
				elseif ($field_info->name=="name_image") { 
				   // check that correct directory exist
				   if (file_exists($abs_path . $path_images)) {
					   $result .= "    						              <input type=\"hidden\" name=\"".$chunk."[".$cur_order."][".$field_info->name."]\" value=\"1\">\n"; // used to indicate there is an image associated with this chunk
					   $result .= "    						              <SELECT name=\"".$chunk."_".$cur_order."_1image1\">\n";	
					   $result .= "    						               <OPTION value=\"\" SELECTED>Select an existing image file:</option>\n";
   
					   // get images directory listing and show in pulldown
					   $got_image = "";
					   $open_dir = opendir($abs_path . $path_images);
					   while ($file = readdir($open_dir)) {
						   if ($file != "." && $file != "..") {
							   $result .= "    						               <OPTION value=\"$file\">$file</option>\n";
							   $got_image = 1;							
						   }
					   }
					   if ($got_image=="") { $result .= "    						               <OPTION value=\"\">(none available)</option>\n"; }								
					   $result .= "    						              </SELECT>\n";	
					   
					   // upload image stuff		
					   $result .= "    						              <font class=\"smaller\">\n";			
					   $result .= "    						              <BR>or enter the path manually:<BR>\n";			
					   $result .= "    						              <input type=\"text\" size=\"30\" maxlength=\"250\" name=\"".$chunk."_".$cur_order."_1image2\" value=\"$value\">\n";			
					   $result .= "    						              <BR>or select a file to upload:<BR>\n";			
					   if (($max_file_size)<(1024*1024)) { $f_size = number_format(($max_file_size/1024), 0, '.', '')." kb"; }
					   else { $f_size = number_format(($max_file_size/(1024*1024)), 1, '.', '')." mb"; }
					   $result .= "    						              <font class=\"smaller_faded\">($f_size max file size)</font>\n";
					   if (!stristr($result,"<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$max_file_size\"><BR>")) {
					   		$result .= "    						              <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$max_file_size\"><BR>\n";			
					   }
					   $result .= "    						              <input type=\"file\" enctype=\"multipart/form-data\" name=\"".$chunk."_".$cur_order."_1image3\"><BR>\n";			
					   $result .= "    						              </font>";			
				   }
				   else {
					   $result .= "    						              <font class=\"smaller_faded\">(WARNING: The needed image directory(s) are missing. Make sure the following directory exist: \"".$path_images."\". Seek help below.)</font>";
				   }
				}
				elseif ($field_info->name=="thumbnail_off") { 
				   // check that correct directory exist
				   if (file_exists($abs_path . $path_images)) {
					   $result .= "    						              <input type=\"hidden\" name=\"".$chunk."[".$cur_order."][".$field_info->name."]\" value=\"1\">\n"; // used to indicate there is an image associated with this chunk
					   $result .= "    						              <SELECT name=\"".$chunk."_".$cur_order."_2image1\">\n";	
					   $result .= "    						               <OPTION value=\"\" SELECTED>Select an existing image file:</option>\n";
   
					   // get images directory listing and show in pulldown
					   $got_image = "";
					   $open_dir = opendir($abs_path . $path_images);
					   while ($file = readdir($open_dir)) {
						   if ($file != "." && $file != "..") {
							   $result .= "    						               <OPTION value=\"$file\">$file</option>\n";
							   $got_image = 1;							
						   }
					   }
					   if ($got_image=="") { $result .= "    						               <OPTION value=\"\">(none available)</option>\n"; }								
					   $result .= "    						              </SELECT>\n";	
					   
					   // upload image stuff		
					   $result .= "    						              <font class=\"smaller\">\n";			
					   $result .= "    						              <BR>or enter the path manually:<BR>\n";			
					   $result .= "    						              <input type=\"text\" size=\"30\" maxlength=\"250\" name=\"".$chunk."_".$cur_order."_2image2\" value=\"$value\">\n";			
					   $result .= "    						              <BR>or select a file to upload:<BR>\n";			
					   if (($max_file_size)<(1024*1024)) { $f_size = number_format(($max_file_size/1024), 0, '.', '')." kb"; }
					   else { $f_size = number_format(($max_file_size/(1024*1024)), 1, '.', '')." mb"; }
					   $result .= "    						              <font class=\"smaller_faded\">($f_size max file size)</font>\n";
					   if (!stristr($result,"<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$max_file_size\"><BR>")) {
					   		$result .= "    						              <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$max_file_size\"><BR>\n";			
					   }
					   $result .= "    						              <input type=\"file\" enctype=\"multipart/form-data\" name=\"".$chunk."_".$cur_order."_2image3\"><BR>\n";			
					   $result .= "    						              </font>";			
				   }
				   else {
					   $result .= "    						              <font class=\"smaller_faded\">(WARNING: The needed image directory(s) are missing. Make sure the following directory exist: \"".$path_images."\". Seek help below.)</font>";
				   }
				}
				elseif ($field_info->name=="thumbnail_on") { 
				   // check that correct directory exist
				   if (file_exists($abs_path . $path_images)) {
					   $result .= "    						              <input type=\"hidden\" name=\"".$chunk."[".$cur_order."][".$field_info->name."]\" value=\"1\">\n"; // used to indicate there is an image associated with this chunk
					   $result .= "    						              <SELECT name=\"".$chunk."_".$cur_order."_3image1\">\n";	
					   $result .= "    						               <OPTION value=\"\" SELECTED>Select an existing image file:</option>\n";
   
					   // get images directory listing and show in pulldown
					   $got_image = "";
					   $open_dir = opendir($abs_path . $path_images);
					   while ($file = readdir($open_dir)) {
						   if ($file != "." && $file != "..") {
							   $result .= "    						               <OPTION value=\"$file\">$file</option>\n";
							   $got_image = 1;							
						   }
					   }
					   if ($got_image=="") { $result .= "    						               <OPTION value=\"\">(none available)</option>\n"; }								
					   $result .= "    						              </SELECT>\n";	
					   
					   // upload image stuff		
					   $result .= "    						              <font class=\"smaller\">\n";			
					   $result .= "    						              <BR>or enter the path manually:<BR>\n";			
					   $result .= "    						              <input type=\"text\" size=\"30\" maxlength=\"250\" name=\"".$chunk."_".$cur_order."_3image2\" value=\"$value\">\n";			
					   $result .= "    						              <BR>or select a file to upload:<BR>\n";			
					   if (($max_file_size)<(1024*1024)) { $f_size = number_format(($max_file_size/1024), 0, '.', '')." kb"; }
					   else { $f_size = number_format(($max_file_size/(1024*1024)), 1, '.', '')." mb"; }
					   $result .= "    						              <font class=\"smaller_faded\">($f_size max file size)</font>\n";
					   if (!stristr($result,"<input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$max_file_size\"><BR>")) {
					   		$result .= "    						              <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$max_file_size\"><BR>\n";			
					   }
					   $result .= "    						              <input type=\"file\" enctype=\"multipart/form-data\" name=\"".$chunk."_".$cur_order."_3image3\"><BR>\n";			
					   $result .= "    						              </font>";			
				   }
				   else {
					   $result .= "    						              <font class=\"smaller_faded\">(WARNING: The needed image directory(s) are missing. Make sure the following directory exist: \"".$path_images."\". Seek help below.)</font>";
				   }
				}
				elseif ($field_info->name=="pdf_file") { 
				   // check that correct directory exist
				   if (file_exists($path_articles)) {
					   $result .= "    						              <input type=\"hidden\" name=\"".$chunk."[".$cur_order."][".$field_info->name."]\" value=\"1\">\n"; // used to indicate there is an article associated with this chunk
					   $result .= "    						              <SELECT name=\"".$chunk."_".$cur_order."_article1\">\n";	
					   $result .= "    						               <OPTION value=\"\" SELECTED>Select an existing article file:</option>\n";
   
					   // get articles directory listing and show in pulldown
					   $got_article = "";
					   $open_dir = opendir($path_articles);
					   while ($file = readdir($open_dir)) {
						   if ($file != "." && $file != "..") {
							   $result .= "    						               <OPTION value=\"$file\">$file</option>\n";
							   $got_article = 1;							
						   }
					   }
					   if ($got_article=="") { $result .= "    						               <OPTION value=\"\">(none available)</option>\n"; }								
					   $result .= "    						              </SELECT>\n";	
					   
					   // upload article stuff		
					   $result .= "    						              <font class=\"smaller\">\n";			
					   $result .= "    						              <BR>or enter the path manually:<BR>\n";			
					   $result .= "    						              <input type=\"text\" size=\"30\" maxlength=\"250\" name=\"".$chunk."_".$cur_order."_article2\" value=\"$value\">\n";			
					   $result .= "    						              <BR>or select a file to upload:<BR>\n";			
					   if (($max_file_size)<(1024*1024)) { $f_size = number_format(($max_file_size/1024), 0, '.', '')." kb"; }
					   else { $f_size = number_format(($max_file_size/(1024*1024)), 1, '.', '')." mb"; }
					   $result .= "    						              <font class=\"smaller_faded\">($f_size max file size)</font>\n";
					   $result .= "    						              <input type=\"hidden\" name=\"MAX_FILE_SIZE\" value=\"$max_file_size\"><BR>\n";			
					   $result .= "    						              <input type=\"file\" enctype=\"multipart/form-data\" name=\"".$chunk."_".$cur_order."_article3\"><BR>\n";			
					   $result .= "    						              </font>";			
				   }
				   else {
					   $result .= "    						              <font class=\"smaller_faded\">(WARNING: The needed article directory(s) are missing. Make sure the following directory exist: \"".$path_articles."\". Seek help below.)</font>";
				   }
				}
				elseif ($field_info->name=="st") {
					global $state_list;
					$result .= "    						              <SELECT name=\"".$chunk."[".$cur_order."][".$field_info->name."]\">\n";
					if (!$value && !$default_state) { $result .= "<OPTION SELECTED value=\"\">Select State...</OPTION>"; }
					reset ($state_list);
		    		while (list($abbr,$long) = each($state_list)) {
						if ($abbr == $value) {
							$result .= "<OPTION SELECTED value=\"$abbr\">$long</OPTION>\n";
						}
						else {
							$result .= "<OPTION value=\"$abbr\">$long</OPTION>\n";
						}
						$got_result = 1;
					}
					if ($got_result=="") { $result .= "    						               <OPTION value=\"\">(none available)</option>\n"; }								
					else { $result .= "    						               <OPTION value=\"\">(none)</option>\n"; }								
					$result .= "    						              </SELECT>\n";	
				}				
				elseif ($field_info->name=="country") {
					global $country_list;					
					//$country_list = array("U.S.A");
					$result .= "    						              <SELECT name=\"".$chunk."[".$cur_order."][".$field_info->name."]\">\n";
					//if (!$value) { $result .= "<option SELECTED value=\"\">Select Country...</option>"; }
					if (!$value) { $result .= "<OPTION SELECTED value=\"U.S.A.\">U.S.A.</OPTION>"; }
					reset ($country_list);
					while (list($key,$long) = each($country_list)) {
						if ($long == $value) {
							$result .= "<OPTION SELECTED value=\"$long\">$long</OPTION>\n";
						}
						else {
							$result .= "<OPTION value=\"$long\">$long</OPTION>\n";
						}
						$got_result = 1;
					}
					if ($got_result=="") { $result .= "    						               <OPTION value=\"\">(none available)</option>\n"; }								
					else { $result .= "    						               <OPTION value=\"\">(none)</option>\n"; }								
					$result .= "    						              </SELECT>\n";	
				}
				
				// filter selector
				elseif ($field_info->name=="filter") { 
				   global $filters;
				   if ($filters !="") {
					   $result .= "    						              <SELECT name=\"".$chunk."[".$cur_order."][".$field_info->name."]\">\n";	
					   if ($value=="") {
					   	$result .= "    						               <OPTION value=\"\" SELECTED>Select limiting filter:</option>\n";
					   }
					   reset ($filters);
					   while (list($key,$val) = each($filters)) {
						if ($value==$val) {
							$result .= "    						               <OPTION value=\"$val\" SELECTED>$val</option>\n";
						}
						else { $result .= "    						               <OPTION value=\"$val\">$val</option>\n"; }
						$got_result = 1;
					   }
					   if ($got_result=="") { $result .= "    						               <OPTION value=\"\">(none available)</option>\n"; }								
					   else { $result .= "    						               <OPTION value=\"\">(none)</option>\n"; }								
					   $result .= "    						              </SELECT>\n";	
					   
				   }
				   else {
					   $result .= "    						              <font class=\"smaller_faded\">(WARNING: The needed filters cannot be found. Seek help below.)</font>";
				   }
				}
				// shorter columns get text field, longer get area
				elseif ($field_len <= 50) { $result .= "    						              <input type=\"text\" name=\"".$chunk."[".$cur_order."][".$field_info->name."]\" maxlength=\"$field_len\" size=\"$field_len\" value=\"$value\">"; }
				else { 
					$result .= "    						              <TEXTAREA ID=\"".$chunk."[".$cur_order."][".$field_info->name."]\" NAME=\"".$chunk."[".$cur_order."][".$field_info->name."]\" ROWS=\"3\" COLS=\"35\" maxlength=\"$field_len\">$value</TEXTAREA>"; 
						$result .= "<br><img src=\"$path_sys_images"."tb_hyperlink.gif\" onclick=\"AddLink('".$chunk."[".$cur_order."][".$field_info->name."]')\" unselectable=\"on\" alt=\"Click to make hyperlink\">&nbsp;
								<img src=\"$path_sys_images"."tb_bold.gif\" onclick=\"AddBold('".$chunk."[".$cur_order."][".$field_info->name."]')\" unselectable=\"on\" alt=\"Click to make bold\">\n
								<img src=\"$path_sys_images"."tb_italic.gif\" onclick=\"AddItalic('".$chunk."[".$cur_order."][".$field_info->name."]')\" unselectable=\"on\" alt=\"Click to make italic\">\n
								<img src=\"$path_sys_images"."tb_undo.gif\" onclick=\"UndoHTML('".$chunk."[".$cur_order."][".$field_info->name."]')\" unselectable=\"on\" alt=\"Click to remove html tags\">\n";
					}
				$result .= "</td>\n						              </tr>\n";
				}
				$i++;
			 }
		}
    }
    // pull details out of table array
    //else {
    
    //}
    echo $result;
}


// Form Field Generator
// - spits out text, etc. form field
// - displays any passed pre-populated value
// - accepts hidden field name and visable label
// - uses pre-defined table cell colors
// - highlights if error

function form_field ($name, $label, $error, $value="", $size=30, $maxlength=40, $type="text", $required="", $msg="", $alt_type=""){
	
    global $die_mesg, $PHP_SELF, $db_conn, $entity_label, $change, $update, $add, $confirm_delete, $crypt_pass, $alt_edit, $s_time_offset, $c_time_zone, $error_ctd, $td_bg_error, $td_bg_color, $td_bg_color2, $path_sys_images, $hide_page;

  if (!is_array($alt_type)) {
    // checkbox, title type first because of spanning colored TD
    if (($type=="title") || ($type=="title_anchor")) {
	    // first TD
	    $result .= "  						            <tr valign=\"top\">\n  						              <td colspan=\"2\" align=\"center\"";
	    if ($error) { $result .= " bgcolor=\"$td_bg_error\""; }
	    elseif ($td_bg_color2) { $result .= " bgcolor=\"$td_bg_color2\""; }
	    $result .= ">";
	    if ($type=="title_anchor") { $result .= "<A NAME=\"$size\">&nbsp;</A>"; } // uses size value for anchor name
	    $result .= "\n";
	    $result .= "    						               <font class=\"slightly_bigger\">$label</font>";
	    if ($msg || $required) { $result .= "\n    						              <font class=\"smaller_faded\"><BR>($required$msg)</font>"; }
	    $result .= "</td>\n						              </tr>\n";    
    }
    
    elseif ($type=="text_plain") {
	    // first TD
	    $result .= "  						            <tr valign=\"top\">\n  						              <td colspan=\"2\" align=\"left\"";
	    if ($error) { $result .= " bgcolor=\"$td_bg_error\""; }
	    elseif ($td_bg_color2) { $result .= " bgcolor=\"$td_bg_color2\""; }
	    $result .= ">";
	    $result .= "\n";
	    $result .= "    						               $label";
	    if ($msg || $required) { $result .= "\n    						              <font class=\"smaller_faded\"><BR>($required$msg)</font>"; }
	    $result .= "</td>\n						              </tr>\n";    
    }
    
	elseif ($type=="page_list_select") {
		$pd_sql = "SELECT page_id,title,path FROM page ORDER BY title ASC"; 
		$pd_result = mysql_query($pd_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
	    
	    // first TD, spans
	    $result .= "  						            <tr valign=\"top\">\n  						              <td colspan=\"2\" align=\"center\"";
	    if ($error) { $result .= " bgcolor=\"$td_bg_error\""; }
	    elseif ($td_bg_color2) { $result .= " bgcolor=\"$td_bg_color2\""; }
	    $result .= ">";
	    $result .= "\n";
	    if ($label != "") {
		  $result .= "    						               <font class=\"slightly_bigger\">$label</font>";
		  if ($msg || $required) { $result .= "\n    						              <font class=\"smaller_faded\"><BR>($required$msg)</font>"; }
		  $result .= "<BR>\n";
	    }
	    $result .= "    						                 <table border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"3\">\n";
	    
		// nothing available
		if (!mysql_num_rows($pd_result)) { 
		 $result .= "     						                   <tr>\n";
		 $result .= "     						                     <td align=\"center\">\n";
		 $result .= "     						                       (Nothing available - seek help below)\n";
		 $result .= "     						                     </td>\n";
		 $result .= "     						                   </tr>\n";
		}
		
		// step thru rows
		else {
		  global $HTTP_POST_VARS, $exist_pg_id; // couldn't access array values passed to function
		  
		  // header row
		  $result .= "     						                   <tr>\n";
		  $result .= "     						                     <td><font class=\"smaller_faded\">Allow Access</font></td>\n";
		  $result .= "     						                     <td colspan=\"2\" align=\"center\"><font class=\"smaller_faded\">Page Title</font></td>\n";
		  $result .= "     						                   </tr>\n";
		  while ($result_ary = mysql_fetch_array($pd_result)) {
		  	if (!strstr($result_ary["title"],$hide_page)) { // disable view for alternative editing
			  $result .= "     						                   <tr>\n";
			  $result .= "     						                     <td width=\"5%\" align=\"center\" valign=\"top\">";
			  $result .= "<input type=\"checkbox\" name=\"".$name."[]\" value=\"".$result_ary[$name]."\"";
			  // check for passed or stored page_ids
			  if ($add || $confirm_delete) {
				$page_ary = $HTTP_POST_VARS[$name];
				if ($page_ary !="") { //empty array causes errors
					while (list($key_v, $val_v) = each($page_ary)) {
						if ($result_ary[$name] == $val_v) { $result .= " CHECKED"; }
					}
					reset ($page_ary);
				}
			  }
			  elseif ($change) { // shows previously entered DB values
				  $id_val = $result_ary[$name];
				  if ($result_ary[$name] == $exist_pg_id[$id_val]) { $result .= " CHECKED"; } 
			  }
			  $result .= ">";
			  $result .= "</td>\n";
			  $result .= "     						                     <td bgcolor=\"$td_bg_color\" valign=\"top\">";
			  $result .= "".$result_ary["title"];
			  $result .= "</td>\n";
			  $result .= "     						                     <td width=\"5%\" align=\"center\" valign=\"top\" nowrap>";
			  if (strstr($result_ary["title"],$alt_edit)) { // disable view for alternative editing
			  	$result .= "-";
			  }
			  elseif (file_exists($result_ary["path"])) { 
			  	$result .= "<font class=\"smaller\"><A HREF=\"".$result_ary["path"]."\" target=\"Page_View\">view</A></font>"; 
			  }
			  else { $result .= "<font class=\"warning_smaller\">File cannot be found - <BR>seek help below.</font>"; }
			  $result .= "</td>\n";
			  $result .= "     						                   </tr>\n";
		  	}
		  }
		}
	    $result .= "    						                 </table>\n";
	    $result .= "  						              </td>\n						              </tr>\n";    
	}
	
	elseif ($type=="page_list_view") {
		global $editor_id;
		$pd_sql = "SELECT page.page_id,page.title,page.path,UNIX_TIMESTAMP(page.last_update) as last_update FROM page,access WHERE access.editor_id=$editor_id AND access.page_id=page.page_id ORDER BY title ASC"; 
		$pd_result = mysql_query($pd_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
	    
	    // first TD, spans, no title or message, etc
	    $result .= "<tr valign=\"top\">\n  						              <td colspan=\"2\" align=\"center\">\n";
	    $result .= "    						                 <table border=\"0\" width=\"100%\" cellspacing=\"1\" cellpadding=\"3\" bgcolor=\"$td_bg_color\">\n";
	    
		// nothing available
		if (!mysql_num_rows($pd_result)) { 
		 $result .= "     						                   <tr>\n";
		 $result .= "     						                     <td align=\"center\">\n";
		 $result .= "     						                       (Nothing available - seek help below)\n";
		 $result .= "     						                     </td>\n";
		 $result .= "     						                   </tr>\n";
		}
		
		// step thru rows
		else {
		  
		  // header row
		  $result .= "     						                   <tr>\n";
		  $result .= "     						                     <td colspan=\"2\" align=\"center\"><font class=\"smaller_faded\">Page Title</font></td>\n";
		  $result .= "     						                     <td align=\"center\"><font class=\"smaller_faded\">Last Modified</font></td>\n";
		  $result .= "     						                     <td><font class=\"smaller_faded\">&nbsp;</font></td>\n";
		  $result .= "     						                   </tr>\n";
		  while ($result_ary = mysql_fetch_array($pd_result)) {
		  	
		  	if (!strstr($hide_page,$result_ary["title"])) { // disable view for alternative editing
		  	
			  $result .= "     						                   <tr>\n";
			  $result .= "     						                     <td bgcolor=\"$td_bg_color2\" valign=\"top\">";
			  $result .= "".$result_ary["title"];
			  $result .= "</td>\n";
			  $result .= "     						                     <td width=\"5%\" align=\"center\" valign=\"top\" bgcolor=\"$td_bg_color2\">";
			  if (strstr($result_ary["title"],$alt_edit)) { // disable view for alternative editing
			  	$result .= "-";
			  }
			  elseif (file_exists($result_ary["path"])) {
			  	if (($result_ary["title"] == "Staff Bios") || ($result_ary["title"] == "Our Team Bios")) {
			  		$result .= "<font class=\"smaller\"><A HREF=\"http://www.inhouseit.com/ourteam/ourteambios.html\" target=\"Page_View\">view</A></font>";
			  	} elseif ((substr($result_ary["title"],0,9) == "Member - ") || (strstr($result_ary["title"],"Confirm") !== false)) { // disable view for alternative editing
			  		$result .= "-";
			  	} else {
			  		$result .= "<font class=\"smaller\"><A HREF=\"".$result_ary["path"]."\" target=\"Page_View\">view</A></font>";
			  	}
			  }
			  else { 
			  	$ret=false;
			  	//$ret_array = remote_file_exists(str_replace(".php",".html",$result_ary["path"]));
			  	$ret_array = remote_file_exists($result_ary["path"]);
			  	$ret=$ret_array["found"];
			  	if ($ret===true) { 
			  		$result .= "<font class=\"smaller\"><A HREF=\"".str_replace(".php",".html",$result_ary["path"])."\" target=\"Page_View\">view</A></font>";
			  	}
   				else { 
   					$result .= "-"; 
   				}
			  }
			  $result .= "</td>\n";
			  $result .= "     						                     <td width=\"20%\" align=\"center\" valign=\"top\" bgcolor=\"$td_bg_color2\" nowrap><font class=\"smaller\">";
			  if (strstr($result_ary["title"],$alt_edit)) { // disable mod date for alternative editing
			  	$result .= "-";
			  }
			  elseif (file_exists($result_ary["path"])) { 
			  	//$result .= date("D M j, Y <\B\R>g:ia", (filemtime($result_ary["path"]) + $s_time_offset))." ".$c_time_zone; 
			  	$result .= date("D M j, Y <\B\R>g:ia", ($result_ary["last_update"] + $s_time_offset))." ".$c_time_zone;
			  }
			  else { 
			  	if ($ret===true) { 
					//preg_match("/Last-Modified:\s*(.+)\r/i", $ret_array["results"], $matches);
           			//if(!isset($matches[1])) {
           				//$result .= " - ";
           			//} else {
           				//$result .= date("D M j, Y <\B\R>g:ia", (strtotime($matches[1]) + $s_time_offset))." ".$c_time_zone;
			  		//$result .= date("D M j, Y <\B\R>g:ia", (filemtime($result_ary["path"]) + $s_time_offset))." ".$c_time_zone; 
           			//}
			  		$result .= date("D M j, Y <\B\R>g:ia", ($result_ary["last_update"] + $s_time_offset))." ".$c_time_zone;
			  	}
   				else { 
			  		$result .= "<font class=\"warning_smaller\">File cannot be found - <BR>seek help below.</font>"; 
   				}
			  }
			  $result .= "</font></td>\n";
			  $result .= "     						                     <td width=\"5%\" align=\"center\" valign=\"top\" bgcolor=\"$td_bg_color2\">";
			  if (strstr($result_ary["title"],$alt_edit)) { // change link for alternative editing
			  	$result .= "<font class=\"smaller\"><A HREF=\"".$result_ary["path"]."\">edit</A></font>";
			  }
			  elseif (file_exists($result_ary["path"])) {
			  	$result .= "<font class=\"smaller\"><A HREF=\"edit_page.php?page_id=".$result_ary["page_id"]."\">edit</A></font>";
			  }
			  else { 
			  	if ($ret===true) { 
			  	$result .= "<font class=\"smaller\"><A HREF=\"edit_page.php?page_id=".$result_ary["page_id"]."\">edit</A></font>";
			  	}
   				else { 
   					$result .= "-"; 
   				}
			  }
			  $result .= "</td>\n";
			  $result .= "     						                   </tr>\n";
		  	}
		  }
		}
	    $result .= "    						                 </table>\n";
	    $result .= "  						              </td>\n						              </tr>\n";    
	}
	
    elseif ($type=="nothing") {
    	// used to output nothing so you can still use field validation
    }

    // all other types with two columns
    else {
	    // first TD
	    $result .= "  						            <tr valign=\"top\">\n  						              <td";
	    if ($error) { $result .= " bgcolor=\"$td_bg_error\""; }
	    elseif ($td_bg_color2) { $result .= " bgcolor=\"$td_bg_color2\""; }
	    $result .= ">";
	    $result .= "\n";
	    $result .= "    						              $label:";
	    if ($msg || $required) { $result .= "\n    						              <font class=\"smaller_faded\"><BR>($required$msg)</font>"; }
	    $result .= "</td>\n";

	    // second TD
	    $result .= "  						              <td";
	    if ($error) { $result .= " bgcolor=\"$td_bg_error\""; }
	    elseif ($td_bg_color2) { $result .= " bgcolor=\"$td_bg_color2\""; }
	    $result .= ">\n";
	    
	    if ($type=="state_pulldown") {
			global $state_list;
			$result .= "    						              <select name=\"$name\">\n";
	        if (!$value && !$default_state) { $result .= "<option SELECTED value=\"\">Select State...</option>\n"; }
		    while (list($abbr,$long) = each($state_list)) {
		    	if ($abbr == $value) {
		    		$result .= "<option SELECTED value=\"$abbr\">$long</option>\n";
		    		$match=1;
		    	}
		    	else {
		    		$result .= "<option value=\"$abbr\">$long</option>\n";
		    	}
		    }
		    if (!$match && $value) {
		    	 $result .= "<option SELECTED value=\"$value\">$value</option>\n";
		    }
		    $result .= "</select>\n";
	    }

	    elseif ($type=="country_pulldown") {
			global $country_list;
			//$country_list = array("U.S.A");
	        $result .= "    						              <select name=\"$name\">";
	        //if (!$value) { $result .= "<option SELECTED value=\"\">Select Country...</option>"; } 
	        if (!$value) { $result .= "<option SELECTED value=\"U.S.A.\">U.S.A.</option>\n"; }
		    while (list($key,$long) = each($country_list)) {
		    	if ($long == $value) {
		    		$result .= "<option SELECTED value=\"$long\">$long</option>\n";
		    		$match=1;
		    	}
		    	else {
		    		$result .= "<option value=\"$long\">$long</option>\n";
		    	}
		    }
		    if (!$match && $value) {
		    	 $result .= "<option SELECTED value=\"$value\">$value</option>\n";
		    }
		    $result .= "</select>\n";
	    }

	    elseif ($type=="office_pulldown") {
			$office_sql = "SELECT id,heading FROM office_directory ORDER BY heading ASC"; 
			$office_result = mysql_query($office_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			//$country_list = array("U.S.A");
	        $result .= "    						              <select name=\"$name\">\n";
	        //if (!$value) { $result .= "<option SELECTED value=\"\">Select Country...</option>"; } 
	        if (!$value) { $result .= "<option SELECTED value=\"\">Select Office...</option>\n"; }
		    while ($office_list = mysql_fetch_assoc($office_result)) {
		    	if ($office_list['id'] == $value) {
		    		$result .= "<option SELECTED value=\"".$office_list['id']."\">".$office_list['heading']."</option>\n";
		    		$match=1;
		    	}
		    	else {
		    		$result .= "<option value=\"".$office_list['id']."\">".$office_list['heading']."</option>\n";
		    	}
		    }
		    if (!$match && $value) {
		    	 $result .= "<option SELECTED value=\"$value\">$value</option>\n";
		    }
		    $result .= "</select>\n";
	    }

	    elseif ($type=="facility_pulldown") {
			$facility_sql = "SELECT id,heading FROM facilities_directory ORDER BY heading ASC"; 
			$facility_result = mysql_query($facility_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			//$country_list = array("U.S.A");
	        $result .= "    						              <select name=\"$name\">\n";
	        //if (!$value) { $result .= "<option SELECTED value=\"\">Select Country...</option>"; } 
	        if (!$value) { $result .= "<option SELECTED value=\"\">Select Facility...</option>\n"; }
		    while ($facility_list = mysql_fetch_assoc($facility_result)) {
		    	if ($facility_list['id'] == $value) {
		    		$result .= "<option SELECTED value=\"".$facility_list['id']."\">".$facility_list['heading']."</option>\n";
		    		$match=1;
		    	}
		    	else {
		    		$result .= "<option value=\"".$facility_list['id']."\">".$facility_list['heading']."</option>\n";
		    	}
		    }
		    if (!$match && $value) {
		    	 $result .= "<option SELECTED value=\"$value\">$value</option>\n";
		    }
		    $result .= "</select>\n";
	    }

	   	elseif ($type=="region_pulldown") {
			$region_sql = "SELECT regions.id,CONCAT(regions.state_id, ' - ', regions.heading) as heading FROM regions ORDER BY heading"; 
			$region_result = mysql_query($region_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			if ($value != "000") {
				$result .= "    						              <select name=\"$name\">\n";
	        	if (!$value) { $result .= "<option SELECTED value=\"\">Select Region...</option>\n"; }
		    	while ($region_list = mysql_fetch_assoc($region_result)) {
		    		if ($region_list['id'] == $value) {
		    			$result .= "<option SELECTED value=\"".$region_list['id']."\">";
		    			$result .= $region_list['heading'];
		    			$result .= "</option>\n";
		    			$match=1;
		    		}
		    		else {
		    			$result .= "<option value=\"".$region_list['id']."\">";
		    			$result .= $region_list['heading'];
		    			$result .= "</option>\n";
		    		}
		    	}
		    	if (!$match && $value) {
		    		$result .= "<option SELECTED value=\"$value\">$value</option>\n";
		    	}
		    	$result .= "</select>\n";
	    	}
	    	else {
	    		$result .= "<input type=\"hidden\" name=\"$name\" value=\"$value\">";
	    	}
	   	}

	   	elseif ($type=="product_pulldown") {
			$product_sql = "SELECT DISTINCT product FROM ftp_settings ORDER BY product ASC"; 
			$product_result = mysql_query($product_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			if ($value != "000") {
				$result .= "    						              <select name=\"$name\">\n";
	        	if (!$value) { $result .= "<option SELECTED value=\"\">Select Product...</option>\n"; }
		    	while ($product_list = mysql_fetch_assoc($product_result)) {
		    		if ($product_list['id'] == $value) {
		    			$result .= "<option SELECTED value=\"".$product_list['product']."\">";
		    			$result .= $product_list['product'];
		    			$result .= "</option>\n";
		    			$match=1;
		    		}
		    		else {
		    			$result .= "<option value=\"".$product_list['product']."\">";
		    			$result .= $product_list['product'];
		    			$result .= "</option>\n";
		    		}
		    	}
		    	if (!$match && $value) {
		    		$result .= "<option SELECTED value=\"$value\">$value</option>\n";
		    	}
		    	$result .= "</select>\n";
	    	}
	    	else {
	    		$result .= "<input type=\"hidden\" name=\"$name\" value=\"$value\">";
	    	}
	   	}

	   	elseif ($type=="county_pulldown") {
			$county_sql = "SELECT counties.id,CONCAT_WS(' - ', regions.state_id, regions.heading, counties.heading) as heading FROM counties,regions WHERE counties.region_id = regions.id ORDER BY heading"; 
			$county_result = mysql_query($county_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			if ($value != "000") {
				$result .= "    						              <select name=\"$name\">\n";
	        	if (!$value) { $result .= "<option SELECTED value=\"\">Select County...</option>\n"; }
		    	while ($county_list = mysql_fetch_assoc($county_result)) {
		    		if ($county_list['id'] == $value) {
		    			$result .= "<option SELECTED value=\"".$county_list['id']."\">";
		    			$result .= $county_list['heading'];
		    			$result .= "</option>\n";
		    			$match=1;
		    		}
		    		else {
		    			$result .= "<option value=\"".$county_list['id']."\">";
		    			$result .= $county_list['heading'];
		    			$result .= "</option>\n";
		    		}
		    	}
		    	if (!$match && $value) {
		    	 	$result .= "<option SELECTED value=\"$value\">$value</option>\n";
		    	}
		    	$result .= "</select>\n";
			}
			else {
				$result .= "<input type=\"hidden\" name=\"$name\" value=\"$value\">";
			}
	    }

   	   	elseif (strstr($type,"parent_pulldown")) {
   	   		$db_arr = explode(",",$type);
			$parent_sql = "SELECT P1.rgt, CONCAT('after ', P1.content) AS content
   							FROM ".$db_arr[1]." AS P1, ".$db_arr[1]." AS P2
  							WHERE P1.lft BETWEEN P2.lft AND P2.rgt
  							GROUP BY P1.content
  							ORDER BY P1.lft;"; 
			$parent_result = mysql_query($parent_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			$result .= "    						              <select name=\"$name\">\n";
	        if (!$value) { $result .= "<option SELECTED value=\"\">Select location...</option>\n"; }
	        $result .= "<option value=\"beginning\">at beginning of list</option>\n";
			$result .= "<option value=\"end\">at end of list</option>\n";
	        while ($parent_list = mysql_fetch_assoc($parent_result)) {
		    	// limit size of displayed name/pulldown
		    	$con = $parent_list['content'];
	    		$max_length = 75;
	    		if (strlen($con) > $max_length) { 
	    			$con = substr ($con, 0, $max_length);
	    			$con .= "..."; 
	    		}
		    	if ($parent_list['rgt'] == $value) {
		    		$result .= "<option SELECTED value=\"".$parent_list['rgt']."\">$con</option>\n";
		    		$match=1;
		    	}
		    	else {
		    		$result .= "<option value=\"".$parent_list['rgt']."\">$con</option>\n";
		    	}
		    }
		    if (!$match && $value) {
		    	 $result .= "<option SELECTED value=\"$value\">$value</option>\n";
		    }
		    $result .= "</select>\n";
	    }
		
	    elseif ($type=="checkbox") {
	    	if (!array_key_exists("lft",$_POST)) {
				$result .= "<input type=\"checkbox\" name=\"$name\" value=\"$value\">\n";
	    	}
	    	else {
	    		$result .= "<input type=\"checkbox\" name=\"$name\" value=\"$value\" CHECKED>\n";
	    	}
	    }
	    
	    elseif ($type=="categories") {
			global $category_ary,$delimiter;
			// turn queried category string into array
			if ($value != "") {  
				global $HTTP_POST_VARS; // had trouble with passed form element array - $value wouldn't fully recognize as array
				if (is_array($HTTP_POST_VARS["categories"])) { 
					while (list($key,$val) = each($HTTP_POST_VARS["categories"])) {
						$passed_cats[$val] = $val;
					}
				}
				else { 
					$passed_cats_noindex = explode($delimiter, $value);  
					// make values the keys for easier reference below
					while (list($key,$val) = each($passed_cats_noindex)) {
						$passed_cats[$val] = $val;
					}
				}
			}
	        $result .= "    						              <select name=\"".$name."[]\" MULTIPLE SIZE=\"5\">\n";
	        //if (!$value) { $result .= "<option SELECTED value=\"\">Select $name...</option>"; } 
		    while (list($key,$long) = each($category_ary)) {
		    	if ($long == $passed_cats[$long]) {
		    		$result .= "    						                <option SELECTED value=\"$long\">$long</option>\n";
		    		$read_cats[$long] = $long; // marks which cats from the existing stored cats have been outputted
		    	}
		    	else {
		    		$result .= "    						                <option value=\"$long\">$long</option>\n";
		    	}
		    }
		    // step through stored cats to make sure we see both stored/queried and latest cats from definition array
		    if ($passed_cats != "") {
			  reset($passed_cats);
			  while (list($key,$val) = each($passed_cats)) {
				  if ($val != $read_cats[$val]) { // don't show cats already outputted
					  $result .= "    						                <option SELECTED value=\"$val\">$val</option>\n";
				  }
			  }
		    }
		    $result .= "    						                <option value=\"\">(none)</option>\n";
		    $result .= "    						              </select>\n";
	    }

	    elseif ($type=="text_area") {
	    	$result .= "    						              <TEXTAREA ID=\"$name\" NAME=\"$name\" ROWS=\"$size\" COLS=\"$maxlength\">$value</TEXTAREA>";
				$result .= "<br><img src=\"".$path_sys_images."tb_hyperlink.gif\" onclick=\"AddLink('$name')\" unselectable=\"on\" alt=\"Click to make hyperlink\">&nbsp;
						<img src=\"".$path_sys_images."tb_bold.gif\" onclick=\"AddBold('$name')\" unselectable=\"on\" alt=\"Click to make bold\">\n
	    				<img src=\"".$path_sys_images."tb_italic.gif\" onclick=\"AddItalic('$name')\" unselectable=\"on\" alt=\"Click to make italic\">\n
						<img src=\"".$path_sys_images."tb_undo.gif\" onclick=\"UndoHTML('$name')\" unselectable=\"on\" alt=\"Click to remove html tags\">\n";
	    	}

	    elseif ($type=="view_only") {
	    	if ($value=="") { $result .= "    						              (N/A)<input type=\"hidden\" name=\"$name\" value=\"$value\">"; }
	    	else { $result .= "    						              $value<input type=\"hidden\" name=\"$name\" value=\"$value\">"; }
	    }

	    elseif ($type=="hidden") {
	    	if ($value=="") { $result .= "    						              (N/A)<input type=\"hidden\" name=\"$name\" value=\"$value\">"; }
	    	else { $result .= "    						              <input type=\"hidden\" name=\"$name\" value=\"$value\">"; }
	    }

	    // regular default text
	    else {
		    $result .= "    						              <input type=\"text\" name=\"$name\" maxlength=\"$maxlength\" size=\"$size\" value=\"$value\">"; 
	    }
	    $result .= "</td>\n						              </tr>\n";
    }
  }
  else {
  	// first TD
	    $result .= "  						            <tr valign=\"top\">\n  						              <td";
	    if ($error) { $result .= " bgcolor=\"$td_bg_error\""; }
	    elseif ($td_bg_color2) { $result .= " bgcolor=\"$td_bg_color2\""; }
	    $result .= ">";
	    $result .= "\n";
	    $result .= "    						              $label:";
	    if ($msg || $required) { $result .= "\n    						              <font class=\"smaller_faded\"><BR>($required$msg)</font>"; }
	    $result .= "</td>\n";

	// second TD
	    $result .= "  						              <td";
	    if ($error) { $result .= " bgcolor=\"$td_bg_error\""; }
	    elseif ($td_bg_color2) { $result .= " bgcolor=\"$td_bg_color2\""; }
	    $result .= ">\n";
  		if ($alt_type["type"] == "show_description") {
  			if (!$value) {
  				$v = $_REQUEST[$name];
  			}
  			else {
  				$v = $value;
  			} 
  			$description_sql = "SELECT ".$alt_type["alt_field"]." FROM ".$alt_type["alt_table"]." WHERE id = '$v' LIMIT 1"; 				
  			$description_result = mysql_query($description_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			if ($description_result) {
				$description = mysql_fetch_assoc($description_result);
  				$result .= $description[$alt_type["alt_field"]]." <input type=\"hidden\" name=\"$name\" maxlength=\"$maxlength\" size=\"$size\" value=\"$v\">"; 
			}
		}
		$result .= "</td>\n						              </tr>\n";
  }
  
  		
  echo $result;
}

// Field Validator
// - verifies passed values based on types:
//   empty, numerical, e-mail
// - takes array in specific format:
// 	 array ("name" => array ("label"=>"", "error"=>"_error", "value"=>"", "size"=>"", "maxlength"=>"50", "type"=>"text", "required"=>"", "msg"=>"", "validate"=>""))

function form_validation ($array) {

    global $form_fields_ary, $error, $error_ctd, $HTTP_POST_VARS;
    global $die_mesg, $PHP_SELF, $db_conn;

	// check if empty, correct format, give errors if bad, 
	while (list($key_name, $sa) = each($array)) { 
    	
    	// pull out validation types: check_full, etc
    	if ($clean_types = strtok($sa[validate],",")) {
			while ($clean_types) {

	   	    	// check for empty fields
	  	    	if ($clean_types=="check_full") {
	  	    		// works if always rely on array instead of ... if (!$HTTP_POST_VARS[$key_name]) { 
	  	    		if (!$form_fields_ary[$key_name][value]) { 
	  	    			$error[] = "$sa[label] is missing";
	  	   				$form_fields_ary[$key_name][error] = 1; // set individual error
	  	    		}
	  	    	}

	  	    	// strip_spaces
	  	    	if ($clean_types=="strip_spaces") {
	  	        	$form_fields_ary[$key_name][value] = eregi_replace("[[:space:]]+", " ", $form_fields_ary[$key_name][value]);
	  	        	$form_fields_ary[$key_name][value] = trim ($form_fields_ary[$key_name][value]);
	  	    	}
	  	    	
	  	    	// strip_bad_char that mess up forms and queries even with magic quotes - for most text fields
	  	    	if ($clean_types=="strip_bad_char") {
	  	        	$form_fields_ary[$key_name][value] = eregi_replace("[^_ \.\,#0-9a-z-]", "", $form_fields_ary[$key_name][value]);
	  	        	$form_fields_ary[$key_name][value] = eregi_replace("\\\\", "", $form_fields_ary[$key_name][value]);
	  	    	}

	  	    	// clean_us_zip
	  	    	if ($clean_types=="clean_us_zip") {
	  	        	$form_fields_ary[$key_name][value] = eregi_replace("[^0-9-]","",$form_fields_ary[$key_name][value]); // FIX multiple "-"
	  	        	if ($form_fields_ary[$key_name][value] && !(eregi("^([0-9]{5})(-[0-9]{4})?$",$form_fields_ary[$key_name][value]))) {
	  	    			$error[] = "$sa[label] should be five digits or in Zip+4 format: 12345-6789";
	  	   				$form_fields_ary[$key_name][error] = 1; // set individual error
	  	   				$form_fields_ary[$key_name][value] = ""; // clear value
	  	    		}
	  	    	}	

	  	    	// clean_us_phone
	  	    	if ($clean_types=="clean_us_phone") {
	  	        	$form_fields_ary[$key_name][value] = eregi_replace("^0|^1|[^0-9x]","",$form_fields_ary[$key_name][value]); // FIX multiple "x"
	  	        	$form_fields_ary[$key_name][value] = strtolower($form_fields_ary[$key_name][value]);
	  	        	if ($form_fields_ary[$key_name][value] && (strlen($form_fields_ary[$key_name][value]) < 10)) {
	  	    			$error[] = "$sa[label] should be at least 10 digits and not start with a 0 or 1";
	  	   				$form_fields_ary[$key_name][error] = 1; // set individual error
	  	   				$form_fields_ary[$key_name][value] = ""; // clear value
	  	    		}
	  	    	}	

	  	    	// valid_email_format
	  	    	if ($clean_types=="valid_email_format") {
	  	        	if ($form_fields_ary[$key_name][value] && !(eregi("^[_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3}$",$form_fields_ary[$key_name][value]))) {
	  	    			$error[] = "$sa[label] appears invalid - use name@domain.com format";
	  	   				$form_fields_ary[$key_name][error] = 1; // set individual error
	  	   				$form_fields_ary[$key_name][value] = ""; // clear value
	  	    		}
	  	    	} 
	  	    	
	  	    	// valid_url
	  	    	if ($clean_types=="valid_url") {
	  	        	if ($form_fields_ary[$key_name][value] && !(eregi("(http|ftp|https):\/\/[\w]+(.[\w]+)([\w\-\.,@?^=%&amp;:/~\+#]*[\w\-\@?^=%&amp;/~\+#])?",$form_fields_ary[$key_name][value]))) {
	  	    			$error[] = "$sa[label] appears invalid - use http://host.domain.tld format such as http://www.company.com";
	  	   				$form_fields_ary[$key_name][error] = 1; // set individual error
	  	   				$form_fields_ary[$key_name][value] = ""; // clear value
	  	    		}
	  	    	} 
	  	    	
	  	    $clean_types = strtok(",");
			}
    	}
	}
    reset($array);
}

// Select Existing Pulldown Function
// - spits out pulldown, selects passed value, accepts element name

function select_existing ($query, $name, $selected="Select...", $label_flag="change", $select_existing_default_value=""){
	
    global $die_mesg, $db_conn, $show_search, $entity_label, $change_id_label, $PHP_SELF, $super;
    $label_flag_cap = ucfirst($label_flag);
    
    // show pulldown if rows less than limit, showing ALL active/disabled records per passed query
    if ($query && ($result = mysql_query($query,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__)) && (mysql_num_rows($result) >= 1)) {
		echo "				              <FORM method=\"post\" action=\"$PHP_SELF\">\n";
		//echo "				              <INPUT TYPE=\"hidden\" NAME=\"$change_id_label\" VALUE=\"$$change_id_label\">\n				              <INPUT TYPE=\"hidden\" NAME=\"super\" VALUE=\"$super\">\n";
		echo "				              <INPUT TYPE=\"hidden\" NAME=\"super\" VALUE=\"$super\">\n";
		if ($select_existing_default_value) {
			echo "<INPUT TYPE=\"hidden\" NAME=\"$select_existing_default_value\" VALUE=\"".$_REQUEST[$select_existing_default_value]."\">\n";
		}
		echo "				              <tr>\n				                <td>\n				                  Select $entity_label below to $label_flag:</td>\n				              </tr>\n";
		echo "				              <tr>\n				                <td>\n";
	    
	    echo "				                  <SELECT name=\"$name\">\n";
	    echo "  				                  <option SELECTED value=\"\">$selected</option>\n";
	    while (list($key,$val) = mysql_fetch_row($result)) {
	    	// limit size of displayed name/pulldown
	    	$max_length = 60;
	    	if (strlen($val) > $max_length) { 
	    		$val = substr ($val, 0, $max_length);
	    		$val .= "..."; 
	    	}
	    	echo "  				                  <option value=\"$key\">$val</option>\n";
	    }
	    echo "				                  </SELECT>\n";
	    echo "				                  and <input type=\"submit\" name=\"change\" value=\"$label_flag_cap\"><BR><BR>";
		
		echo "</td>\n				              </tr>\n";
		echo "				              </form>\n";
		echo "				              <tr>\n				                <td>\n				                  Or add new $entity_label below:</td>\n				              </tr>\n";
    }
    else {
		echo "				              <tr>\n				                <td>\n				                  Add new $entity_label below:</td>\n				              </tr>\n";
    }
}

function show_existing ($query, $td_bg_color2){
	
    global $die_mesg, $db_conn;
    
    // show pulldown if rows less than limit, showing ALL active/disabled records per passed query
    if ($query && ($result = mysql_query($query,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__)) && (mysql_num_rows($result) >= 1)) {
	    while ($val = mysql_fetch_row($result)) {
	    	echo "<tr>\n";
	    	foreach ($val as $this_column) {
	    		echo "<td bgcolor=\"$td_bg_color2\" align=\"left\">$this_column</td>\n";
	    	}
	    	echo "</tr>\n";
	    }
    }
    else {
		echo "				              <tr>\n				                <td bgcolor=\"$td_bg_color2\" colspan=\"4\" align=\"center\">\n				                  No areas assigned</td>\n				              </tr>\n";
    }
}

// Slurper2 Function - content field grabber
// returns content between two defined tags

function slurper2($start,$end,$string) { 
	$start_position = strpos($string, $start) + strlen($start);
	$end_position=strpos($string, $end, $start_position);
	if ((is_string($start_position) && !$start_position) || (is_string($end_position) && !$end_position)) {
		//return 0;
	}
	else {
		$length=$end_position-$start_position;
		$string=substr($string, $start_position, $length);
		// string length includes tag length so must check for it
		if ($string != "") {
			return $string;
		}
	}
} 

/**
 * Exam if a remote file or folder exists
 *
 * This function is adopted from setec's version.
 * + What's new:
 * Error code with descriptive string.
 * More accurate status code handling.
 * Redirection tracing supported.
 *
 * @retval true resource exists
 * @retval false resource doesn't exist
 * @retval "1 Invalid URL host"
 * @retval "2 Unable to connect to remote host"
 * @retval "3 Status Code not supported: {STATUS_CODE REASON}"
 */
function remote_file_exists($url)
{
   $myresults = Array("found" => false, "results" =>"");
   $head = '';
   $url_p = parse_url ($url);

   if (isset ($url_p['host']))
   { $host = $url_p['host']; }
   else
   {
       	$myresults["results"] = "1 Invalid URL host";
   		return $myresults;
   }

   if (isset ($url_p['path']))
   { $path = $url_p['path']; }
   else
   { $path = ''; }

   $fp = fsockopen ($host, 80, $errno, $errstr, 20);
   if (!$fp)
   { 
       	$myresults["results"] = "2 Unable to connect to remote host";
   		return $myresults;
   }
   else
   {
       $parse = parse_url($url);
       $host = $parse['host'];

       fputs($fp, 'HEAD '.$url." HTTP/1.1\r\n");
       fputs($fp, 'HOST: '.$host."\r\n");
       fputs($fp, "Connection: close\r\n\r\n");
       $headers = '';
       while (!feof ($fp))
       { $headers .= fgets ($fp, 128); }
   }
   fclose ($fp);
   
   // for debug
   //echo nl2br($headers);
   
   $arr_headers = explode("\n", $headers);
   if (isset ($arr_headers[0]))    {
       if(strpos ($arr_headers[0], '200') !== false)
       { 
       		//return true;
       		$myresults["found"] = true;
       		$myresults["results"] = $headers;
   			return $myresults;
	   }
       if( (strpos ($arr_headers[0], '404') !== false) ||
           (strpos ($arr_headers[0], '410') !== false))
       { return $myresults; }
       if( (strpos ($arr_headers[0], '301') !== false) ||
           (strpos ($arr_headers[0], '302') !== false))
       {
           preg_match("/Location:\s*(.+)\r/i", $headers, $matches);
           if(!isset($matches[1]))
               return $myresults;
           $nextloc = $matches[1];
           return remote_file_exists($nextloc);
       }
   }
   preg_match('/HTTP.*(\d\d\d.*)\r/i', $headers, $matches);
   $myresults["results"] = '3 Status Code not supported'.
       (isset($matches[1])?": $matches[1]":'');
   return $myresults; 
}
?>

