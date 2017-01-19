<?php

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
	if ($fp = fopen($filename, 'rb')) {
		while (!feof($fp)) {
			$return .= fread($fp, 1024);
		}
		fclose($fp);
		return $return;

	} else {
		return false;
	}
}

/**
* Encode string with quoted_printable. 
*
* Function found at http://www.php.net/manual/en/function.quoted-printable-decode.php
* No further comments.
*/
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


/** 
* Add a file to the list of attachments.
* 
* @access   public
* @param    string      to        	Mail destination.
* @param    string      header      Mail header.
* @param    string      Subject     Mail subject.
* @param    string      body        Mail Content.
* @param    string      filepaths   Full path/file names.
*/
function SendAttachment($to, $body, $subject, $headers, $filepaths)
{
	$m_files = $filepaths;
    $m_parts = array();
    $m_multipart = "";
     
    // -------------------- Collecting parts ------------------------
    if (isset($body) && $body != '')
    {
   		$m_parts[] = array('content'=>$body, 'name'=>'', 'c_type'=>'text/plain');
    }
   	for ($ii = 0; $ii < count($m_files); $ii++)
   	{
   		$chunks = split("/", $m_files[$ii]);
 		$shortfilename = $chunks[count($chunks) - 1];
   		$m_parts[] = array('content'=>$m_files[$ii], 'name'=>$shortfilename, 'c_type'=>'application/octet-stream');
   	}

   	// ------------------- Build header ---------------------------- 
   	$boundary = '=_' . md5(uniqid(time()));
	$m_header[] = 'MIME-Version: 1.0';
    $m_header[] = 'Content-Type: multipart/mixed;'.chr(10).chr(9).'boundary="'.$boundary.'"';
    
    // ------------------- Build all parts ----------------------------
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
            $msg_part .= 'Content-Disposition: attachment; filename="' . $m_parts[$ii]['name']. "\"\n\n";
            $data = getFile($m_parts[$ii]['content']);
            $msg_part .= chunk_split(base64_encode($data), 76, "\n") . "\n";
        }
   	 	
   	 	$m_multipart .= '--'.$boundary."\n" . $msg_part;
   	 }
	 $m_multipart .= "--".$boundary."\n";
	 		  
	// Start sending mail 	
	$addheaders = trim("$headers\n" . implode("\n", $m_header));
    // Extract to e-mail address. 
    if (ereg("^(.*)<(.*)>", $to, $regs)) {
        $to_e = $regs[2];
    }
    else {
        $to_e = $to;
    }
      
    // Extract from e-mail address. Pass to sendmail -f to set Return-Path
    if (ereg("^(.*)<(.*)>", $headers, $regs)) {
        $from_e = $regs[2];
    }
    else {
        $from_e = $from;
    }

    // ----------------  Send it
	mail($to_e, $subject, $m_multipart, $addheaders, "-f$from_e");  
	
}

SendAttachment("kenny@calibermg.com", "I got the attach mail working.", 
				"Test attach mail", "From: Kenny <kenny@calibermg.com>", array("StreamLine Installation Req - 051804.pdf"));

?>