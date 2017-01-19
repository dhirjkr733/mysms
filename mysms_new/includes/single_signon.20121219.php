<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/nusoap-0.9.5/lib/nusoap.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/includes/xmlparser.php');

define('PROXY_HOST', '');
define('PROXY_PORT', '');
define('PROXY_USERNAME', '');
define('PROXY_PASSWORD', '');
define('USE_CURL', true);
define('USE_WSDL',true);
//define('WSDL_URL','http://acctvalcms.beta.smscorp.com/CMSValidation.svc?wsdl');
define('WSDL_URL','https://AcctValCMS.smscorp.com/CMSValidation.svc?wsdl');
//define('SERVICES_URL','http://acctvalcms.beta.smscorp.com/CMSValidation.svc') ;

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
			
			/*
			print_r( $data );
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
		}
	}

	/*
	if ($err) {
		echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
	}*/
	return $user_info;
}
?>