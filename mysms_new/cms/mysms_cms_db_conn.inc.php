<?php
//$db_name = "mysms3_db";
//$db_conn = mysql_connect('localhost','dbsms3','exdb4mysms2') or die ($die_mesg.mysql_error());
//mysql_select_db($db_name,$db_conn) or die ($die_mesg.mysql_error());

$db_name = "mysms";
$db_conn = mysql_connect('localhost','root','root') or die ($die_mesg.mysql_error());
mysql_select_db($db_name,$db_conn) or die ($die_mesg.mysql_error());

?>

<?php
//$servername = "localhost";
//$username = "root";
//$password = "root";
//$db_name = "mysms";
//
//// Create connection
////$db_conn = new mysqli($servername, $username, $password);
//$db_conn = mysql_connect($servername, $username, $password);
//mysql_select_db($db_name,$db_conn) or die ($die_mesg.mysql_error());
//
//// Check connection
//if ($db_conn->connect_error) {
//    die("Connection failed: " . $db_conn->connect_error);
//} 
////echo "Connected successfully";
?>