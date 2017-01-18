<?php

// CONTENT Display Function, displays content using edit_ary
// Notes: 
// - The fact that you are reading this sets you apart from the crowd and underlines your intelligence
// - A wide range of effects can be easily achieved by combining multiple chunks and passing different <TABLE> and <TD> tags
// - Empty DB values are just ignored
// - In default display_type of column/row table format, DB column headers are automatically converted to display nicer: column_1 displays as "Column 1"
// - In title_paragraph, if a DB column is labeled "heading" it will automatically be bolded
// - Also in title_paragraph, if a DB column is labeled "image" it will automatically allow for an image to be uploaded and displayed

function content_display ($chunk, $table_code="<TABLE border=\"0\" cellspacing=\"1\">", $td_code="<TD>", $alt_td_code="") {
    global $_SESSION, $edit_ary, $die_mesg, $PHP_SELF, $db_conn, $db_name, $default_blanks, $crypt_pass, $s_time_offset, $c_time_zone, $error_ctd, $td_bg_error, $td_bg_color, $td_bg_color2, $abs_path, $remote_path, $path_images, $path_sys_images;
    if ($edit_ary[$chunk]['display_type']=="title_paragraph") {
		// get fields from table
		$tb_sql = "SELECT * FROM ".$edit_ary[$chunk]['table_name']." ORDER BY id"; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// do content as rows
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					if (!$t_cnt) { echo $table_code."\n"; $t_cnt_end = 1; } // conditional table container
					// set heading color
    				if (strlen($edit_ary[$chunk]['heading_color']) > 0) { 
						$h_color = $edit_ary[$chunk]['heading_color'];
					}
					else { $h_color = "#000066"; }
					while (list($key,$val) = each($result_ary)) {
						if ((($key != "id") && ($val != "")) && (($key != "filter") && ($val != "")) && (($key != "link_text") && ($val != "")) && (($key != "pdf_file") && ($val != ""))) { 
							echo " <TR>\n";
							if ($key == "heading") { echo "  ".$td_code."<B><font color=\"$h_color\">".$val."</font></B>"."</TD><TR><TD>&nbsp;</TD></TR>\n"; }
							elseif (($key=="link_target") && ($result_ary["link_text"] != "")) { echo "  ".$td_code."<B><font color=\"#000066\"><a href=\"".$val."\">".$result_ary["link_text"]."</a></font></B></TD>\n"; }
							elseif ($key == "image") { 
							  $img_name = $abs_path.$val;
							  $size = getimagesize ($img_name);
							  echo "  ".$td_code;
							  if ($result_ary["link_target"] != "") {
							  	echo "<a href=\"".$result_ary["link_target"]."\"><img src=\"".$remote_path.$val."\" $size[3] border=\"0\">"."</a></TD>\n";
							  }
							  else {
							  	echo "<img src=\"".$remote_path.$val."\" $size[3]>"."</TD>\n";
							  }
							}
							
							else { 
								$val = ereg_replace("(\r\n)", "<BR>", $val); // fix returns
								echo "  ".$td_code.$val."</TD>\n"; 
							}
							echo " </TR>\n";
						}
					} 
					$t_cnt++;
				}
			}
			if ($t_cnt_end) { echo "</TABLE>\n"; } // conditional table container
		}
		else { echo "<BR><CENTER>(no content found)</CENTER><BR>\n"; }
    }
    elseif ($edit_ary[$chunk]['display_type']=="title_paragraph_picture_right") { // wraps passed table_code (as beginning) & td_code (as end) values around value without any other formatting
		// get fields from table
		$tb_sql = "SELECT * FROM ".$edit_ary[$chunk]['table_name']." ORDER BY id"; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// set heading color
			$h_size = "";
			$h_color = "";
			if (is_array($edit_ary[$chunk]['heading_format'])){
    			if (strlen($edit_ary[$chunk]['heading_format']['heading_color']) > 0) { 
					$h_color = $edit_ary[$chunk]['heading_format']['heading_color'];
				}
				else { $h_color = "#000000"; }
    			if (strlen($edit_ary[$chunk]['heading_format']['heading_size']) > 0) { 
					$h_size = "size=\"".$edit_ary[$chunk]['heading_format']['heading_size']."\"";
				}
				else { $h_size = ""; }
			}
			else {
    			if (strlen($edit_ary[$chunk]['heading_color']) > 0) { 
					$h_color = $edit_ary[$chunk]['heading_color'];
				}
				else { $h_color = "#000000"; }
			}
			// do content as rows WITHOUT any table
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				echo "$table_code\n";
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					while (list($key,$val) = each($result_ary)) {
						if ((($key != "id") && ($val != "")) && (($key != "filter") && ($val != "")) && (($key != "ext") && ($val != "")) && (($key != "link_text") && ($val != ""))) { 
							if ($key == "heading") { echo "  <strong><font color=\"$h_color\" $h_size>".$val."</font></strong>"."<BR>\n"; }
							elseif ($key == "image") { 
								$img_name = $abs_path.$val;
								if (file_exists($img_name)) {
									$size = getimagesize ($img_name);
									if ($result_ary["link_target"] != "") {
										echo "      <a href=\"".$result_ary["link_target"]."\"><img src=\"".$remote_path.$val."\" $size[3] border=\"0\">"."</a>\n";
									}
									else {
										echo "      <img src=\"".$remote_path.$val."\" $size[3]>"."\n";
									}
								}
							}
							elseif ($key=="email") { echo "      <a href=\"mailto:".$val."\">$val</a>\n"; }
							elseif ($key=="phone") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "      $val";
								if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
								echo "\n";
							}
							elseif ($key=="website") { echo "      Website: <a href=\"".$val."\">$val</a>\n"; }
							elseif (($key=="link_target") && ($result_ary["link_text"] != "")) { echo "      <font color=\"#000066\"><a href=\"".$val."\">".$result_ary["link_text"]."</a></font><BR>\n"; }
							else { 
								$val = ereg_replace("(\r\n)", "", $val); // fix returns
								echo "      ".$val."\n"; 
							}
							
						}
					}
					echo "$td_code\n"; 
				}
			}
		}
		else { echo "<BR><CENTER>(no content found)</CENTER><BR>\n"; }
    }
    elseif ($edit_ary[$chunk]['display_type']=="javascript_title_paragraph_picture_right") { // wraps passed table_code (as beginning) & td_code (as end) values around value without any other formatting
		// get fields from table
		$tb_sql = "SELECT * FROM ".$edit_ary[$chunk]['table_name']." ORDER BY id"; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// set heading color
			$h_size = "";
			$h_color = "";
			if (is_array($edit_ary[$chunk]['heading_format'])){
    			if (strlen($edit_ary[$chunk]['heading_format']['heading_color']) > 0) { 
					$h_color = $edit_ary[$chunk]['heading_format']['heading_color'];
				}
				else { $h_color = "#000000"; }
    			if (strlen($edit_ary[$chunk]['heading_format']['heading_size']) > 0) { 
					$h_size = "size=\"".$edit_ary[$chunk]['heading_format']['heading_size']."\"";
				}
				else { $h_size = ""; }
			}
			else {
    			if (strlen($edit_ary[$chunk]['heading_color']) > 0) { 
					$h_color = $edit_ary[$chunk]['heading_color'];
				}
				else { $h_color = "#000000"; }
			}
			// do content as rows WITHOUT any table
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				echo "document.writeln('".addslashes(stripslashes($table_code))."')\n";
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					while (list($key,$val) = each($result_ary)) {
						if ((($key != "id") && ($val != "")) && (($key != "filter") && ($val != "")) && (($key != "ext") && ($val != "")) && (($key != "link_text") && ($val != ""))) { 
							if ($key == "heading") { echo "document.writeln(' <font color=\"#000000\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>".addslashes(stripslashes($val))."</strong></font><BR>');\n"; }
							elseif ($key == "image") { 
							  $img_name = $abs_path.$val;
							  $size = getimagesize ($img_name);
							  if ($result_ary["link_target"] != "") {
							  	echo "document.writeln('      <a href=\"".$result_ary["link_target"]."\"><img src=\"".$remote_path.$val."\" $size[3] border=\"0\"></a>');\n";
							  }
							  else {
							  	echo "document.writeln('      <img src=\"".$remote_path.$val."\" $size[3] align=\"right\">');\n";
							  }
							}
							elseif ($key=="email") { echo "document.writeln('      <a href=\"mailto:".$val."\">$val</a>');\n"; }
							elseif ($key=="phone") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "document.writeln('      $val";
								if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
								echo "');\n";
							}
							elseif ($key=="website") { echo "document.writeln('      Website: <a href=\"".$val."\">$val</a>');\n"; }
							elseif (($key=="link_target") && ($result_ary["link_text"] != "")) { echo "document.writeln('      <font color=\"#000066\"><a href=\"".$val."\">".$result_ary["link_text"]."</a></font><BR>');\n"; }
							else { 
								$val = ereg_replace("(\r\n)", "", $val); // fix returns
								echo "document.writeln('<font color=\"#000000\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">      ".addslashes(stripslashes($val))."</font>');"; 
							}
							
						}
					}
					echo "document.writeln('$td_code');\n"; 
				}
			}
		}
		else { echo "<BR><CENTER>(no content found)</CENTER><BR>\n"; }
    }
    elseif ($edit_ary[$chunk]['display_type']=="simple_wrapper") { // wraps passed table_code (as beginning) & td_code (as end) values around value without any other formatting
		// get fields from table
		$tb_sql = "SELECT * FROM ".$edit_ary[$chunk]['table_name']." ORDER BY id"; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// do content as rows WITHOUT any table
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					$align = "";
					if (strlen($result_ary["align"]) > 0 ) { $align = "align=\"".$result_ary["align"]."\""; }
					while (list($key,$val) = each($result_ary)) {
						if ((($key != "id") && ($val != "")) && (($key != "filter") && ($val != "")) && (($key != "ext") && ($val != "")) && (($key != "link_text") && ($val != "")) && (($key != "link_text") && ($val != ""))) { 
							echo "$table_code\n";
							if ($key == "image") { 
								$img_name = $abs_path.$val;
								if (file_exists($img_name)) {
									$size = getimagesize ($img_name);
									if ($result_ary["link_target"] != "") {
										echo "      <a href=\"".$result_ary["link_target"]."\"><img src=\"".$remote_path.$val."\" $size[3] border=\"0\">"."</a>\n";
									}
									else {
										echo "      <img src=\"".$remote_path.$val."\" $size[3]>"."\n";
									}
								}
							}
							elseif ($key=="email") { echo "      <a href=\"mailto:".$val."\">$val</a>\n"; }
							elseif ($key=="phone") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "      $val";
								if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
								echo "\n";
							}
							elseif ($key=="website") { echo "      Website: <a href=\"".$val."\">$val</a>\n"; }
							elseif (($key=="link_target") && ($result_ary["link_text"] != "")) { echo "      <font color=\"#000066\"><a href=\"".$val."\">".$result_ary["link_text"]."</a></font><BR>\n"; }
							else { 
								$val = ereg_replace("(\r\n)", "", $val); // fix returns
								echo "      ".$val."\n"; 
							}
							echo "$td_code\n";
						}
					} 
				}
			}
			if ($t_cnt_end) { echo "$td_code\n"; } // conditional container
		}
		else { echo "<BR><CENTER>(no content found)</CENTER><BR>\n"; }
    }
	elseif ($edit_ary[$chunk]['display_type']['name']=="bulleted_list") { // wraps passed table_code (as beginning) & td_code (as end) values around value without any other formatting
		// get fields from table
		$tb_sql = $edit_ary[$chunk]['display_type']['select_existing_query']; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// do content as rows WITHOUT any table
			echo "$table_code\n";
			$indent = 1;
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					if ($result_ary['indentation'] > $indent) {
						echo "$table_code\n";
						echo "<li>".$result_ary['content']."</li>\n";
						$indent++;
					}
					elseif ($result_ary['indentation'] < $indent) {
						$level_walk = $indent - $result_ary['indentation'];
						for ($i=0;$i<$level_walk;$i++) {
							echo "$td_code\n";
							$indent--;
						}
						echo "<li>".$result_ary['content']."</li>\n";
					}
					else { echo "<li>".$result_ary['content']."</li>\n"; }						
				}
			}
			if ($indent > 1) {
				for ($i=0;$i<$indent;$i++) { echo "$td_code\n"; }
			}
			else { echo "$td_code\n"; }
			if ($t_cnt_end) { echo "$td_code\n"; } // conditional container
		}
		else { echo "<BR><CENTER>(no content found)</CENTER><BR>\n"; }
    }
	elseif ($edit_ary[$chunk]['display_type']=="page_contact") { // wraps passed table_code (as beginning) & td_code (as end) values around value without any other formatting
		// get fields from table
		$tb_sql = "SELECT * FROM ".$edit_ary[$chunk]['table_name']." ORDER BY id"; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// do content as rows WITHOUT any table
			echo "$table_code\n";
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					switch ($edit_ary[$chunk]['title']) {
						case "FasTrax Contact Info":
							echo "<strong>If you would like additional information on this service 
             					 or availability in your area, please contact ".$result_ary["name"]." at ";
							$val = $result_ary["phone"];
							$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
							echo "$val";
							if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
              				echo " or<br><a href=\"mailto:".$result_ary["email"]."\">".$result_ary["email"]."</a>,</strong>\n";
							break;
						case "Lockbox Contact Info":
							echo "<strong>Call ".$result_ary["name"]." at ";
							$val = $result_ary["phone"];
							$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
							echo "$val";
							if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
              				echo " or <a href=\"mailto:".$result_ary["email"]."\">".$result_ary["email"]."</a> to learn how you can get started.</strong>\n";
							break;
						case "Discount Club Contact Info":
							// set heading color
							if (strlen($edit_ary[$chunk]['heading_color']) > 0) {
								$h_color = $edit_ary[$chunk]['heading_color'];
							}
							else { $h_color = "#000066"; }
							echo "<strong><font color=\"$h_color\" size=\"2\">".$result_ary["heading"]."</strong></font><BR>\n";
							echo "Call ".$result_ary["name"]." at ";
							$val = $result_ary["phone"];
							$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
							echo "<strong>$val";
							if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
              				echo "</strong> or <a href=\"mailto:".$result_ary["email"]."\">".$result_ary["email"]."</a> and ask about our<br>introductory membership fee!\n";
							break;
						default:
							break;
					}
				}						
			}
			echo "$td_code\n";
			if ($t_cnt_end) { echo "$td_code\n"; } // conditional container
		}
		else { echo "<BR><CENTER>(no content found)</CENTER><BR>\n"; }
    }
    elseif ($edit_ary[$chunk]['display_type']=="phone_hours") { // wraps passed table_code (as beginning) & td_code (as end) values around value without any other formatting
		// get fields from table
		$tb_sql = "SELECT * FROM ".$edit_ary[$chunk]['table_name']." ORDER BY id"; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// do content as rows WITHOUT any table
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					while (list($key,$val) = each($result_ary)) {
						if ((($key != "id") && ($val != "")) && (($key != "filter") && ($val != "")) && (($key != "ext") && ($val != "")) && (($key != "link_text") && ($val != ""))) { 
							echo "$table_code\n";
							if ($key == "image") { 
								$img_name = $abs_path.$val;
								if (file_exists($img_name)) {
									$size = getimagesize ($img_name);
									if ($result_ary["link_target"] != "") {
										echo "      <a href=\"".$result_ary["link_target"]."\"><img src=\"".$remote_path.$val."\" $size[3] border=\"0\">"."</a>\n";
									}
									else {
										echo "      <img src=\"".$remote_path.$val."\" $size[3]>"."\n";
									}
								}
							}
							elseif ($key=="email") { echo "      <b>E-mail:</b> <a href=\"mailto:".$val."\">$val</a>\n"; }
							elseif ($key=="phone") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "      <b>Phone:</b> $val";
								if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
								echo "\n";
							}
							elseif ($key=="cell") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "      <b>Cell:</b> $val";
								echo "\n";
							}
							elseif ($key=="fax") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "      <b>Fax:</b> $val";
								echo "\n";
							}
							elseif ($key=="hours1") { 
								echo "<BR>      <b>Hours:</b><BR> $val";
								echo "\n";
							}
							elseif ($key=="website") { echo "      <b>Website:</b> <a href=\"".$val."\">$val</a>\n"; }
							elseif (($key=="link_target") && ($result_ary["link_text"] != "")) { echo "      <font color=\"#000066\"><a href=\"".$val."\">".$result_ary["link_text"]."</a></font><BR>\n"; }
							else { 
								$val = ereg_replace("(\r\n)", "", $val); // fix returns
								echo "      ".$val."\n"; 
							}
							echo "$td_code\n";
						}
					} 
				}
			}
			if ($t_cnt_end) { echo "$td_code\n"; } // conditional container
		}
		else { echo "<BR><CENTER>(no content found)</CENTER><BR>\n"; }
    }
    elseif ($edit_ary[$chunk]['display_type']['name']=="reps_rows") {		
		// get fields from table
		$tb_sql = $edit_ary[$chunk]['rep_query'];
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// do content as rows WITHOUT any table
			echo "<p><br>The Sales Representative for your area is:</p>\n";
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					echo "$table_code\n";
					echo "<TR><TD width=\"164\" valign=\"top\">";
					if (strlen($result_ary["image"]) > 0) { 
						$val = $result_ary["image"];	 
						$img_name = $abs_path.$val;
						if (file_exists($img_name)) {
							$size = getimagesize ($img_name);
							if ($result_ary["link_target"] != "") {
								echo "      <a href=\"".$result_ary["link_target"]."\"><img src=\"".$remote_path.$val."\" $size[3] border=\"0\">"."</a>\n";
							}
							else {
								echo "      <img src=\"".$remote_path.$val."\" $size[3]>"."\n";
							}
						} else {
							echo "<img src=\"".$remote_path.$path_images."nophoto.gif\" width=\"142\" height=\"200\">";
						}
					} else {
						echo "<img src=\"".$remote_path.$path_images."nophoto.gif\" width=\"142\" height=\"200\">";
					}
					echo "</TD>\n";
					echo "$td_code\n<p>";
					reset($result_ary);
					while (list($key,$val) = each($result_ary)) {
						if ((($key != "id") && ($val != "")) && (($key != "image") && ($val != "")) && (($key != "filter") && ($val != "")) && (($key != "ext") && ($val != "")) && (($key != "link_text") && ($val != ""))) { 		
							if ($key=="heading") { echo "<b>$val</b></p><p>"; }
							elseif ($key=="email") { echo "      <b>E-mail:</b> <a href=\"mailto:".$val."\">$val</a>\n"; }
							elseif ($key=="phone") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "      <b>Phone:</b> $val";
								if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
								echo "\n";
							}
							elseif ($key=="cell") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "      <b>Cell:</b> $val";
								echo "\n";
							}
							elseif ($key=="fax") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "      <b>Fax:</b> $val";
								echo "\n";
							}
							elseif ($key=="website") { echo "      <b>Website:</b> <a href=\"".$val."\">$val</a>\n"; }
							elseif (($key=="link_target") && ($result_ary["link_text"] != "")) { echo "      <font color=\"#000066\"><a href=\"".$val."\">".$result_ary["link_text"]."</a></font><BR>\n"; }
							else { 
								$val = ereg_replace("(\r\n)", "", $val); // fix returns
								echo "      ".$val."\n"; 
							}
							echo "<br>";
						}			
					}
					echo "</p></TD></TR>\n<TR><TD>&nbsp;</TD><TD>&nbsp;</TD></TR>\n";
					echo "</TABLE>\n";
				}
			}
		}
		else { echo "<BR><CENTER>(no content found)</CENTER><BR>\n"; }
    }
    elseif ($edit_ary[$chunk]['display_type']['name']=="reps_rows2") {		
		// get fields from table
		$tb_sql = $edit_ary[$chunk]['rep_query'];
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// do content as rows in table
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					echo "$table_code\n";
					echo '<tr>';
					echo "$td_code\n<p>";
					reset($result_ary);
					while (list($key,$val) = each($result_ary)) {
						if ((($key != "id") && ($val != "")) && (($key != "image") && ($val != "")) && (($key != "filter") && ($val != "")) && (($key != "ext") && ($val != "")) && (($key != "link_text") && ($val != ""))) { 		
							if ($key=="heading") { echo "<b>$val</b></p>"; }
							elseif ($key=="email") { echo "      <br>\nE-mail: <a href=\"mailto:".$val."\">$val</a>"; }
							elseif ($key=="phone") { 
								$val = substr($val,0,3).".".substr($val,3,3).".".substr($val,6,4);
								echo "      <br>\nPhone: $val";
								if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
							}
							elseif ($key=="cell") { 
								$val = substr($val,0,3).".".substr($val,3,3).".".substr($val,6,4);
								echo "      <br>\nCell: $val";
							}
							elseif ($key=="fax") { 
								$val = substr($val,0,3).".".substr($val,3,3).".".substr($val,6,4);
								echo "      <br>\nFax: $val";
							}
							elseif ($key=="website") { echo "      <br>\nWebsite: <a href=\"".$val."\">$val</a>"; }
							elseif (($key=="link_target") && ($result_ary["link_text"] != "")) { echo "      <font color=\"#000066\"><a href=\"".$val."\">".$result_ary["link_text"]."</a></font><BR>\n"; }
							else { 
								$val = ereg_replace("(\r\n)", "", $val); // fix returns
								echo "      <br>\n".$val; 
							}
						}			
					}
					echo "</p></td>\n<td width=\"194\" align=\"right\" valign=\"top\">";
					if (strlen($result_ary["image"]) > 0) { 
						$val = $result_ary["image"];	 
						$img_name = $abs_path.$val;
						if (file_exists($img_name)) {
							$size = getimagesize ($img_name);
							if ($result_ary["link_target"] != "") {
								echo "      <a href=\"".$result_ary["link_target"]."\"><img src=\"".$remote_path.$val."\" $size[3] border=\"0\">"."</a>\n";
							}
							else {
								echo "      <img src=\"".$remote_path.$val."\" $size[3]>"."\n";
							}
						} else {
							echo "<img src=\"".$remote_path.$path_images."nophoto.gif\" width=\"142\" height=\"200\">";
						}
					} else {
						echo "<img src=\"".$remote_path.$path_images."nophoto.gif\" width=\"142\" height=\"200\">";
					}
					echo "</td>\n";
					
					echo "</tr>\n";
					echo "</table>\n";
				}
			}
		}
		else { echo "<BR><CENTER>(no content found)</CENTER><BR>\n"; }
    }
    elseif ($edit_ary[$chunk]['display_type']['name']=="javascript_staff_bio") {		
		// get fields from table
		$tb_sql = $edit_ary[$chunk]['rep_query'];
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// do content as rows WITHOUT any table
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					echo "document.writeln('<TR>');\n";
					echo "document.writeln('$td_code');";
					if (strlen($result_ary["image"]) > 0) { 
						$val = $result_ary["image"];	 
						$img_name = $abs_path.$val;
						//$img_name = $val;
						$size = getimagesize ($img_name);
						if ($result_ary["link_target"] != "") {
							echo "document.writeln('<a href=\"".$result_ary["link_target"]."\"><img src=\"$remote_path".$val."\" $size[3] border=\"0\">"."</a></TD>');\n";
						}
						else {
							echo "document.writeln('<img src=\"".$remote_path.$val."\" $size[3]></TD>');\n";
						}
					}
					echo "document.writeln('$td_code".$table_code."');\n";
					echo "document.writeln('<TR>');\n";
					echo "document.writeln('<TD><font color=\"#000000\" size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\"><strong>');\n";
					echo "document.writeln('".$result_ary["first_name"]." ".$result_ary["last_name"]."</font></TD>');\n";
					echo "document.writeln('</TR></TABLE></TD></TR>');\n";
					echo "document.writeln('<TR>');\n";
					echo "document.writeln('<TD colspan=\"2\">$table_code');\n";
				    echo "document.writeln('<TR>');\n";
				    echo "document.writeln('<TD valign=\"top\">');\n";
				    echo "document.writeln('<font size=\"2\" face=\"Verdana, Arial, Helvetica, sans-serif\">');\n";				
					reset($result_ary);
					while (list($key,$val) = each($result_ary)) {
						if ((($key != "id") && ($val != "")) && (($key != "image") && ($val != "")) && (($key != "name_image") && ($val != "")) && (($key != "thumbnail_on") && ($val != "")) && (($key != "thumbnail_off") && ($val != "")) && (($key != "filter") && ($val != "")) && (($key != "first_name") && ($val != "")) && (($key != "last_name") && ($val != "")) && (($key != "ext") && ($val != "")) && (($key != "link_text") && ($val != ""))) { 		
							$val = ereg_replace("(\r\n)", "", $val); // fix returns
							if ($key=="job_title") { echo "document.writeln('<strong>Job Title<br></strong>".addslashes(stripslashes($val))."<br><br>');\n"; }
							elseif ($key=="education") { echo "document.writeln('<strong>Education<br></strong>".addslashes(stripslashes($val))."<br><br>');\n"; }
							elseif ($key=="credentials") { echo "document.writeln('<strong>Credentials<br></strong>".addslashes(stripslashes($val))."<br><br>');\n"; }
							elseif ($key=="question_1") { echo "document.writeln('<strong>What do you enjoy most about serving inhouseIT clients?<br></strong>".addslashes(stripslashes($val))."<br><br>');\n"; }
							elseif ($key=="question_2") { echo "document.writeln('<strong>How do you like to have fun?<br></strong>".addslashes(stripslashes($val))."<br>');\n"; }
							elseif ($key=="email") { echo "document.writeln('<strong>E-mail:</strong><br><a href=\"mailto:".$val."\">$val</a><br>');\n"; }
							elseif ($key=="phone") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "document.writeln('<strong>Phone:</strong><br>$val";
								if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
								echo "<br>');\n";
							}
							elseif ($key=="cell") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "document.writeln('<strong>Cell:</strong><br>$val";
								if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
								echo "<br>');\n";
							}
							elseif ($key=="fax") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "document.writeln('<strong>Fax:</strong><br>$val";
								if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
								echo "<br>');\n";
							}
							elseif ($key=="website") { echo "document.writeln('<strong>Website:</strong><br><a href=\"".$val."\">$val</a><br>');\n"; }
							elseif (($key=="link_target") && ($result_ary["link_text"] != "")) { echo "document.writeln('<font color=\"#000066\"><a href=\"".$val."\">".$result_ary["link_text"]."</a></font><BR>');\n"; }
							else { 
								$val = ereg_replace("(\r\n)", "", $val); // fix returns
								echo "document.writeln('      ".addslashes(stripslashes($val))."');\n"; 
							}
						}			
					}
					echo "document.writeln('</font></TD></TR></TABLE></TD></TR>');\n";
				}
			}
		}
		else { echo "<BR><CENTER>(no content found)</CENTER><BR>\n"; }
    }
    elseif ($edit_ary[$chunk]['display_type']['name']=="directory_data_rows") {
		// set heading color
    	if (strlen($edit_ary[$chunk]['display_type']['heading_color']) > 0) { 
			$h_color = $edit_ary[$chunk]['display_type']['heading_color'];
		}
		else { $h_color = "#000066"; }
    	// get fields from table
		if ($edit_ary[$chunk]['display_type']['display_sort_by_field']!="") { $sort_by = $edit_ary[$chunk]['display_type']['display_sort_by_field']; } // sort by array value if set
		else { $sort_by = "id"; }
		$tb_sql = "SELECT * FROM ".$edit_ary[$chunk]['table_name']." ORDER BY $sort_by"; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// do content as rows WITHOUT any table
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					if (!$t_cnt) { echo "\n      <p>\n"; $t_cnt_end = 1; } // conditional container
					$poi = "";
					while (list($key,$val) = each($result_ary)) {
						if ((($key != "id") && ($val != "")) && (($key != "filter") && ($val != "")) && (($key != "alternate_airports") && ($val != "")) && (($key != "closest_airport") && ($val != "")) && (($key != "ext") && ($val != "")) && (($key != "link_text") && ($val != ""))) { 
							if ($key == "heading") { echo "      <B><font color=\"$h_color\">".$val."</font></B>"."<BR>\n"; }
							elseif ($key == "image") { 
								$img_name = $abs_path.$val;
								if (file_exists($img_name)) {
									$size = getimagesize ($img_name);
									if ($result_ary["link_target"] != "") {
										echo "      <a href=\"".$result_ary["link_target"]."\"><img src=\"".$remote_path.$val."\" $size[3] border=\"0\">"."</a>\n";
									}
									else {
										echo "      <img src=\"".$remote_path.$val."\" $size[3]>"."\n";
									}
								}
							}
							elseif ($key=="email") { echo "      Email: <a href=\"mailto:".$val."\">$val</a><BR>\n"; }
							elseif ($key=="phone") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "      Phone: $val";
								if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
								echo "<BR>\n";
							}
							elseif ($key=="fax") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "      Fax: $val";
								echo "<BR>\n";
							}
							elseif ($key=="website") { echo "      Website: <a href=\"".$val."\">$val</a><BR>\n"; }
							elseif ($key=="places_of_interest_link") { $poi = $val; }
							else { 
								$val = ereg_replace("(\r\n)", "<BR>", $val); // fix returns
								echo "      ".$val."<BR>\n"; 
							}
						}
					} 
					$t_cnt++;
					echo "<a href=\"offices.php?office=".$result_ary["id"]."\">Driving directions</a>\n";
					echo "&nbsp; |&nbsp; <a href=\"offices.php?office=".$result_ary["id"]."#airports\">Airports</a>\n";
					echo "&nbsp; |&nbsp; <a href=\"offices.php?office=".$result_ary["id"]."#hotels\">Hotels</a>\n";
					if (strlen($poi) > 0) {	echo "&nbsp; |&nbsp; <a href=\"$poi\" target=\"_blank\">Places of Interest</a> \n"; }
					echo "<BR>\n";
					$poi = "";
					echo "      <BR>\n";
				}
			}
			if ($t_cnt_end) { echo "      </p>"; } // conditional container
		}
		else { echo "<BR><CENTER>(no content found)</CENTER><BR>\n"; }
    }
    elseif ($edit_ary[$chunk]['display_type']['name']=="directory_summary_data_rows") {
		// set heading color
    	if (strlen($edit_ary[$chunk]['display_type']['heading_color']) > 0) { 
			$h_color = $edit_ary[$chunk]['display_type']['heading_color'];
		}
		else { $h_color = "#000066"; }
    	// get fields from table
		if ($edit_ary[$chunk]['display_type']['display_sort_by_field']!="") { $sort_by = $edit_ary[$chunk]['display_type']['display_sort_by_field']; } // sort by array value if set
		else { $sort_by = "id"; }
		$tb_sql = "SELECT * FROM ".$edit_ary[$chunk]['table_name']." ORDER BY $sort_by"; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// do content as rows in table
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					if (!$t_cnt) { echo "\n      <p>\n"; $t_cnt_end = 1; } // conditional container
					echo "<tr bgcolor=\"#EDEDED\">";
					echo $td_code.$result_ary["heading"]."</td>\n";
					$t_cnt++;
					echo "<td width=\"110\" align=\"center\" class=\"text1\"><a href=\"javascript:getFacility('{$result_ary["id"]}');\">{$edit_ary[$chunk]['display_type']['link_text']}</a></td>\n";
					echo "</tr>\n";
				}
			}
			if ($t_cnt_end) { echo "      </p>"; } // conditional container
		}
		else { echo "<tr><td colspan=\"2\" align=\"center\" class=\"text1\"><BR><CENTER>(no content found)</CENTER><BR></td>\n"; }
    }
    elseif ($edit_ary[$chunk]['display_type']['name']=="directory_summary_ext_link_data_rows") {
		// set heading color
    	if (strlen($edit_ary[$chunk]['display_type']['heading_color']) > 0) { 
			$h_color = $edit_ary[$chunk]['display_type']['heading_color'];
		}
		else { $h_color = "#000066"; }
    	// get fields from table
		if ($edit_ary[$chunk]['display_type']['display_sort_by_field']!="") { $sort_by = $edit_ary[$chunk]['display_type']['display_sort_by_field']; } // sort by array value if set
		else { $sort_by = "id"; }
		$tb_sql = "SELECT * FROM ".$edit_ary[$chunk]['table_name']." ORDER BY $sort_by"; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// do content as rows in table
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					if (!$t_cnt) { echo "\n      <p>\n"; $t_cnt_end = 1; } // conditional container
					echo "<tr bgcolor=\"#EDEDED\">";
					echo $td_code.$result_ary["heading"]."</td>\n";
					$t_cnt++;
					echo "<td width=\"99\" align=\"center\" class=\"text1\"><img src=\"".$path_sys_images."arrow2.gif\" width=\"4\" height=\"17\" align=\"absmiddle\"><a href=\"{$result_ary["link"]}\" target=\"_blank\">{$edit_ary[$chunk]['display_type']['link_text']}</a></td>\n";
					echo "</tr>\n";
				}
			}
			if ($t_cnt_end) { echo "      </p>"; } // conditional container
		}
		else { echo "<tr><td colspan=\"2\" align=\"center\" class=\"text1\"><BR><CENTER>(no content found)</CENTER><BR></td>\n"; }
    }
    elseif ($edit_ary[$chunk]['display_type']['name']=="job_rows") {
		// set heading color
    	if (strlen($edit_ary[$chunk]['display_type']['heading_color']) > 0) { 
			$h_color = $edit_ary[$chunk]['display_type']['heading_color'];
		}
		else { $h_color = "#000066"; }
    	// get fields from table
		if ($edit_ary[$chunk]['display_type']['display_sort_by_field']!="") { $sort_by = $edit_ary[$chunk]['display_type']['display_sort_by_field']; } // sort by array value if set
		else { $sort_by = "id"; }
		$tb_sql = "SELECT id,position,city,st FROM ".$edit_ary[$chunk]['table_name']." ORDER BY $sort_by"; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// do content as rows WITHOUT any table
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					if (!$t_cnt) { echo "\n      <p>\n"; $t_cnt_end = 1; } // conditional container
					while (list($key,$val) = each($result_ary)) {
						if ((($key != "id") && ($val != "")) && (($key != "filter") && ($val != "")) && (($key != "ext") && ($val != "")) && (($key != "country") && ($val != "")) && (($key != "st") && ($val != "")) && (($key != "link_text") && ($val != ""))) { 
							if ($key == "position") { echo "      <B><font color=\"$h_color\">".$val."</font></B>"."<BR>\n"; }
							elseif ($key == "image") { 
								$img_name = $abs_path.$val;
								if (file_exists($img_name)) {
									$size = getimagesize ($img_name);
									if ($result_ary["link_target"] != "") {
										echo "      <a href=\"".$result_ary["link_target"]."\"><img src=\"".$remote_path.$val."\" $size[3] border=\"0\">"."</a>\n";
									}
									else {
										echo "      <img src=\"".$remote_path.$val."\" $size[3]>"."\n";
									}
								}
							}
							elseif ($key=="city") { 
								echo "      $val";
								if (strlen($result_ary["st"]) > 0) { echo ", ".$result_ary["st"]; }
								if (strlen($result_ary["country"]) > 0) { echo "<BR>".$result_ary["country"]; }
								echo "<BR>\n"; 
							}
							elseif ($key=="email") { echo "      <a href=\"mailto:".$val."\">$val</a><BR>\n"; }
							elseif ($key=="phone") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "      $val";
								if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
								echo "<BR>\n";
							}
							elseif ($key=="website") { echo "      Website: <a href=\"".$val."\">$val</a><BR>\n"; }
							elseif (($key=="link_target") && ($result_ary["link_text"] != "")) { echo "      <B><font color=\"#000066\"><a href=\"".$val."\">".$result_ary["link_text"]."</a></font></B><BR>\n"; }
							else { 
								$val = ereg_replace("(\r\n)", "<BR>", $val); // fix returns
								echo "      ".$val."<BR>\n"; 
							}
						}
					} 
					$t_cnt++;
					echo "      <font color=\"#000066\"><a href=\"employment_cm.php?id=".$result_ary["id"]."\">Details</a></font><BR>\n";
					echo "      <BR>\n";
				}
			}
			if ($t_cnt_end) { echo "      </p>"; } // conditional container
		}
		else { echo "<BR><CENTER><b>Coming Soon!</b></CENTER><BR>\n"; }
    }
    elseif ($edit_ary[$chunk]['display_type']['name']=="article_rows") {
		// set heading color
    	if (strlen($edit_ary[$chunk]['display_type']['heading_color']) > 0) { 
			$h_color = $edit_ary[$chunk]['display_type']['heading_color'];
		}
		else { $h_color = "#000066"; }
    	// get fields from table
		if ($edit_ary[$chunk]['display_type']['display_sort_by_field']!="") { $sort_by = $edit_ary[$chunk]['display_type']['display_sort_by_field']; } // sort by array value if set
		else { $sort_by = "id"; }
		$tb_sql = "SELECT id,title,pdf_file,date FROM ".$edit_ary[$chunk]['table_name']." ORDER BY $sort_by"; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// do content as rows WITHOUT any table
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					if (!$t_cnt) { echo "\n      <p>\n"; $t_cnt_end = 1; } // conditional container
					while (list($key,$val) = each($result_ary)) {
						if ((($key != "id") && ($val != "")) && (($key != "filter") && ($val != "")) && (($key != "ext") && ($val != "")) && (($key != "pdf_file") && ($val != ""))) { 
							if ($key == "title") { 
								echo "      <B><font color=\"$h_color\"><a href=\"".$result_ary["pdf_file"]."\">".$$val."</a></font></B>"."<BR>\n"; 
							}
							elseif ($key == "image") { 
								$img_name = $abs_path.$val;
								if (file_exists($img_name)) {
									$size = getimagesize ($img_name);
									if ($result_ary["link_target"] != "") {
										echo "      <a href=\"".$result_ary["link_target"]."\"><img src=\"".$remote_path.$val."\" $size[3] border=\"0\">"."</a>\n";
									}
									else {
										echo "      <img src=\"".$remote_path.$val."\" $size[3]>"."\n";
									}
								}
							}
							elseif ($key=="email") { echo "      <a href=\"mailto:".$val."\">$val</a><BR>\n"; }
							elseif ($key=="phone") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "      $val";
								if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
								echo "<BR>\n";
							}
							elseif ($key=="date") { echo "      Date: ".date("m-d-Y", $val)."<BR>\n"; }
							elseif ($key=="website") { echo "      Website: <a href=\"".$val."\">$val</a><BR>\n"; }
							else { 
								$val = ereg_replace("(\r\n)", "<BR>", $val); // fix returns
								echo "      ".$val."<BR>\n"; 
							}
						}
					} 
					$t_cnt++;
					echo "      <font color=\"#000066\"><a href=\"employment_cm.php?id=".$result_ary["id"]."\">Details</a></font><BR>\n";
					echo "      <BR>\n";
				}
			}
			if ($t_cnt_end) { echo "      </p>"; } // conditional container
		}
		else { echo "<BR><CENTER>(no content found)</CENTER><BR>\n"; }
    }
    elseif (($edit_ary[$chunk]['display_type']=="data_list") || ($edit_ary[$chunk]['display_type']['name']=="data_list")) {
		if (is_array($edit_ary[$chunk]['display_type'])){
    		// set heading color
    		if (strlen($edit_ary[$chunk]['display_type']['heading_color']) > 0) { 
				$h_color = $edit_ary[$chunk]['display_type']['heading_color'];
			}
			else { $h_color = "#000066"; }
    		if ($edit_ary[$chunk]['display_type']['display_sort_by_field']!="") { $sort_by = $edit_ary[$chunk]['display_type']['display_sort_by_field']; } // sort by array value if set
			else { $sort_by = "id"; }
		}
		else {
			// set heading color
    		if (strlen($edit_ary[$chunk]['heading_color']) > 0) { 
				$h_color = $edit_ary[$chunk]['heading_color'];
			}
			else { $h_color = "#000066"; }
    		if ($edit_ary[$chunk]['display_sort_by_field']!="") { $sort_by = $edit_ary[$chunk]['display_sort_by_field']; } // sort by array value if set
			else { $sort_by = "id"; }
		}			
		// get fields from table
		
		$tb_sql = "SELECT * FROM ".$edit_ary[$chunk]['table_name']." ORDER BY $sort_by"; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			$t_cnt = "";
			// do content as rows WITHOUT any table
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					if (!$t_cnt) { echo "\n      <p>\n"; $t_cnt_end = 1; } // conditional container
					while (list($key,$val) = each($result_ary)) {
						if ((($key != "id") && ($val != "")) && (($key != "filter") && ($val != "")) && (($key != "ext") && ($val != "")) && (($key != "link_text") && ($val != ""))) { 
							if ($key == "heading") { echo "      <B><font color=\"$h_color\">".$val."</font></B>"."<BR>\n"; }
							elseif ($key == "image") { 
								$img_name = $abs_path.$val;
								if (file_exists($img_name)) {
									$size = getimagesize ($img_name);
									if ($result_ary["link_target"] != "") {
										echo "      <a href=\"".$result_ary["link_target"]."\"><img src=\"".$remote_path.$val."\" $size[3] border=\"0\">"."</a>\n";
									}
									else {
										echo "      <img src=\"".$remote_path.$val."\" $size[3]>"."\n";
									}
								}
							}
							elseif ($key=="email") { echo "      <a href=\"mailto:".$val."\">$val</a><BR>\n"; }
							elseif ($key=="phone") { 
								$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
								echo "      $val";
								if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
								echo "<BR>\n";
							}
							elseif ($key=="website") { echo "      Website: <a href=\"".$val."\">$val</a><BR>\n"; }
							elseif (($key=="link_target") && ($result_ary["link_text"] != "")) { echo "      <B><font color=\"#000066\"><a href=\"".$val."\">".$result_ary["link_text"]."</a></font></B><BR>\n"; }
							else { 
								$val = ereg_replace("(\r\n)", "<BR>", $val); // fix returns
								echo "      ".$val."<BR>\n"; 
							}
						}
					} 
					$t_cnt++;
					echo "      <BR>\n";
				}
			}
			if ($t_cnt_end) { echo "      </p>"; } // conditional container
		}
		else { echo "<BR><CENTER>(no content found)</CENTER><BR>\n"; }
    }
    elseif (($edit_ary[$chunk]['display_type']=="data_rows") || ($edit_ary[$chunk]['display_type']['name']=="data_rows")) {
		if (is_array($edit_ary[$chunk]['display_type'])){
    		// set heading color
    		if (strlen($edit_ary[$chunk]['display_type']['heading_color']) > 0) { 
				$h_color = $edit_ary[$chunk]['display_type']['heading_color'];
			}
			else { $h_color = "#000066"; }
    		if ($edit_ary[$chunk]['display_type']['display_sort_by_field']!="") { $sort_by = $edit_ary[$chunk]['display_type']['display_sort_by_field']; } // sort by array value if set
			else { $sort_by = "id"; }
		}
		else {
			// set heading color
    		if (strlen($edit_ary[$chunk]['heading_color']) > 0) { 
				$h_color = $edit_ary[$chunk]['heading_color'];
			}
			else { $h_color = "#000066"; }
    		if ($edit_ary[$chunk]['display_sort_by_field']!="") { $sort_by = $edit_ary[$chunk]['display_sort_by_field']; } // sort by array value if set
			else { $sort_by = "id"; }
		}			
		// get fields from table
		
		$tb_sql = "SELECT * FROM ".$edit_ary[$chunk]['table_name']." ORDER BY $sort_by"; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			// check for any filtering to see if show anything / header row
			while ($result_ary2 = mysql_fetch_assoc($tb_result)) {
				if (($result_ary2['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { 
					$show_header_row = 1;
				}
			}
			
			if ($show_header_row) {
				echo $table_code."\n";
				// first do header row
				echo " <TR bgcolor=\"#EBEAC1\">\n";
				$tb_result2 = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
				if (is_array($alt_td_code)) {
					$n = 0;
					while ($fields = mysql_fetch_field($tb_result2)) {
						if ($fields->name != "id") { 
							$field_name_display = str_replace ("_"," ",$fields->name);
							$field_name_display = ucwords($field_name_display);
							echo "  ".$alt_td_code[$n]."<B>".$field_name_display."</B></TD>\n";
							$n++;
						}
					}
					echo " </TR>\n";
					// do content
					while ($result_ary = mysql_fetch_assoc($tb_result2)) {
						if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
							echo " <TR>\n";
							$n = 0;
							while (list($key,$val) = each($result_ary)) {
								if ((($key != "id") && ($val != "")) && (($key != "filter") && ($val != ""))) {  
									$val = ereg_replace("(\r\n)", "<BR>", $val); // fix returns
									echo "  ".$alt_td_code[$n].$val."</TD>\n"; 
									$n++;
								}
							} 
							echo " </TR>\n";
						}
					}
					echo "</TABLE>\n";
				}
				else{
					// do header row
					while ($fields = mysql_fetch_field($tb_result2)) {
						if ($fields->name != "id") { 
							$field_name_display = str_replace ("_"," ",$fields->name);
							$field_name_display = ucwords($field_name_display);
							echo "  ".$td_code."<B>".$field_name_display."</B></TD>\n"; 
						}
					}
					echo " </TR>\n";
					// do content
					while ($result_ary = mysql_fetch_assoc($tb_result2)) {
						if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
							echo " <TR>\n";
							while (list($key,$val) = each($result_ary)) {
								if ((($key != "id") && ($val != "")) && (($key != "filter") && ($val != "")) && (($key != "ext") && ($val != "")) && (($key != "link_text") && ($val != ""))) {
									if ($key == "heading") { echo "      <B><font color=\"$h_color\">".$val."</font></B>"."<BR>\n"; }
									elseif ($key == "image") { 
										$img_name = $abs_path.$val;
										if (file_exists($img_name)) {
											$size = getimagesize ($img_name);
											if ($result_ary["link_target"] != "") {
												echo "      <a href=\"".$result_ary["link_target"]."\"><img src=\"".$remote_path.$val."\" $size[3] border=\"0\">"."</a>\n";
											}
											else {
												echo "      <img src=\"".$remote_path.$val."\" $size[3]>"."\n";
											}
										}
									}
									elseif ($key=="email") { echo "      <a href=\"mailto:".$val."\">$val</a><BR>\n"; }
									elseif ($key=="phone") {
										$val = "(".substr($val,0,3).") ".substr($val,3,3)."-".substr($val,6,4);
										echo "      $val";
										if (strlen($result_ary["ext"]) > 0) { echo " Ext. ".$result_ary["ext"]; }
										echo "<BR>\n";
									}
									elseif ($key=="website") { echo "      Website: <a href=\"".$val."\">$val</a><BR>\n"; }
									elseif (($key=="link_target") && ($result_ary["link_text"] != "")) { echo "      <B><font color=\"#000066\"><a href=\"".$val."\">".$result_ary["link_text"]."</a></font></B><BR>\n"; }
									else {
										$val = ereg_replace("(\r\n)", "<BR>", $val); // fix returns
										echo "      ".$val."<BR>\n";
									}
								}							
							}
							echo " </TR>\n";
						}
					}
					echo "</TABLE>\n";
				}
			}
		}
		else { echo "<BR><CENTER>(no content found)</CENTER><BR>\n"; }
    }
    elseif ($edit_ary[$chunk]['display_type']['name']=="news_scroller") {
		// set heading color
    	if (strlen($edit_ary[$chunk]['display_type']['heading_color']) > 0) { 
			$h_color = $edit_ary[$chunk]['display_type']['heading_color'];
		}
		else { $h_color = "#000066"; }
    	// get fields from table
		if ($edit_ary[$chunk]['display_type']['display_sort_by_field']!="") { $sort_by = $edit_ary[$chunk]['display_type']['display_sort_by_field']; } // sort by array value if set
		else { $sort_by = "id"; }
		$tb_sql = "SELECT * FROM ".$edit_ary[$chunk]['table_name']." ORDER BY $sort_by"; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			// do content as plain text
			$buffer = "content=";
			while ($result_ary = mysql_fetch_assoc($tb_result)) {
				if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
					if (trim($result_ary["link"]) !== "") { // check for link
						$buffer .= "<a href=\"{$result_ary["link"]}\">{$result_ary["heading"]}<br><u>{$edit_ary[$chunk]['display_type']['link_text']}</u></a>\n|"; 
					} else {
						$buffer .= "{$result_ary["heading"]}<br>\n|";
					}					
				}
			}
			$buffer = substr($buffer,0,-1); //remove last |
			echo $buffer;
		}
		else { echo "content=No content found.\n"; }
    }
    else { // default display type, column/row table format
		// get fields from table
		$tb_sql = "SELECT * FROM ".$edit_ary[$chunk]['table_name']." ORDER BY id"; 
		$tb_result = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
		if (mysql_num_rows($tb_result)) { // check for any content
			// check for any filtering to see if show anything / header row
			while ($result_ary2 = mysql_fetch_assoc($tb_result)) {
				if (($result_ary2['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { 
					$show_header_row = 1;
				}
			}
			
			if ($show_header_row) {
				echo $table_code."\n";
				// first do header row
				echo " <TR>\n";
				$tb_result2 = mysql_query($tb_sql,$db_conn) or die($die_mesg.mysql_error()."<BR>File: $PHP_SELF, Line: ".__LINE__);
				while ($fields = mysql_fetch_field($tb_result2)) {
					if ($fields->name != "id") { 
						$field_name_display = str_replace ("_"," ",$fields->name);
						$field_name_display = ucwords($field_name_display);
						echo "  ".$td_code."<B>".$field_name_display."</B></TD>\n"; 
					}
				}
				echo " </TR>\n";
				// do content
				while ($result_ary = mysql_fetch_assoc($tb_result2)) {
					if (($result_ary['filter']==$_SESSION['sess_filter']) || ($_SESSION['sess_filter']=="")) { // check for filtering
						echo " <TR>\n";
						while (list($key,$val) = each($result_ary)) {
							if ((($key != "id") && ($val != "")) && (($key != "filter") && ($val != ""))) {  
								$val = ereg_replace("(\r\n)", "<BR>", $val); // fix returns
								echo "  ".$td_code.$val."</TD>\n"; 
							}
						} 
						echo " </TR>\n";
					}
				}
				echo "</TABLE>\n";
			}
		}
		else { echo "<BR><CENTER>(no content found)</CENTER><BR>\n"; }
    }
	//}
}

?>