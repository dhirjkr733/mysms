<?php
// define constants
define("APPLICATION_HOME_PAGE","http://mysms.firstamsms.com/index.php");
define("APPLICATION_ADMIN_HOME_PAGE","http://mysms.firstamsms.com/admin/index.php");
define("EXTRANET_HOME_PAGE","http://mysms.firstamsms.com/extranet/index.php");
define("FTP_TEMP_DIR","/var/www/vhosts/mysms.firstamsms.com/httpdocs/extranet/downloads/temp/");
define("UPLOADED_FILES_TEMP_DIR","/var/www/vhosts/mysms.firstamsms.com/httpdocs/extranet/uploads/temp/");
define("DEBUG_EMAIL",'karl@calibermg.com'); // application errors go here
// db connection info
define("DATABASE","mysms3_db"); // db name
define("DATABASE_USER","dbsms3"); // db username
define("DATABASE_PASS","exdb4mysms2"); // db password
define("DATABASE_HOST","localhost"); // db location i.e. "localhost" or "www.calibermediagroup.com" or ip address
// salt for db encryption;
define("SALT","cR8ZyGI");
// ibroadcast db connection info
define("IB_DATABASE","firstam_db"); // db name
define("IB_DATABASE_USER","mlfirstam"); // db username
define("IB_DATABASE_PASS","maildb4firstam"); // db password
define("IB_DATABASE_HOST","204.232.157.138"); // db location i.e. "localhost" or "www.calibermediagroup.com" or ip address
// end define constants
// begin define global arrays
$CALIFORNIA_COUNTIES_ARRAY = Array(
	'Northern California',
	'Imperial County',
	'Kern County',
	'Los Angeles County',
	'Orange County',
	'Riverside County',
	'San Bernardino County',
	'San Diego County',
	'San Luis Obispo County',
	'Santa Barbara County',
	'Ventura County'
	);
$REGISTRATION_STATUS_ARRAY = Array(
	'Pending',
	'Approved',
	'Credit Hold',
	'Inactive',
	'Denied',
	'Profile Update'
	);
$FTP_TYPE_ARRAY = Array(
	'Check Samples',
	'FAQ',
	'Reports',
	'Software Upgrade',
	'Supplemental Training',
	'Tips',
	'Training Manual',
	'Tutorial'
	);
$STATE_ARRAY = array(
	"AK"=>"Alaska",
	"AL"=>"Alabama",
	"AZ"=>"Arizona",
	"AR"=>"Arkansas",
	"CA"=>"California",
	"CO"=>"Colorado",
	"CT"=>"Connecticut",
	"DE"=>"Delaware",
	"FL"=>"Florida",
	"GA"=>"Georgia",
	"HI"=>"Hawaii",
	"ID"=>"Idaho",
	"IL"=>"Illinois",
	"IN"=>"Indiana",
	"IA"=>"Iowa",
	"KS"=>"Kansas",
	"KY"=>"Kentucky",
	"LA"=>"Louisiana",
	"ME"=>"Maine",
	"MD"=>"Maryland",
	"MA"=>"Massachusetts",
	"MI"=>"Michigan",
	"MN"=>"Minnesota",
	"MS"=>"Mississippi",
	"MO"=>"Missouri",
	"MT"=>"Montana",
	"NE"=>"Nebraska",
	"NV"=>"Nevada",
	"NH"=>"New Hampshire",
	"NJ"=>"New Jersey",
	"NM"=>"New Mexico",
	"NY"=>"New York",
	"NC"=>"North Carolina",
	"ND"=>"North Dakota",
	"OH"=>"Ohio",
	"OK"=>"Oklahoma",
	"OR"=>"Oregon",
	"PA"=>"Pennsylvania",
	"PR"=>"Puerto Rico",
	"RI"=>"Rhode Island",
	"SC"=>"South Carolina",
	"SD"=>"South Dakota",
	"TN"=>"Tennessee",
	"TX"=>"Texas",
	"UT"=>"Utah",
	"VT"=>"Vermont",
	"VA"=>"Virginia",
	"WA"=>"Washington",
	"DC"=>"Washington D.C.",
	"WV"=>"West Virginia",
	"WI"=>"Wisconsin",
	"WY"=>"Wyoming"
	);
// end define global arrays
?>