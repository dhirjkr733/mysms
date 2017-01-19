<?php
/**
 * @return resource
 * @desc connect to specified directory on host
 * @param string $directory
 * @param string $usr
 * @param string $pass
 * @param string[optional] $host
 * @param string[optional] $firewall
 */
function myftp_connect($directory, $usr, $pass, $host="localhost", $firewall='') {
	$hostip = $host;
	//uncomment line above and remove line below after testing
	//$hostip = '69.20.69.37';
	if ($firewall !== '') {
		// Connect to firewall
		$conn_id = @ftp_connect("$firewall");
		// Open a session to an external ftp site
		$login_result = @ftp_login ($conn_id, "$usr"."@"."$host", "$pass");
	} else {
		$conn_id = @ftp_connect("$hostip");
		// Open a session to an external ftp site
		$login_result = @ftp_login ($conn_id, "$usr", "$pass");
	}

	// Check open
	if ((!$conn_id) || (!$login_result)) {
		return false;
	} else {
		// turn on passive mode transfers
		@ftp_pasv ($conn_id, true) ;
		//change to requested directory
		if (@ftp_chdir($conn_id,$directory)) {
			// get contents of the current directory
			return $conn_id;
		} else {
			return false;
		}
	}
}
function itemize_dir($contents) {
	foreach ($contents as $key=>$file) {
		unset($tmp_array);
		
		if(ereg("([-dl][rwxstST-]+).* ([0-9]*) ([a-zA-Z0-9]+).* ([a-zA-Z0-9]+).* ([0-9]*) ([a-zA-Z]+[0-9: ]*[0-9])[ ]+(([0-9]{1,2}:[0-9]{2})|[0-9]{4}) (.+)", $contents[$key], $regs)) {
		
			$type = (int) strpos("-dl", $regs[1]{0});
			$tmp_array['line'] = $regs[0];
			$tmp_array['type'] = $type;
			$tmp_array['rights'] = $regs[1];
			$tmp_array['number'] = $regs[2];
			$tmp_array['user'] = $regs[3];
			$tmp_array['group'] = $regs[4];
			$tmp_array['size'] = $regs[5];
			$tmp_array['date'] = date("m-d",strtotime($regs[6]));
			$tmp_array['time'] = $regs[7];
			$tmp_array['name'] = $regs[9];
		}
		if (is_array($tmp_array)) {
			if ($tmp_array['name'] != '.' && $tmp_array['name'] != '..') {
				$dir_list[] = $tmp_array;
			}
		}
	}
	return $dir_list;
}
/**
 * @return link identifier on success, or FALSE on error
 * @desc connect to specified database on host
 * @param string $db
 * @param string $usr
 * @param string $pass
 * @param string [optional]$host
 * @param bool [optional]$persist
 */
function db_connect($db, $usr, $pass, $host="localhost", $persist=true) {
	if ($persist)
		$result = @mysql_pconnect($host, $usr, $pass) or die(mysql_error());
	else
		$result = @mysql_connect($host, $usr, $pass) or die(mysql_error());
	if (!$result)
    	return false;
	if (!(@mysql_select_db($db) or die("Could not select db")))
		return false;
	return $result;
}
/**
 * @return array
 * @desc make an array out of mysql result set, each element = each row in rs
 * @param int $result
 */
function db_result_to_array($result) {
	$res_array = array();
	for ($count=0; $row = mysql_fetch_array($result); $count++)
		$res_array[$count] = $row;
	return $res_array;
}
/**
 * @return string
 * @desc return string $value as an escaped sql safe string surrounded by single quotes
 * @param string $value
 */
function quote_smart($value) {
	// Stripslashes
	if (get_magic_quotes_gpc()) {
		$value = stripslashes($value);
	}
	$value = "'" . mysql_real_escape_string($value) . "'";
	return $value;
}
/**
* This function will read a file in
* from a supplied filename and return
* it. This can then be given as the first
* argument of the the functions
* add_html_image() or add_attachment().
*/
function getFile($filename)
{
	$return = '';
	/*
	if ($fp = fopen($filename, 'rb')) {

		while (!feof($fp)) {
			$return .= fread($fp, 1024);
		}

		fclose($fp);
		return $return;

	} else {
		return false;
	}
	*/
	if (file_exists($filename)) {
		$return = file_get_contents($filename);
		return $return;
	} else {
		return false;
	}
}

/**
 * @return string
 * @param string $input
 * @param int[optional] $line_max
 * @desc Encode string with quoted_printable.
*/
//drj 161216 commented below fns
/*
function quoted_printable_encode($input, $line_max = 76)
{
    $hex    = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F');
    $lines  = preg_split("/(?:\r\n|\r|\n)/", $input);
    $eol    = "\r\n";
    $escape = "=";
    $output = "";

    while( list(, $line) = each($lines) ) {
        //$line  = rtrim($line); // remove trailing white space -> no =20\r\n necessary
        $linlen  = strlen($line);
        $newline = "";
        for ($i = 0; $i < $linlen; $i++) {
            $c   = substr($line, $i, 1);
            $dec = ord($c);
            if ( ($dec == 32) && ($i == ($linlen - 1)) ) {  // convert space at eol only
                $c = "=20";
            }
            elseif (($dec == 61) || ($dec < 32 ) || ($dec > 126)) {  // always encode "\t", which is *not* required
                $h2 = floor($dec/16); $h1 = floor($dec%16);
                $c = $escape.$hex["$h2"].$hex["$h1"];
            }
            if ((strlen($newline) + strlen($c)) >= $line_max) { // CRLF is not counted
                $output .= $newline.$escape.$eol; // soft line break; " =\r\n" is okay
                $newline = "";
            }
            $newline .= $c;
        } // end of for
        $output .= $newline.$eol;
    }

    return trim($output);
}

*/
/**
 * @access public
 * @return void
 * @param  string $to          Mail destination.
 * @param  string $subject     Mail subject.
 * @param  string $body        Mail Content.
 * @param  string $header      Mail header.
 * @param  array  $filepaths   Full path/file names.
 * @desc Add a file to the list of attachments.
*/
function sendAttachment($to, $subject, $body,  $headers, $filepaths)
{
	$m_files = $filepaths;
    $m_parts = array();
    $m_multipart = "";

    // Collecting parts ------------------------
    if (isset($body) && $body != '')
    {
   		$m_parts[] = array('content'=>$body, 'name'=>'', 'c_type'=>'text/plain');
    }
   	for ($ii = 0; $ii < count($m_files); $ii++)
   	{
   		//$m_parts[] = array('content'=>$m_files[$ii], 'name'=>$m_files[$ii], 'c_type'=>'application/octet-stream');
   		$m_parts[] = array('content'=>$m_files[$ii], 'name'=>basename($m_files[$ii]), 'c_type'=>'application/octet-stream');
   	}

   	$boundary = '=_' . md5(uniqid(time()));
	$m_header[] = 'MIME-Version: 1.0';
    $m_header[] = 'Content-Type: multipart/mixed;'.chr(10).chr(9).'boundary="'.$boundary.'"';
   	for ($ii = 0; $ii < count($m_parts); $ii++)
   	{
  	 	$msg_part = "";
   	 	$msg_part .= 'Content-Type: ' . $m_parts[$ii]['c_type'];

    	if ($m_parts[$ii]['name'] != '') {
        	$msg_part .= '; name="' . $m_parts[$ii]['name'] . "\"\n";
    	}
    	else {
    		$msg_part .= "\n";
    	}

        // Determine content encoding.
        if ($m_parts[$ii]['c_type'] == 'text/plain') {
            $msg_part .= 'Content-Transfer-Encoding: quoted-printable' . "\n\n";
            $msg_part .= quoted_printable_encode($m_parts[$ii]['content'])."\n\n";
       }
        elseif ($m_parts[$ii]['c_type'] == 'message/rfc822') {
            $msg_part .= 'Content-Transfer-Encoding: 7bit' . "\n\n";
            $msg_part .= $m_parts[$ii]['content'] . "\n";
        }
        else {
        	$msg_part .= 'Content-Transfer-Encoding: base64'."\n";
            $msg_part .= 'Content-Disposition: attachment; filename="' . substr($m_parts[$ii]['name'],strpos($m_parts[$ii]['name'],'_')+1) . "\"\n\n";
            $data = getFile($m_parts[$ii]['content']);
            $msg_part .= chunk_split(base64_encode($data), 76, "\n") . "\n";
        }

   	 	$m_multipart .= '--'.$boundary."\n" . $msg_part;
   	 }
	 $m_multipart .= "--".$boundary."\n";

	// Start sending mail
	$addheaders = trim("$headers\n" . implode("\n", $m_header));

	// Send it
	mail($to, $subject, $m_multipart, $addheaders);
	return true;
}
/**
 * @return void
 * @desc mail error in $message and script state to technical admin
 * @param string $message
 */
function sendErrorMail($message) {
	ob_start();
	var_dump($_REQUEST);
	echo "\n\n\SESSION Information:\n";
	var_dump($_SESSION);
	echo "\n\nSERVER Information:\n";
	var_dump($_SERVER);
	echo "\n\n\ENV Information:\n";
	var_dump($_ENV);
	$temp = ob_get_clean();
	$mailmsg = $message."\n\nREQUEST Information:\n".$temp;
	mail(DEBUG_EMAIL,"mySMS Error",$mailmsg,"From: test@firstam.com\r\n");
}
/**
 * @return string
 * @desc insert user into database and return id of inserted row
 * @param array $user_info
 */
function insertUser($user_info) {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST);
	$field_list = '';
	$values_list = '';
	$num_rows = 0;
	if (is_array($user_info)) {
		foreach($user_info as $key => $value) {
			$field_list .= "$key,";
			if ($key == 'password') {
				$values_list .= "ENCODE(".quote_smart($value).",'".SALT."'),";
				$pass_result = @mysql_query("INSERT INTO password_log (password,usersid) VALUES (ENCODE('$value','".SALT."'),'$id')");
			} else {
				$values_list .= quote_smart($value).",";
			}
		}
		//no need to remove last comma
		$field_list .= 'last_login,password_expires';
		$values_list .= 'NOW(),DATE_ADD(CURDATE(), INTERVAL 90 DAY)';
		$sql = "INSERT INTO users ($field_list) VALUES ($values_list)";
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			$sql2 = "SELECT id FROM users WHERE email=".quote_smart($user_info['email']);
			$result = @mysql_query($sql2);
			if (!$result) {
				sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql2\n\nResults: ".mysql_error());
				return false;
			} else {
				$num_rows = @mysql_numrows($result);
				if ($num_rows <= 0) {
					sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: Inserted record not found");
					return false;
				} else {
					$id = mysql_result($result, 0);
					return $id;
				}
			}
		}
	} else {
		return false;
	}
}
/**
 * @return string
 * @desc insert product registration into database and return id of inserted row
 * @param array $user_info
 */
function insertProductRegistration($user_info) {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST);
	$field_list = '';
	$values_list = '';
	$num_rows = 0;
	if (is_array($user_info)) {
		foreach($user_info as $key => $value) {
			$field_list .= "$key,";
			$values_list .= quote_smart($value).",";
		}
		//remove last comma
		$field_list = substr($field_list,0,-1);
		$values_list = substr($values_list,0,-1);
		$sql = "INSERT INTO productregistrations ($field_list) VALUES ($values_list)";
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			$sql2 = "SELECT id FROM productregistrations
						WHERE product=".quote_smart($user_info['product']) . " AND
							sub_dir=".quote_smart($user_info['sub_dir']) . " AND
							logged_in_userid=".quote_smart($user_info['logged_in_userid']);
			$result = @mysql_query($sql2);
			if (!$result) {
				sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql2\n\nResults: ".mysql_error());
				return false;
			} else {
				$num_rows = @mysql_numrows($result);
				if ($num_rows <= 0) {
					sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: Inserted record not found");
					return false;
				} else {
					$id = mysql_result($result, 0);
					return $id;
				}
			}
		}
	} else {
		return false;
	}
}
/**
 * @return boolean
 * @desc insert schedule upgrade request into database and return true on success
 * @param array $user_info
 */
function insertUpgradeRequest($user_info) {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST);
	$field_list = '';
	$values_list = '';
	$num_rows = 0;
	if (is_array($user_info)) {
		foreach($user_info as $key => $value) {
			$field_list .= "$key,";
			$values_list .= quote_smart($value).",";
		}
		//remove last comma
		$field_list = substr($field_list,0,-1);
		$values_list = substr($values_list,0,-1);
		$sql = "INSERT INTO upgraderequests ($field_list) VALUES ($values_list)";
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}
/**
 * @return boolean
 * @desc insert product info request into database and return true on success
 * @param array $user_info
 */
function insertProductInfoRequest($user_info) {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST);
	$field_list = '';
	$values_list = '';
	$num_rows = 0;
	if (is_array($user_info)) {
		foreach($user_info as $key => $value) {
			$field_list .= "$key,";
			$values_list .= quote_smart($value).",";
		}
		//remove last comma
		$field_list = substr($field_list,0,-1);
		$values_list = substr($values_list,0,-1);
		$sql = "INSERT INTO productrequests ($field_list) VALUES ($values_list)";
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}
/**
 * @return boolean
 * @desc insert software change request into database and return true on success
 * @param array $user_info
 */
function insertSoftwareChangeRequest($user_info) {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST);
	$field_list = '';
	$values_list = '';
	$num_rows = 0;
	if (is_array($user_info)) {
		foreach($user_info as $key => $value) {
			$field_list .= "$key,";
			$values_list .= quote_smart($value).",";
		}
		//remove last comma
		$field_list = substr($field_list,0,-1);
		$values_list = substr($values_list,0,-1);
		$sql = "INSERT INTO softwarechangerequests ($field_list) VALUES ($values_list)";
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}
/**
 * @return boolean
 * @desc insert join mailing list request into database and return true on success
 * @param array $user_info
 */
function insertMailingListRequest($user_info) {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST);
	$field_list = '';
	$values_list = '';
	$num_rows = 0;
	if (is_array($user_info)) {
		foreach($user_info as $key => $value) {
			$field_list .= "$key,";
			$values_list .= quote_smart($value).",";
		}
		//remove last comma
		$field_list = substr($field_list,0,-1);
		$values_list = substr($values_list,0,-1);
		$sql = "INSERT INTO mailinglistrequests ($field_list) VALUES ($values_list)";
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}
/**
 * @return boolean
 * @desc update user with $user_info array, keys are field names and values are updated info
 * @param string $id
 * @param array $user_info
 */
function updateUser($id, $user_info) {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	$update_string = '';
	if (is_array($user_info)) {
		foreach($user_info as $key => $value) {
			if ($key == 'password') {
				$update_string .= "password=ENCODE('$value','".SALT."'),password_expires=DATE_ADD(CURDATE(), INTERVAL 90 DAY),";
				$pass_result = @mysql_query("INSERT INTO password_log (password,usersid) VALUES (ENCODE('$value','".SALT."'),'$id')");
			} else {
				$update_string .= "$key=".quote_smart($value).",";
			}
		}
		//no need to remove last comma
		$update_string = substr($update_string, 0, -1);
		$sql = "UPDATE users SET $update_string WHERE id = '$id'";
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}
/**
 * @return boolean
 * @desc delete user identified by $id in database
 * @param string $id
 */
function deleteUser($id) {
	if ($id !== '') {
		$sql = "DELETE FROM users WHERE id = '$id'";
		db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}
/**
 * @return array
 * @desc return array of info for user identified by $id in database on success, false on error
 * @param string $id
 */
function getUser($id) {
	if ($id !== '') {
		$sql = "SELECT
				id,
				email,
				DECODE(password,'" . SALT . "') as password,
				firstname,
				lastname,
				clientid,
				title,
				company,
				address,
				city,
				state,
				county,
				zip,
				phone,
				fax,
				default_product,
				registration_status,
				signup_date,
				ip_address,
				computer_details,
				last_login,
				password_expires
			FROM users
			WHERE id = '$id'";
		db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			$row = mysql_fetch_assoc($result);
			$phone = fix_phone_from_db($row['phone']);
			$row['phone1'] = $phone[0];
			$row['phone2'] = $phone[1];
			$row['phone3'] = $phone[2];
			if (isset($phone[3])) {
				$row['phone4'] = $phone[3];
			}
			if (trim($row['fax']) !== '') {
				$fax = fix_phone_from_db($row['fax']);
				$row['fax1'] = $fax[0];
				$row['fax2'] = $fax[1];
				$row['fax3'] = $fax[2];
			}
			return $row;
		}
	} else {
		return false;
	}
}
/**
 * @return boolean
 * @desc update profile log with $user_info array, keys are field names and values are updated info
 * @param string $id
 * @param array $user_info
 */
function updateProfileLog($id, $user_info) {
	$old_results = @mysql_query("SELECT * FROM users WHERE id ='$id'");
	if ($old_results) {
		$old_info = @mysql_fetch_assoc($old_results);
	}
	$fields = '';
	$data = '';
	$update_string = '';
	if (is_array($user_info)) {
		foreach($user_info as $key => $value) {
			if (is_array($old_info)) {
				if (trim($value) !== trim($old_info[$key])) {
					if ($key == 'password') {
						if ($_POST['new_password'] == $value) {
							$fields .= "$key,";
							$data .= "'".trim($old_info[$key])."',";
						}
					} else {
						if ($key != 'registration_status') {
							$fields .= "$key,";
							$data .= "'".trim($old_info[$key])."',";
						}
					}
				}
			}
		}
		//no need to remove last comma
		$fields .= "modified,usersid";
		$data .= "NOW(),'$id'";
		$sql = "INSERT INTO profile_log ($fields) VALUES ($data)";
		db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}
/**
 * @return array
 * @desc return array of all companies in the database, false on error
 */
function getCompanies() {
	$sql = "SELECT DISTINCT company FROM users WHERE company NOT LIKE '' ORDER BY company ASC";
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	$result = @mysql_query($sql);
	if (!$result) {
		sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
		return false;
	} else {
		while ($row = mysql_fetch_row($result)) {
			$companies[] = $row[0];
		}
		return $companies;
	}
}
/**
 * @return string
 * @param string $sql
 * @desc return comma delimited string of email addresses from database based on $sql with comma as first character, empty string on error
 */
function getEmailList($sql) {
	$emails = "";
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	$result = @mysql_query($sql);
	if (!$result) {
		sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
		return '';
	} else {
		while ($row = mysql_fetch_row($result)) {
			if ((!is_null($row[0])) && ($row[0] !== '')) {
				$emails .= "{$row[0]},";
			}
		}
		//remove last comma
		$emails = substr($emails,0,-1);
		//add comma to beginning of string
		if ($emails !== "") {
			$emails = ",".$emails;
		}
		return $emails;
	}
}
/**
 * @return array
 * @param string $id
 * @desc return training facility directory listing on success, false on error
 */
function getFacility($id) {
	if ($id != '') {
		$sql = "SELECT * FROM facilities_directory WHERE id = $id ORDER BY heading ASC";
		db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			$facility = mysql_fetch_assoc($result);
			$d_sql = "SELECT * FROM driving_directions WHERE facility_id = $id ORDER BY heading ASC";
			$d_result = @mysql_query($d_sql);
			if (!$d_result) {
				sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $d_sql\n\nResults: ".mysql_error());
				return false;
			} else {
				while ($d_row = mysql_fetch_assoc($d_result)) {
					$facility['driving_directions'][] = $d_row;
				}
			}
			$h_sql = "SELECT * FROM hotels WHERE facility_id = $id ORDER BY heading ASC";
			$h_result = @mysql_query($h_sql);
			if (!$h_result) {
				sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $h_sql\n\nResults: ".mysql_error());
				return false;
			} else {
				while ($h_row = mysql_fetch_assoc($h_result)) {
					$facility['hotels'][] = $h_row;
				}
			}
			return $facility;
		}
	} else {
		return false;
	}
}
/**
 * @return array
 * @param string{optional] $product
 * @param string{optional] $type
 * @desc return array of ftp settings info identified by product, defaults to all, false on error
 */
function getFTP($product='',$type='') {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	if ($product != '') {
		//$sql = "SELECT id,product,server,directory,username,DECODE(password,'".SALT."') as password
		$sql = "SELECT id,product,directory,type
			FROM ftp_settings
			WHERE product LIKE ('$product')";
		if ($type !== '') {
			$sql .= " AND type LIKE ('$type')";
		}
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			$row = mysql_fetch_assoc($result);
			return $row;
		}
	} else {
		$sql = "SELECT * FROM ftp_settings ORDER BY product,type ASC";
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			while ($row = mysql_fetch_assoc($result)) {
				$row_list[] = $row;
			}
			return $row_list;
		}
	}
}
/**
 * @return array
 * @param string $id
 * @desc return array of ftp settings info identified by row id, false on error
 */
function getFTPbyId($id) {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	//$sql = "SELECT id,product,server,directory,username,DECODE(password,'".SALT."') as password,type FROM ftp_settings WHERE id = '$id'";
	$sql = "SELECT id,product,directory,type FROM ftp_settings WHERE id = '$id'";
	$result = @mysql_query($sql);
	if (!$result) {
		sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
		return false;
	} else {
		$row = mysql_fetch_assoc($result);
		return $row;
	}
}
/**
 * @return boolean
 * @desc add ftp information with $ftp_info array
 * @param array $ftp_info
 */
function insertFTP($ftp_info) {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	$field_list = '';
	$values_list = '';
	$num_rows = 0;
	if (is_array($ftp_info)) {
		foreach($ftp_info as $key => $value) {
			$field_list .= "$key,";
			/*
			if ($key == 'password') {
				$values_list .= "ENCODE('$value','".SALT."'),";
			} else {
				$values_list .= quote_smart($value).",";
			}
			*/
			$values_list .= quote_smart($value).",";
		}
		//remove last comma
		$field_list = substr($field_list, 0, -1);
		$values_list = substr($values_list, 0, -1);
		$sql = "INSERT INTO ftp_settings ($field_list) VALUES ($values_list)";
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}
/**
 * @return boolean
 * @desc update ftp information with $ftp_info array, keys are field names and values are updated info
 * @param string $id
 * @param array $ftp_info
 */
function updateFTP($id, $ftp_info) {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	$update_string = '';
	if (is_array($ftp_info)) {
		foreach($ftp_info as $key => $value) {
			/*
			if ($key == 'password') {
				$update_string .= "password=ENCODE('$value','".SALT."'),";
			} else {
				$update_string .= "$key=".quote_smart($value).",";
			}
			*/
			$update_string .= "$key=".quote_smart($value).",";
		}
		//remove last comma
		$update_string = substr($update_string, 0, -1);
		$sql = "UPDATE ftp_settings SET $update_string WHERE id = '$id'";
		//echo $sql;
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}
/**
 * @return boolean
 * @desc delete ftp information indicated by $id
 * @param string $id
 */
function deleteFTP($id) {
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	if ($id !== '') {
		$sql = "DELETE FROM ftp_settings WHERE id = '$id'";
		$result = @mysql_query($sql);
		if (!$result) {
			sendErrorMail("Line ".__LINE__." in ".__FILE__.":\n\nQuery: $sql\n\nResults: ".mysql_error());
			return false;
		} else {
			return true;
		}
	} else {
		return false;
	}
}
/**
 * @return array
 * @param array $ftp_info
 * @desc return product FTP directory listing on success, error string on error
 */
function getDirectoryListing($ftp_info) {
	if ($ftp_info != '') {
		//$ftp_conn = myftp_connect($ftp_info['directory'],$ftp_info['username'],$ftp_info['password'],$ftp_info['server']);
		$ftp_conn = myftp_connect($ftp_info['directory'],DEFAULT_FTP_USER,DEFAULT_FTP_PASS,DEFAULT_FTP_SITE);
		if (!$ftp_conn) {
			return ('Could not connect to file resource');
		} else {
			 $buff = ftp_rawlist($ftp_conn, ".");
			 $contents_temp = itemize_dir($buff);
			 foreach ($contents_temp as $key=>$value) {
				if ($value['name'] != '.' && $value['name'] != '..')
					$contents[$key] = $value['name'];
			 }
			
			$rv = array();
			if (is_array($contents)) {
				foreach ($contents as $key=>$value) {
					if (!is_null($value) && ($value != '.' && $value != '..')) {
						$dirchanged = @ftp_chdir($ftp_conn, $value);
						$sub_buff = ftp_rawlist($ftp_conn, ".");
						$rv[$key]["sub_dir"] = itemize_dir($sub_buff);
						$rv[$key]["name"] = $value;
						if ($dirchanged) ftp_cdup($ftp_conn);
					}
				}
			}
			// close this connection
			ftp_close($ftp_conn);
			// output $contents
			return $rv;
		}
	} else {
		return 'Invalid location.';
	}
}
/**
 * @return array
 * @param string $filename
 * @desc readfile for large files
 */
function readfile_chunked($filename) {
	$chunksize = 1*(1024*1024); // how many bytes per chunk
	$buffer = '';
	$handle = fopen($filename, 'rb');
	if ($handle === false) {
		return false;
	}
	while (!feof($handle)) {
		$buffer = fread($handle, $chunksize);
		print $buffer;
	}
	fclose($handle);
	unset($handle);
}
/**
 * @return void
 * @desc load global config from database
 */
function init_site() {
	global $PRODUCT_ARRAY;
	global $ADDITIONAL_FTP_TYPES;
	db_connect(DATABASE,DATABASE_USER,DATABASE_PASS,DATABASE_HOST,false);
	// populate constants
	$sql = 'SELECT name,value,type FROM admin_settings';
	$result = @mysql_query($sql);
	while ($row = mysql_fetch_assoc($result)) {
		switch($row['type']) {
			default:
				eval("define('{$row['name']}','{$row['value']}');");
				break;
		}
	}
	// populate global arrays
	$sql = 'SELECT DISTINCT product FROM ftp_settings';
	$result = @mysql_query($sql);
	while ($row = mysql_fetch_row($result)) {
		$PRODUCT_ARRAY[] = trim($row[0]);
	}
	$ADDITIONAL_FTP_TYPES = Array (
		'Customer Survey'=>CUSTOMER_SURVEY_FTP_DIR,
		'Document'=>DOCUMENT_FTP_DIR,
		'Implementation Tool'=>IMPLEMENTATION_TOOL_FTP_DIR,
		'Installation Requirement'=>INSTALLATION_REQ_FTP_DIR,
		'Logo'=>LOGO_FTP_DIR,
		'Newsletter'=>NEWSLETTER_FTP_DIR,
		'eTraining'=>ETRAINING_FTP_DIR
		);
}
//initialize site
init_site();
?>