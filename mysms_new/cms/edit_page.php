<?php

$this_page_title = "Edit Selected Page";
session_start(); // use on all pages for session mgmt!
include("config1.inc.php"); // stores important required info
$page_title .= " - "; $page_title .= $this_page_title;  // additional title for this page
include($auth_header);  // authorization stuff referenced in config file, can override default
include($header); // HTML header include referenced in config file or could override here
include($formtools);  // verification routines

$edit_ary_begin_tag = "// #CMS_Start - DO NOT ALTER THIS LINE";
$edit_ary_end_tag = "// #CMS_End - DO NOT ALTER THIS LINE";
$pdftolink = ""; 
$linkstr = "";

// using passed page id, get name, path, and last modified date, display
if ($page_id !="") {
	$pg_sql = "SELECT page_id,title,path,UNIX_TIMESTAMP(last_update) as last_update FROM page WHERE page_id=$page_id"; 
	$pg_result = mysql_query($pg_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
	//echo "<br><br>".var_dump($_POST)."<BR>POST variables:<br>"."Line: ".__LINE__;
	
	$result_ary = mysql_fetch_array($pg_result);
    $edit_page_title = $result_ary["title"];

	//$edit_page_mod = date("D M j, Y, g:ia", ($result_ary["last_update"] + $s_time_offset))." ".$c_time_zone; 
    $edit_page_mod = date("D M j, Y, g:ia", ($result_ary["last_update"] + $s_time_offset))." ".$c_time_zone;
    /*		  if (file_exists($result_ary["path"])) { 
			  	$edit_page_mod = date("D M j, Y, g:ia", (filemtime($result_ary["path"]) + $s_time_offset))." ".$c_time_zone; 
			  }
			  else { 
			  	$ret=false;
			  	$ret_array = remote_file_exists(str_replace(".php",".html",$result_ary["path"]));
			  	$ret=$ret_array["found"];
			  	if ($ret===true) { 
					preg_match("/Last-Modified:\s*(.+)\r/i", $ret_array["results"], $matches);
           			if(!isset($matches[1])) {
           				$edit_page_mod .= " - ";
           			} else {
           				$edit_page_mod .= date("D M j, Y <\B\R>g:ia", (strtotime($matches[1]) + $s_time_offset))." ".$c_time_zone;
           			}
			  	}
			  }
	*/
    
    
    //$edit_page_mod = date("D M j, Y, g:ia", (filemtime($result_ary["path"]) + $s_time_offset))." ".$c_time_zone;

	// parse page & check edit array
	$whole_page = implode ('', file ($result_ary["path"])); // read whole file into var
	$cur_edit_ary = slurper2($edit_ary_begin_tag,$edit_ary_end_tag,$whole_page); // get creamy filling
	//echo "<BR><BR>Line: ".__LINE__." cur_edit_ary := <br> $cur_edit_ary";	
	if ($cur_edit_ary!="") { @eval ($cur_edit_ary); } // parse array pulled from file
	// ERROR check array
	if ($edit_ary !="") {
		// check required fields in array
		reset($edit_ary);
		while (list($name, $sa) = each($edit_ary)) { 
		  if ($name=="") { $fatal_error_field[] = "chunk name"; }
		  if (eregi("[^_ \.\,#0-9a-z-]", $name)) { $fatal_error_field[] = "chunk name \"$name\" has invalid characters"; }
		  if ($sa[title]=="") { $fatal_error_field[] = "title"; }
		  if ($sa[table_name]=="") { $fatal_error_field[] = "table_name"; }
		  $tbl_name_ary[] = $sa[table_name]; // used below to check table existance
		}
		if ($fatal_error_field == "") {
		  $tbl_result = mysql_list_tables($db_name);
		  while ($row = mysql_fetch_row($tbl_result)) { $tbl_result_ary[] = $row[0]; }
		  // step thru available table names and compare to make sure tables named exists
		  while (list($key, $val) = each($tbl_name_ary)) {
		  	if (!in_array(strtolower($val), $tbl_result_ary)) { $fatal_error_table[] = $val; }
		  	// check for required id column in each table
		  	else {
		  	  unset($roger_houston);
			  $tb_sql = "SELECT * FROM $val LIMIT 0,1"; 
			  $tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			  //echo "<br>$tb_sql<br>"."Line: ".__LINE__;
			  $i = 0;
			  while ($i < mysql_num_fields($tb_result)) {
				 $field_info = mysql_fetch_field($tb_result,$i);
				 if ($field_info->name == "id") { $roger_houston = 1; } // got match
				 $i++;
			  }
			  if ($roger_houston == "") { $fatal_error_id[] = $val; } // 
		  	}
		  }
		  if (($fatal_error_table == "") && ($fatal_error_id == "")) {
		  	// everything is good, continue and show editable fields
		  }
		  elseif ($fatal_error_table != "") { 
			  $fatal_error = "(Table defined in ".$result_ary["path"]." not found in database: "; 
			  while (list($key, $val) = each($fatal_error_table)) {
				$fatal_error .= " $val,";
			  } 
			  $fatal_error = substr($fatal_error, 0, -1); // take last , off
			  $fatal_error .= "  - seek help below)"; 
		  }
		  elseif ($fatal_error_id != "") { 
			  $fatal_error = "(Table defined in ".$result_ary["path"]." does not include required ID field: "; 
			  while (list($key, $val) = each($fatal_error_id)) {
				$fatal_error .= " $val,";
			  } 
			  $fatal_error = substr($fatal_error, 0, -1); // take last , off
			  $fatal_error .= "  - seek help below)"; 
		  }
		}
		else { 
			$fatal_error = "(Required fields in edit array not found in ".$result_ary["path"].": "; 
			while (list($key, $val) = each($fatal_error_field)) {
			  $fatal_error .= " $val,";
			} 
			$fatal_error = substr($fatal_error, 0, -1); // take last , off
			$fatal_error .= "  - seek help below)"; 
		}
	}
	// more badness
	else { $fatal_error = "(Required edit array not found in ".$result_ary["path"]."  - seek help below)"; }
}
// give error
else { $fatal_error = "(Required page ID missing - seek help below)"; }

// set default button action
$but_name = "update";
$but_value = "   Update   ";


// do field verification AND inserting/updating
if ($update) {
	//($_FILES);
	// check fields - all fields required unless a whole set is empty
	// $chunk1[#][field][val]
	//echo "<PRE>";
	//print_r($_FILES);
	//print_r($_REQUEST);
	//echo "</PRE>";
	//echo "<BR><BR>Line: ".__LINE__." edit_ary:".var_dump($edit_ary)."<br><BR>";
	reset($edit_ary);
	while (list($name) = each($edit_ary)) { 
		//echo "<BR><BR>".var_dump($name)."Line: ".__LINE__." name: ";
		// only delete when correct type
		if (!is_array($edit_ary[$name]['display_type']) && ($edit_ary[$name]['display_type']['entry_type']!="edit_one")) {
		  $sql1 = "DELETE FROM ".$edit_ary[$name]['table_name']; // clear any existing values
		  $result1 = mysql_query($sql1,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		  //echo "<br>$sql1<br>"."Line: ".__LINE__."<BR><BR>";
		}
		// figure name
		//echo "1 $name, $sa<BR>\n";
		$sa = $$name;
		//echo "<br>Line: ".__LINE__." sa: ".var_dump($sa)."<br><br>";	

		
		while (list($n, $v) = each($sa)) { 
			//echo "&nbsp; 2 $n, $v<BR>\n";
			$v_cnt = count($v);
			//echo "<br>Line: ".__LINE__." v_cnt: $v_cnt<br>";
			$v_cnt_empty = 1; // id col get counted automatically
			$col_str = "";
			$val_str = "";
			$sqlee = "";
			//echo "<br>Line: ".__LINE__." v: ".var_dump($v)."<br><br>";
			while (list($n1, $v1) = each($v)) {
				//echo "&nbsp; &nbsp; 3 $n1, $v1<BR>\n";
				//echo "<br>Line: ".__LINE__." n1: $n1 --> $v1<br>";
				if ($n1=="link_target") {
					if ($v1=="") { $v_cnt_empty++; $v1="NULL"; }
					$linkstr = $v1;
					$v1="'-r_start-$v1-r_end-'";
				}
				elseif ($v1=="") { $v_cnt_empty++; $v1="NULL"; } // images array IS EMPTY but ISNT
				elseif ($n1=="id") { $v1="NULL"; }
				
				// handle image upload, etc
				elseif ($n1=="image") { 
						if ($_REQUEST[$name."_".$n."_".image1]!="") { // pulldown image
							$v1 = "'".$path_images.$_REQUEST[$name."_".$n."_".image1]."'";
						}
						elseif (($_FILES[$name."_".$n."_".image3]['error'] != 4) && ($_FILES[$name."_".$n."_".image3]['tmp_name'] != "none")) { // empty form submission still passes some usesless values
							$upload_errors = array( 1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.', 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form', 'The uploaded file was only partially uploaded', 'No file was uploaded');
							if (move_uploaded_file($_FILES[$name."_".$n."_".image3]['tmp_name'], $abs_path . $path_images . $_FILES[$name."_".$n."_".image3]['name'])) {
								$v1 = "'".$path_images.$_FILES[$name."_".$n."_".image3]['name']."'";
							}
							else {  
								$error[] = "Sorry, the file \"".$_FILES[$name."_".$n."_".image3]['name']."\" <B>failed to upload</B> properly. Please use your browsers back button and try again. Get help below if this problem persists.";
								$error[] = "Specific upload error: ".$upload_errors[$_FILES[$name."_".$n."_".image3]['error']];
								$v_cnt_empty++;
								$v1 = "NULL";
							}					
						}
						elseif ($_REQUEST[$name."_".$n."_".image2]!="") { // manually entered path
							$v1 = "'".$_REQUEST[$name."_".$n."_".image2]."'";
						}
						else {
							$v_cnt_empty++;
							$v1 = "NULL";
						}
				}
				elseif ($n1=="name_image") { 
					if ($_REQUEST[$name."_".$n."_"."1image1"]!="") { // pulldown image
						$v1 = "'".$path_images.$_REQUEST[$name."_".$n."_"."1image1"]."'";
					}
					elseif (($_FILES[$name."_".$n."_"."1image3"]['error'] != 4) && ($_FILES[$name."_".$n."_"."1image3"]['tmp_name'] != "none")) { // empty form submission still passes some usesless values
						$upload_errors = array( 1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.', 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form', 'The uploaded file was only partially uploaded', 'No file was uploaded');
						if (move_uploaded_file($_FILES[$name."_".$n."_"."1image3"]['tmp_name'], $abs_path . $path_images . $_FILES[$name."_".$n."_"."1image3"]['name'])) {
							$v1 = "'".$path_images.$_FILES[$name."_".$n."_"."1image3"]['name']."'";
						}
						else {  
							$error[] = "Sorry, the file \"".$_FILES[$name."_".$n."_"."1image3"]['name']."\" <B>failed to upload</B> properly. Please use your browsers back button and try again. Get help below if this problem persists.";
							$error[] = "Specific upload error: ".$upload_errors[$_FILES[$name."_".$n."_"."1image3"]['error']];
							$v_cnt_empty++;
							$v1 = "NULL";
						}					
					}
					elseif ($_REQUEST[$name."_".$n."_"."1image2"]!="") { // manually entered path
						$v1 = "'".$_REQUEST[$name."_".$n."_"."1image2"]."'";
					}
					else {
						$v_cnt_empty++;
						$v1 = "NULL";
					}
				}
				elseif ($n1=="thumbnail_off") { 
					if ($_REQUEST[$name."_".$n."_"."2image1"]!="") { // pulldown image
						$v1 = "'".$path_images.$_REQUEST[$name."_".$n."_"."2image1"]."'";
					}
					elseif (($_FILES[$name."_".$n."_"."2image3"]['error'] != 4) && ($_FILES[$name."_".$n."_"."2image3"]['tmp_name'] != "none")) { // empty form submission still passes some usesless values
						$upload_errors = array( 1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.', 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form', 'The uploaded file was only partially uploaded', 'No file was uploaded');
						if (move_uploaded_file($_FILES[$name."_".$n."_"."2image3"]['tmp_name'], $abs_path . $path_images . $_FILES[$name."_".$n."_"."2image3"]['name'])) {
							$v1 = "'".$path_images.$_FILES[$name."_".$n."_"."2image3"]['name']."'";
						}
						else {  
							$error[] = "Sorry, the file \"".$_FILES[$name."_".$n."_"."2image3"]['name']."\" <B>failed to upload</B> properly. Please use your browsers back button and try again. Get help below if this problem persists.";
							$error[] = "Specific upload error: ".$upload_errors[$_FILES[$name."_".$n."_"."2image3"]['error']];
							$v_cnt_empty++;
							$v1 = "NULL";
						}					
					}
					elseif ($_REQUEST[$name."_".$n."_"."2image2"]!="") { // manually entered path
						$v1 = "'".$_REQUEST[$name."_".$n."_"."2image2"]."'";
					}
					else {
						$v_cnt_empty++;
						$v1 = "NULL";
					}
				}
				elseif ($n1=="thumbnail_on") { 
					if ($_REQUEST[$name."_".$n."_"."3image1"]!="") { // pulldown image
						$v1 = "'".$path_images.$_REQUEST[$name."_".$n."_"."3image1"]."'";
					}
					elseif (($_FILES[$name."_".$n."_"."3image3"]['error'] != 4) && ($_FILES[$name."_".$n."_"."3image3"]['tmp_name'] != "none")) { // empty form submission still passes some usesless values
						$upload_errors = array( 1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.', 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form', 'The uploaded file was only partially uploaded', 'No file was uploaded');
						if (move_uploaded_file($_FILES[$name."_".$n."_"."3image3"]['tmp_name'], $abs_path . $path_images . $_FILES[$name."_".$n."_"."3image3"]['name'])) {
							$v1 = "'".$path_images.$_FILES[$name."_".$n."_"."3image3"]['name']."'";
						}
						else {  
							$error[] = "Sorry, the file \"".$_FILES[$name."_".$n."_"."3image3"]['name']."\" <B>failed to upload</B> properly. Please use your browsers back button and try again. Get help below if this problem persists.";
							$error[] = "Specific upload error: ".$upload_errors[$_FILES[$name."_".$n."_"."3image3"]['error']];
							$v_cnt_empty++;
							$v1 = "NULL";
						}					
					}
					elseif ($_REQUEST[$name."_".$n."_"."3image2"]!="") { // manually entered path
						$v1 = "'".$_REQUEST[$name."_".$n."_"."3image2"]."'";
					}
					else {
						$v_cnt_empty++;
						$v1 = "NULL";
					}
				}
				elseif ($n1=="pdf_file") { 
					if (($_REQUEST[$name."_".$n."_".article1]!="") && ($_REQUEST[$name."_".$n."_".article2]!="")) {
						if ($_REQUEST[$name."_".$n."_".article1]!="") { // pulldown article
							$v1 = "'".$path_articles.$_REQUEST[$name."_".$n."_".article1]."'";
						}
						elseif (($_FILES[$name."_".$n."_".article3]['error'] != 4) && ($_FILES[$name."_".$n."_".article3]['tmp_name'] != "none")) { // empty form submission still passes some usesless values
							$upload_errors = array( 1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.', 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form', 'The uploaded file was only partially uploaded', 'No file was uploaded');
							if (move_uploaded_file($_FILES[$name."_".$n."_".article3]['tmp_name'], $path_articles . $_FILES[$name."_".$n."_".article3]['name'])) {
								$v1 = "'".$path_articles.$_FILES[$name."_".$n."_".article3]['name']."'";
							}
							else {  
								$error[] = "Sorry, the file \"".$_FILES[$name."_".$n."_".article3]['name']."\" <B>failed to upload</B> properly. Please use your browsers back button and try again. Get help below if this problem persists.";
								$error[] = "Specific upload error: ".$upload_errors[$_FILES[$name."_".$n."_".article3]['error']];
								$v_cnt_empty++;
								$v1 = "NULL";
							}					
						}
						elseif ($_REQUEST[$name."_".$n."_".article2]!="") { // manually entered path
							$v1 = "'".$_REQUEST[$name."_".$n."_".article2]."'";
						}
						else {
							$v_cnt_empty++;
							$v1 = "NULL";
						}
					} else {
						$v_cnt_empty++;
						$v1 = "NULL";
					}
					$pdftolink = $v1;
				}
				else { $v1="'$v1'"; }
				//echo "<br>Line: ".__LINE__." n1: $n1 --> $v1<br>";
				$col_str.= $n1.","; 
				$val_str.= $v1.","; 
			}
			//echo "<br>Line: ".__LINE__." v_cnt: $v_cnt vs. v_cnt_empty $v_cnt_empty<br>";
			if ($v_cnt != $v_cnt_empty) { // if ==, then whole set is empty and we ignore
			  $col_str = substr($col_str, 0, -1); // take last , off
			  $val_str = substr($val_str, 0, -1); // take last , off
			  if (strlen($pdf_to_link) > 0) {
			  	str_replace("'-r_start-$linkstr-r_end-'", "'$pdftolink'", $val_str);
			  }
			  else { str_replace("'-r_start-$linkstr-r_end-'", "'$linkstr'", $val_str); }
			  $pdf_to_link = "";
			  $linktochange = 0;
			  $linkstr = "";
			  $sqlee = "INSERT INTO ".$edit_ary[$name]['table_name']." (".$col_str.") VALUES (".$val_str.")";
			  /*
			  echo "col_str=$col_str<BR>\n";
			  echo "val_str=$val_str<BR>\n";
			  echo "v_cnt=$v_cnt<BR>\n";
			  echo "sqlee=$sqlee<BR>\n";
			  echo "v_cnt_empty=$v_cnt_empty<BR>\n";
			  */
			  $result4 = mysql_query($sqlee,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			  //echo "<br>$sqlee<br>"."Line: ".__LINE__;
			  if ($error) { $success = "(Some portions of the page successfully updated.)"; }
			  else { $success = "Page successfully updated."; }
			}
		}
	}
}

if ($change) {
	$but_name = "single_update"; // triggers a single record update
	$but_value = "   Update   ";
}

if ($single_update) {
	
	//$sql = "UPDATE licensee SET company='$company',address1='$address1',address2='$address2',city='$city',state='$state',zip='$zip',country='$country',phone='$phone',fax='$fax',email='$email',website='$website',description='$description',keywords='$keywords',categories='$category_str',timestamp=NOW() WHERE licensee_id=$licensee_id";
	//$result = mysql_query($sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
	//$success = "Record successfully updated.";

	reset($edit_ary);
	while (list($name) = each($edit_ary)) { 
		// figure name
		//echo "1 $name, $sa<BR>\n";
		$sa = $$name;
		
		while (list($n, $v) = each($sa)) { 
			//echo "&nbsp; 2 $n, $v<BR>\n";
			$v_cnt = count($v);
			$v_cnt_empty = 1; // id col get counted automatically
			$col_str = "";
			$val_str = "";
			$sqlee = "";


		/* begin modified for inhouseit
		
		// provide some text to print
		if (array_key_exists("first_name", $v)) {
			//echo "<br>Line: ".__LINE__." v: ".var_dump($v)."<br><br>";	
			//$string = $v["first_name"]." ".$v["last_name"]."\n".$v["job_title"];
			$string = $v["first_name"]." ".$v["last_name"];
			if (strlen(trim($string)) > 1) {
				
				// first create an image
				//$image = imagecreate(300,50);
				$image = ImageCreateFromPNG ("images/blankname.png");
				// then allocate some colours
				$white = imagecolorallocate($image,255,255,255);
				$black = imagecolorallocate($image,0,0,0);
				
				// provide thepath to the font
				//$thefont = "fonts/tenacity.ttf";
				$thefont = "fonts/arialbd.ttf";
				
				// set the size in 96ppi points
				//$thesize = 10 * 0.75;
				$thesize = (imagesx($image)-7.5*strlen($string))/2;
				
				// fill the graphic with a white background
				// imagefill($image,0,0,$white);
				
				
				// get FreeType to render it
				//Imagettftext($image,$thesize,0,10,30,$white,$thefont,$string);
				ImageString($image,3,$thesize,9,$string,$black);
				
				// for good measure, make the background transparent
				imagecolortransparent($image, $white);
				
				// now, generate the image
				//header("Content-type: image/png");
				//imagegif($image,"image.gif");
				$filename = $path_images."name_images/".$v["last_name"].$v["first_name"]."_name.png";
				imagepng($image, $filename);
				imagedestroy($image);
				//echo "<br>filename= ".$filename."<br>";
			}
		}
		 //end modified for inhouseit
		*/	
			
			while (list($n1, $v1) = each($v)) {
				//echo "&nbsp; &nbsp; 3 $n1, $v1<BR>\n";
				if ($n1=="link_target") {
					if ($v1=="") { $v_cnt_empty++; $v1="NULL"; }
					$linkstr = $v1;
					$v1="'-r_start-$v1-r_end-'";
				}
				if ($v1=="") { $v_cnt_empty++; $v1="NULL"; } // images array IS EMPTY but ISNT
				elseif ($n1=="id") { $v1="NULL"; }
				
				// handle image upload, etc
				elseif ($n1=="image") { 
					if ($_REQUEST[$name."_".$n."_".image1]!="") { // pulldown image
						$v1 = "'".$path_images.$_REQUEST[$name."_".$n."_".image1]."'";
					}
					elseif ((isset($_FILES[$name."_".$n."_".image3])) && ($_FILES[$name."_".$n."_".image3]['error'] != 4) && ($_FILES[$name."_".$n."_".image3]['tmp_name'] != "none")) { // empty form submission still passes some usesless values
						$upload_errors = array( 1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.', 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form', 'The uploaded file was only partially uploaded', 'No file was uploaded');
						if (move_uploaded_file($_FILES[$name."_".$n."_".image3]['tmp_name'], $abs_path . $path_images . $_FILES[$name."_".$n."_".image3]['name'])) {
							$v1 = "'".$path_images.$_FILES[$name."_".$n."_".image3]['name']."'";
						}
						else {  
							$error[] = "Sorry, the file \"".$_FILES[$name."_".$n."_".image3]['name']."\" <B>failed to upload</B> properly. Please use your browsers back button and try again. Get help below if this problem persists.";
							$error[] = "Specific upload error: ".$upload_errors[$_FILES[$name."_".$n."_".image3]['error']];
							$v_cnt_empty++;
							$v1 = "NULL";
						}					
					}
					elseif ($_REQUEST[$name."_".$n."_".image2]!="") { // manually entered path
						$v1 = "'".$_REQUEST[$name."_".$n."_".image2]."'";
					}
					else {
						$v_cnt_empty++;
						$v1 = "NULL";
					}
				}
				elseif ($n1=="name_image") { 
					if ($_REQUEST[$name."_".$n."_"."1image1"]!="") { // pulldown image
						$v1 = "'".$path_images.$_REQUEST[$name."_".$n."_"."1image1"]."'";
					}
					elseif (($_FILES[$name."_".$n."_"."1image3"]['error'] != 4) && ($_FILES[$name."_".$n."_"."1image3"]['tmp_name'] != "none")) { // empty form submission still passes some usesless values
						$upload_errors = array( 1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.', 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form', 'The uploaded file was only partially uploaded', 'No file was uploaded');
						if (move_uploaded_file($_FILES[$name."_".$n."_"."1image3"]['tmp_name'], $abs_path . $path_images . $_FILES[$name."_".$n."_"."1image3"]['name'])) {
							$v1 = "'".$path_images.$_FILES[$name."_".$n."_"."1image3"]['name']."'";
						}
						else {  
							$error[] = "Sorry, the file \"".$_FILES[$name."_".$n."_"."1image3"]['name']."\" <B>failed to upload</B> properly. Please use your browsers back button and try again. Get help below if this problem persists.";
							$error[] = "Specific upload error: ".$upload_errors[$_FILES[$name."_".$n."_"."1image3"]['error']];
							$v_cnt_empty++;
							$v1 = "NULL";
						}					
					}
					elseif ($_REQUEST[$name."_".$n."_"."1image2"]!="") { // manually entered path
						$v1 = "'".$_REQUEST[$name."_".$n."_"."1image2"]."'";
					}
					else {
						$v_cnt_empty++;
						$v1 = "NULL";
					}
				}
				elseif ($n1=="thumbnail_off") { 
					if ($_REQUEST[$name."_".$n."_"."2image1"]!="") { // pulldown image
						$v1 = "'".$path_images.$_REQUEST[$name."_".$n."_"."2image1"]."'";
					}
					elseif (($_FILES[$name."_".$n."_"."2image3"]['error'] != 4) && ($_FILES[$name."_".$n."_"."2image3"]['tmp_name'] != "none")) { // empty form submission still passes some usesless values
						$upload_errors = array( 1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.', 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form', 'The uploaded file was only partially uploaded', 'No file was uploaded');
						if (move_uploaded_file($_FILES[$name."_".$n."_"."2image3"]['tmp_name'], $abs_path . $path_images . $_FILES[$name."_".$n."_"."2image3"]['name'])) {
							$v1 = "'".$path_images.$_FILES[$name."_".$n."_"."2image3"]['name']."'";
						}
						else {  
							$error[] = "Sorry, the file \"".$_FILES[$name."_".$n."_"."2image3"]['name']."\" <B>failed to upload</B> properly. Please use your browsers back button and try again. Get help below if this problem persists.";
							$error[] = "Specific upload error: ".$upload_errors[$_FILES[$name."_".$n."_"."2image3"]['error']];
							$v_cnt_empty++;
							$v1 = "NULL";
						}					
					}
					elseif ($_REQUEST[$name."_".$n."_"."2image2"]!="") { // manually entered path
						$v1 = "'".$_REQUEST[$name."_".$n."_"."2image2"]."'";
					}
					else {
						$v_cnt_empty++;
						$v1 = "NULL";
					}
				}
				elseif ($n1=="thumbnail_on") { 
					if ($_REQUEST[$name."_".$n."_"."3image1"]!="") { // pulldown image
						$v1 = "'".$path_images.$_REQUEST[$name."_".$n."_"."3image1"]."'";
					}
					elseif (($_FILES[$name."_".$n."_"."3image3"]['error'] != 4) && ($_FILES[$name."_".$n."_"."3image3"]['tmp_name'] != "none")) { // empty form submission still passes some usesless values
						$upload_errors = array( 1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.', 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form', 'The uploaded file was only partially uploaded', 'No file was uploaded');
						if (move_uploaded_file($_FILES[$name."_".$n."_"."3image3"]['tmp_name'], $abs_path . $path_images . $_FILES[$name."_".$n."_"."3image3"]['name'])) {
							$v1 = "'".$path_images.$_FILES[$name."_".$n."_"."3image3"]['name']."'";
						}
						else {  
							$error[] = "Sorry, the file \"".$_FILES[$name."_".$n."_"."3image3"]['name']."\" <B>failed to upload</B> properly. Please use your browsers back button and try again. Get help below if this problem persists.";
							$error[] = "Specific upload error: ".$upload_errors[$_FILES[$name."_".$n."_"."3image3"]['error']];
							$v_cnt_empty++;
							$v1 = "NULL";
						}					
					}
					elseif ($_REQUEST[$name."_".$n."_"."3image2"]!="") { // manually entered path
						$v1 = "'".$_REQUEST[$name."_".$n."_"."3image2"]."'";
					}
					else {
						$v_cnt_empty++;
						$v1 = "NULL";
					}
				}
				elseif ($n1=="pdf_file") { 
					if (($_REQUEST[$name."_".$n."_".article1]!="") && ($_REQUEST[$name."_".$n."_".article2]!="")) {
						if ($_REQUEST[$name."_".$n."_".article1]!="") { // pulldown article
							$v1 = "'".$path_articles.$_REQUEST[$name."_".$n."_".article1]."'";
						}
						elseif (($_FILES[$name."_".$n."_".article3]['error'] != 4) && ($_FILES[$name."_".$n."_".article3]['tmp_name'] != "none")) { // empty form submission still passes some usesless values
							$upload_errors = array( 1 => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.', 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the html form', 'The uploaded file was only partially uploaded', 'No file was uploaded');
							if (move_uploaded_file($_FILES[$name."_".$n."_".article3]['tmp_name'], $path_articles . $_FILES[$name."_".$n."_".article3]['name'])) {
								$v1 = "'".$path_articles.$_FILES[$name."_".$n."_".article3]['name']."'";
							}
							else {  
								$error[] = "Sorry, the file \"".$_FILES[$name."_".$n."_".article3]['name']."\" <B>failed to upload</B> properly. Please use your browsers back button and try again. Get help below if this problem persists.";
								$error[] = "Specific upload error: ".$upload_errors[$_FILES[$name."_".$n."_".article3]['error']];
								$v_cnt_empty++;
								$v1 = "NULL";
							}					
						}
						elseif ($_REQUEST[$name."_".$n."_".article2]!="") { // manually entered path
							$v1 = "'".$_REQUEST[$name."_".$n."_".article2]."'";
						}
						else {
							$v_cnt_empty++;
							$v1 = "NULL";
						}
					} else {
						$v_cnt_empty++;
						$v1 = "NULL";
					}
					$pdftolink = $v1;
				}
				else { $v1="'$v1'"; }
				//$col_str.= $n1.","; 
				$val_str.= $n1."=".$v1.","; 
			}
			if ($v_cnt != $v_cnt_empty) { // if ==, then whole set is empty and we ignore
			  $col_str = substr($col_str, 0, -1); // take last , off
			  $val_str = substr($val_str, 0, -1); // take last , off
			  if (strlen($pdf_to_link) > 0) {
			  	str_replace("'-r_start-$linkstr-r_end-'", "'$pdftolink'", $val_str);
			  }
			  else { str_replace("'-r_start-$linkstr-r_end-'", "'$linkstr'", $val_str); }
			  $pdf_to_link = "";
			  $linktochange = 0;
			  $linkstr = "";
			  $sqlee = "UPDATE ".$edit_ary[$name]['table_name']." SET ".$val_str." WHERE ".$edit_ary[$name]['display_type']['change_id_label']."=".$_REQUEST[$edit_ary[$name]['display_type']['change_id_label']];
			  /*
			  echo "sqlee=$sqlee<BR>\n";
			  echo "col_str=$col_str<BR>\n";
			  echo "val_str=$val_str<BR>\n";
			  echo "v_cnt=$v_cnt<BR>\n";
			  echo "v_cnt_empty=$v_cnt_empty<BR>\n";
			  */			  
			  $result4 = mysql_query($sqlee,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			  //echo "<br>$sqlee<br>"."Line: ".__LINE__;
			  if ($error) { $success = "(Some portions successfully updated.)"; }
			  else { $success = "Record successfully updated."; }
			}
		}
	}
}

// confirm delete
if ($confirm_delete) {
	$warning[] = "You are about to delete the following record. Are you sure?";
	$but_name = "delete";
	$but_value = "   Yes, DELETE now   ";
}

// do delete
if ($delete) {
	reset($edit_ary);
	while (list($name) = each($edit_ary)) { 
	  $delete_query3 = "DELETE FROM ".$edit_ary[$name]['table_name']." WHERE ".$edit_ary[$name]['display_type']['change_id_label']."=".$_REQUEST[$edit_ary[$name]['display_type']['change_id_label']]; 
	  $result3 = mysql_query($delete_query3,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
	}
	switch ($edit_page_title) {
		case "Facilities Directory":
			$delete_query3 = "DELETE FROM driving_directions WHERE office_id = ".$_REQUEST["id"]; 
			$result3 = mysql_query($delete_query3,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			$delete_query3 = "DELETE FROM hotels WHERE office_id = ".$_REQUEST["id"];
			$result3 = mysql_query($delete_query3,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			break;
		case "Office Directory":
			$delete_query3 = "DELETE FROM driving_directions WHERE office_id = ".$_REQUEST["id"]; 
			$result3 = mysql_query($delete_query3,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			$delete_query3 = "DELETE FROM hotels WHERE office_id = ".$_REQUEST["id"];
			$result3 = mysql_query($delete_query3,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			break;
		case "Implementation Coordinators":
		case "Representatives":
			$delete_query3 = "DELETE FROM repdb WHERE rep_id = ".$_REQUEST["id"];
			$result3 = mysql_query($delete_query3,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
			break;
		default:
			break;
	}
	$success = "Record successfully deleted.";
}

?>
				            <table align="center" width="100%">
				              <tr> 
				                <td align="center"><font class="bigger_even"><?php echo $this_page_title; ?></font></td>
				              </tr>
				              <tr> 
				                <td align="center"><img src="<?php print $path_sys_images;?>images/black.gif" width="100%" height="1"><BR></td>
				              </tr>
				              <tr> 
				                <td align="center">  
								  <?php if ($fatal_error) {  // show any FATAL errors ?>
				                  <font class="warning"><BR><?php echo $fatal_error; ?><BR><BR></font>
								  <?php } else {  // show page info ?>
								  <font class="slightly_bigger">"<?php echo $edit_page_title; ?>"</font><BR><font class="smaller_faded">(Last Modified: <?php echo $edit_page_mod; ?>)</font>
								  <?php } ?>
				                 </td>
				              </tr>
				              <tr> 
				                <td align="center"><img src="<?php print $path_sys_images;?>images/black.gif" width="100%" height="1"><BR></td>
				              </tr>
				              
				              <?php
				              if ($fatal_error == "") {
								// show any non-fatal errors and continue
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
								// show form fields almost always
								//<FORM method="post" action="echo $PHP_SELF" ENCTYPE="multipart/form-data">
								?>
								<FORM method="post" action="<?php echo $PHP_SELF; ?>" ENCTYPE="multipart/form-data">
								
								<tr>
								  <td>
									  <table border="0" width="100%" cellspacing="1" cellpadding="3" bgcolor="<?php echo $td_bg_color; ?>">
										<?php
										// output form
										reset($edit_ary);
										while (list($name, $sa) = each($edit_ary)) { 
										  form_field_content("$name","$sa[title]","$sa[table_name]","$sa[description]",$sa[display_type],$sa[blanks]);
										}
										if ($change) {
											switch ($edit_page_title) {
												case "Training Facilities Directory":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"drivingdb_edit.php?id=".$_REQUEST["id"]."\">Driving Directions</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"hoteldb_edit.php?id=".$_REQUEST["id"]."\">Nearest Hotels</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "Office Directory":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"drivingdb_edit.php?id=".$_REQUEST["id"]."\">Driving Directions</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"hoteldb_edit.php?id=".$_REQUEST["id"]."\">Nearest Hotels</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "Implementation Coordinators":
												case "Representatives":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"repdb_edit.php?rep_id=".$_REQUEST["id"]."\">Contact Area</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												default:
													break;
											}
										}	
										else { 
											switch ($edit_page_title) {
												case "1099 Help Desk":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"1099db_edit.php\">Contact List</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "Trust Accounting Help Desk":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"trustdb_edit.php\">Contact List</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "Caliber Media Group Help Desk":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"Caliber Media Groupdb_edit.php\">Contact List</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "Streamline Title":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"highlightsdb_edit.php\">Feature Highlights</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"integrationdb_edit.php\">Integration Options</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "Closing Tracker Title":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"featuresdb_edit.php\">Features</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"benefitsdb_edit.php\">Benefits</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"getting_starteddb_edit.php\">Getting Started</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "Streamline Escrow":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"st_es_highlightsdb_edit.php\">Feature Highlights</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"st_es_trustdb_edit.php\">Trust Accounting</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"st_es_integrationdb_edit.php\">Integration Options</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "DocNet":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"docnet_featuresdb_edit.php\">Features</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"docnet_trustdb_edit.php\">Trust Accounting</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"docnet_1099db_edit.php\">1099 Services</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "Closing Tracker Escrow":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"ct_es_featuresdb_edit.php\">Features</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"ct_es_benefitsdb_edit.php\">Benefits</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"ct_es_getting_starteddb_edit.php\">Getting Started</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "Trust Link Escrow":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"tl_es_featuresdb_edit.php\">Features</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"tl_es_benefitsdb_edit.php\">Benefits</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "FasTrax":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"ft_featuresdb_edit.php\">Features</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"ft_benefitsdb_edit.php\">Benefits</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"ft_webservicedb_edit.php\">Web Service</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "Vision":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"vision_featuresdb_edit.php\">Features</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"vision_integrationdb_edit.php\">Benefits</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "1099 Services":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"1099_featuresdb_edit.php\">Features</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"1099_benefitsdb_edit.php\">Benefits</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "Image Pro Title":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"imagepro_firstdb_edit.php\">First Bulleted List</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"imagepro_featuresdb_edit.php\">Features</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "Lockbox Solutions":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"lockbox_firstdb_edit.php\">First Bulleted List</A></font>\n";
													echo "&nbsp;&nbsp;\n";
													echo "<font class=\"smaller\"><A HREF=\"lockbox_bottomdb_edit.php\">Improve Your Bottom Line</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												case "Discount Club":
													echo "<tr>\n<td align=\"center\" colspan=\"2\">\n";
													echo "<font class=\"smaller\"><A HREF=\"discount_interesteddb_edit.php\">Bulleted List</A></font>\n";
													echo "</td>\n</tr>\n";
													break;
												default:
													break;
											}										
										} //blank
										?>
									  </table>
								  </td>
								</tr>
								<tr>
								  <td align="center">
								    <input type="hidden" name="page_id" value="<?php echo $page_id ?>"> 
									<input type="submit" name="<?php echo $but_name ?>" value="<?php echo $but_value ?>"> 
				                  <?php
				                  if ($change) { echo " or <input type=\"submit\" name=\"confirm_delete\" value=\"Delete\"> &nbsp;  &nbsp; "; }
				                  		if (($edit_page_title == "Staff Bios") || ($edit_page_title == "Our Team Bios")){ ?>
									&nbsp; <button type="reset">(reset)</button>
									&nbsp; <a href="<?php echo "http://www.inhouseit.com/ourteam/ourteambios.html"; ?>" target="Page_View">Preview page</a>.
								<?php 	} else { ?>
									&nbsp; <button type="reset">(reset)</button>
									&nbsp; <a href="<?php echo $result_ary["path"] ?>" target="Page_View">Preview page</a>.
								<?php 	} ?>
									<BR><BR></td>
								</tr>
								</form>
							<?php
							}
							?>
							  </table>
							<?php
							  

// footer include referenced in config
include($footer);

?>