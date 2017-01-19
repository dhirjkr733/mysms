<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/nusoap-0.9.5/lib/nusoap.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/xmlparser.php');

define('PROXY_HOST', '');
define('PROXY_PORT', '');
define('PROXY_USERNAME', '');
define('PROXY_PASSWORD', '');
define('USE_CURL', true);
define('USE_WSDL',true);
$testmode = TRUE;
if ($testmode) {
	define('WSDL_URL','http://AcctValCMS.beta.smscorp.com/CMSValidation.svc?wsdl');
        //define('WSDL_URL','https://AcctValCMS.smscorp.com/CMSValidation.svc?wsdl');
} else {
	define('WSDL_URL','https://AcctValCMS.smscorp.com/CMSValidation.svc?wsdl');
}

function ValidateSMS($email, $password) {
	// This is an archaic parameter list
	/* $params = array('XMLUserAuthentication'=>"<?xml version='1.0' encoding='utf-8' ?><LoginRequest><UserName>caliber@calibermediagroup.com</UserName><Password>b*n3wUserC</Password><CustomerToken></CustomerToken></LoginRequest>"); */
	$params = array('XMLUserAuthentication'=>"<?xml version='1.0' encoding='utf-8' ?><LoginRequest><UserName>{$email}</UserName><Password>{$password}</Password><CustomerToken></CustomerToken></LoginRequest>");
	
	$client = new nusoap_client(WSDL_URL, USE_WSDL, PROXY_HOST, PROXY_PORT, PROXY_USERNAME, PROXY_PASSWORD,0,60,'');
	$client->endpointType = 'wsdl' ;
		
	$err = $client->getError();
	/*
	if ($err) {
		echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
		exit();
	}
	*/
	$client->setUseCurl(USE_CURL);
	$result = $client->call('AccountValidation', $params, '', '', '', null, $style='document', $use='encoded');
	/*
	print $client->appendDebug('params='.$client->varDump($params));
	echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
	exit();
	*/	
	if ($client->fault) {
		echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>'; 
		//print_r($result); 
		echo '</pre>';
		/*
		echo '<h2>Request</h2><pre>' . htmlspecialchars($client->request, ENT_QUOTES) . '</pre>';
		echo '<h2>Response</h2><pre>' . htmlspecialchars($client->response, ENT_QUOTES) . '</pre>';
		*/
	} else {
		$err = $client->getError();
		if ($err) {
			echo '<h2>Error</h2><pre>' . $err . '</pre>';
		} else {
			//echo '<h2>Result</h2><pre>'; print_r($result); echo '</pre>';
			$parser = new XmlParser();
			$data = $parser->parse($result['AccountValidationResult']);
			
			//print '<!--'; print_r( $data ); print '-->'; 
			/*
			exit;
			*/
			
			$user_info = array();
			$user_info['LoginResponse']['UserInformation'] = $data['LoginResponse']['UserInformation'] ;
			$user_info['LoginResponse']['LoginStatus']['StatusID'] = $data['LoginResponse']['LoginStatus']['StatusID'];
			$user_info['LoginResponse']['LoginStatus']['Status'] = $data['LoginResponse']['LoginStatus']['Status'];
			$user_info['LoginResponse']['LoginStatus']['Message'] = $data['LoginResponse']['LoginStatus']['Message'];
			$user_info['LoginResponse']['ActiveCompanies'][0]['CompanyInformation']['State'] = $data['LoginResponse']['ActiveCompanies']['CompanyInformation']['State'] ;
			$user_info['LoginResponse']['DefaultProduct']['ProductName'] = $data['LoginResponse']['DefaultProduct']['ProductName'] ;
			$user_info['LoginResponse']['UserToken'] = $data['LoginResponse']['UserToken']['GUID'] ;
			$user_info['LoginResponse']['RawData'] = $result['AccountValidationResult'];
		}
	}

	/*
	if ($err) {
		echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
	}*/
	return $user_info;
}

function ssl_encrypt($source,$type,$key){
	//Assumes 1024 bit key and encrypts in chunks.
	
	$maxlength=117;
	$output='';
	while($source){
	  $input= substr($source,0,$maxlength);
	  $source=substr($source,$maxlength);
	  if($type=='private'){
		$ok= openssl_private_encrypt($input,$encrypted,$key);
	  }else{
		$ok= openssl_public_encrypt($input,$encrypted,$key);
	  }
			
	  $output.=$encrypted;
	}
	return $output;
}

function generateRightAnswersToken() {
/*
	$encryptedviaprivatekey = ""; //holds text encrypted with the private key
	$xml = '<User Data>';
	$xml .= '<username>' . $_SESSION['usertoken'] . '</username>';
	$xml .= '<firstname>' . $_SESSION['firstname'] . '</firstname>';
	$xml .= '<lastname>' . $_SESSION['lastname'] . '</lastname>';
	$xml .= '<email>' . $_SESSION['email'] . '</email>';
	$xml .= '<authorization>yes</authorization>';
	$xml .= '</User Data>';
	
	$fp=fopen($_SERVER['DOCUMENT_ROOT'] . '/cms/privkey.pem',"r"); 
	$priv_key=fread($fp,8192); 
	fclose($fp);
	
	$res = openssl_get_privatekey($priv_key);
	openssl_private_encrypt($xml,$encryptedviaprivatekey,$res);
	
	return urlencode(base64_encode($encryptedviaprivatekey));
*/
	$encryptedviaprivatekey = ""; //holds text encrypted with the private key
	//print_r($_SESSION);
	$xml = str_replace('<?xml version="1.0" encoding="utf-8" ?>','',$_SESSION['rawdata']);
	
	$fp=fopen($_SERVER['DOCUMENT_ROOT'] . '/cms/privkey.pem',"r"); 
	$priv_key=fread($fp,8192); 
	fclose($fp);
	$res = openssl_get_privatekey($priv_key);
	
	$encryptedviaprivatekey = ssl_encrypt($xml,'private',$res);
	
	return base64_encode($encryptedviaprivatekey);
}
function generateRightAnswersTokenNew() {
	$encryptedviaprivatekey = ""; //holds text encrypted with the private key
	
	$xml = str_replace('<?xml version="1.0" encoding="utf-8" ?>','',$_SESSION['rawdata']);
	
	$fp=fopen($_SERVER['DOCUMENT_ROOT'] . '/cms/privkey.pem',"r"); 
	$priv_key=fread($fp,8192); 
	fclose($fp);
	$res = openssl_get_privatekey($priv_key);
	
	$encryptedviaprivatekey = ssl_encrypt($xml,'private',$res);
	
	return base64_encode($encryptedviaprivatekey);
}
?>