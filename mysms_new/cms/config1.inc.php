<?php

// Configuration File
// Client: Test
// Date:   110702
// (Variable order is important and often dependent!)

// needed for >= php4.2
if (!empty($_REQUEST)) { while(list($name, $value) = each($_REQUEST)) { $$name = $value; } }
if (!empty($_SESSION)) { while(list($name, $value) = each($_SESSION)) { $$name = $value; } }
$PHP_SELF = $_SERVER["PHP_SELF"];

// Support info
$tech_sup_email = "support@calibermg.com";
$tech_sup_phone = "949-266-2853";
$die_mesg = "Ooops! Database problem...please report the error below to <A HREF=\"mailto:$tech_sup_email\">$tech_sup_email</A> or $tech_sup_phone. Thanks for helping us help you!<BR><BR>Database Error = ";
$contact_support = "Ooops! Please report the error below to <A HREF=\"mailto:$tech_sup_email\">$tech_sup_email</A> or $tech_sup_phone. Thanks for helping us help you!";
// Absolute path for includes
//$abs_path = "/var/www/vhosts/mysms.firstamsms.com/httpdocs/cms/";
  $abs_path = "/var/www/html/mysms/cms/";
// Http path
//$remote_path = "http://mysms.firstamsms.com/cms/";
$remote_path = "http://local.mysms/cms/";
// MySQL connection
include($abs_path."mysms_cms_db_conn.inc.php");

// cookie domain
//$cookie_domain = ".marketingtechnology.com";
//$cookie_domain = "64.227.74.218";
//$cookie_domain = ".bodyglove.com";
$cookie_domain = $_SERVER["HTTP_HOST"];

// Organization Name used with copyright in footer
$org_name = "Caliber Media Group";

// Organization Website (no http://, just host.domain.tld) used with copyright in footer
$org_site = "www.calibermg.com";

// Global page title
$page_title = "First American SMS CMS";

// Global application title
$app_title = "iControl  CONTENT  MANAGEMENT  SYSTEM";

// HTML Header to use
$header = $abs_path."header1.inc.php";

// HTML Footer to use
$footer = $abs_path."footer1.inc.php";

// Navigation to use
$nav = $abs_path."nav1.inc.php";

// Style Sheet to use
$style_sheet = "style1.css";

// Authorization Header to use
$auth_header = $abs_path."auth_header.inc.php";

// Encrypt salt
$crypt_pass = "cR8ZyGI";

// Formtools to use
$formtools = $abs_path."formtools.inc.php";

// Displaytools to use
$displaytools = $abs_path."displaytools.inc.php";

// Path to cms images
$path_sys_images = "/images/";

// Path to uploaded images
$path_images = "images/";

// Path to articles
$path_articles = "../cms/articles/";

// Path to pdfs
$path_pdf = "../cms/pdf/";

// MAX_FILE_SIZE for image upload
$max_file_size = (1024*1024)*2; // 2mb

// Welcome Message, comment out to disable
$welcome_msg = "iControl for MySMS.";

// time offset from server (EST) in seconds
$s_time_offset = -10800;

// time zone of client
$c_time_zone = "PST";

// Alternate Edit Trigger - phrase in page title used to bypass standard editing page and go to another
$alt_edit = "List";

// Alternate Include - allows for additional customization without messing up basic CMS, must be called explicitly on pages that require it, not used by default
$alt_inc = "../ldb.inc.php";

// Generic delimiter used to safely separate string values, may be used in other related includes (search all files!)
$delimiter = "<!--#DL#-->";

// How long in seconds until logging out users and redirecting to logout page - comment this out and users will not be logged out
$logout_time = 600;

// Amount of time in between user verifications - in seconds - set to zero to always verify
$reverify_time = 300;
//$reverify_time = 60;

// Time till login_display cookie expires in seconds
$login_exp = 5184000; // 60 days

// TD main background color
$td_bg_color = "#CCCCCC";

// TD content field background color
$td_bg_color2 = "#DADADA";

// TD background color when error
$td_bg_error = "#CC3333";

// Default number of empty data entry fields or set of fields
$default_blanks = 3;

// Default number of empty data entry fields or set of fields, shouldn't be over 255 characters
//$filters = array ("Surf","Wake","Swimwear/Apparel","Dive","Snow","Technology/Wireless");
$filters = array();

$country_list = array("Afghanistan","Albania","Algeria","American Samoa","Andorra","Angola","Anguilla","Antarctica","Antigua / Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia / Herzegowina","Botswana","Bouvet Island","Brazil","British Indian Ocean Territory","Brunei Darussalam","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central African Republic","Chad","Chile","China","Christmas Island","Cocos (Keeling) Islands","Colombia","Comoros","Congo","Cook Islands","Costa Rica","Cote D'Ivoire","Croatia","Cuba","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","East Timor","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","France, Metropolitan","French Guiana","French Polynesia","French Southern Territories","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guadeloupe","Guam","Guatemala","Guinea","Guinea-Bissau","Guyana","Haiti","Heard / Mc Donald Islands","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Israel","Italy","Jamaica","Japan","Jordan","Kazakhstan","Kenya","Kiribati","Kuwait","Kyrgyzstan","Lao People's Republic","Latvia","Lebanon","Lesotho","Liberia","Libyan Arab Jamahiriya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Martinique","Mauritania","Mauritius","Mayotte","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauru","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","Niue","Norfolk Island","North Korea","Northern Mariana Islands","Norway","Oman","Pakistan","Palau","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Pitcairn","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russian Federation","Rwanda","Saint Kitts / Nevis","Saint Lucia","Saint Vincent / The Grenadines","Samoa","San Marino","Sao Tome / Principe","Saudi Arabia","Senegal","Serbia & Montenegro","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Georgia / Sandwich Isle","South Korea","Spain","Sri Lanka","St Helena","St Pierre / Miquelon","Sudan","Suriname","Svalbard / Jan Mayen Islands","Swaziland","Sweden","Switzerland","Syrian Arab Republic","Taiwan","Tajikistan","Tanzania","Thailand","Togo","Tokelau","Tonga","Trinidad / Tobago","Tunisia","Turkey","Turkmenistan","Turks / Caicos Islands","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","U.S.A","U.S. Outlying Islands","Uruguay","Uzbekistan","Vanuatu","Vatican City State","Venezuela","Viet Nam","Virgin Islands (British)","Virgin Islands (U.S.)","Wallis / Futuna Islands","Western Sahara","Yemen","Zaire","Zambia","Zimbabwe","Other-Not Shown");

$state_list = array("AK"=>"AK-Alaska","AL"=>"AL-Alabama","AR"=>"AR-Arkansas","AZ"=>"AZ-Arizona","CA"=>"CA-California","CO"=>"CO-Colorado","CT"=>"CT-Connecticut","DC"=>"DC-Washington D.C.","DE"=>"DE-Delaware","FL"=>"FL-Florida","GA"=>"GA-Georgia","HI"=>"HI-Hawaii","IA"=>"IA-Iowa","ID"=>"ID-Idaho","IL"=>"IL-Illinois","IN"=>"IN-Indiana","KS"=>"KS-Kansas","KY"=>"KY-Kentucky","LA"=>"LA-Louisiana","MA"=>"MA-Massachusetts","MD"=>"MD-Maryland","ME"=>"ME-Maine","MI"=>"MI-Michigan","MN"=>"MN-Minnesota","MO"=>"MO-Missouri","MS"=>"MS-Mississippi","MT"=>"MT-Montana","NC"=>"NC-North Carolina","ND"=>"ND-North Dakota","NE"=>"NE-Nebraska","NH"=>"NH-New Hampshire","NJ"=>"NJ-New Jersey","NM"=>"NM-New Mexico","NV"=>"NV-Nevada","NY"=>"NY-New York","OH"=>"OH-Ohio","OK"=>"OK-Oklahoma","OR"=>"OR-Oregon","PA"=>"PA-Pennsylvania","PR"=>"PR-Puerto Rico","RI"=>"RI-Rhode Island","SC"=>"SC-South Carolina","SD"=>"SD-South Dakota","TN"=>"TN-Tennessee","TX"=>"TX-Texas","UT"=>"UT-Utah","VA"=>"VA-Virginia","VT"=>"VT-Vermont","WA"=>"WA-Washington","WI"=>"WI-Wisconsin","WV"=>"WV-West Virginia","WY"=>"WY-Wyoming");

$hide_page = "Training Facility Driving Directions List, Training Facility Nearest Hotel List, Representative Region List";

?>