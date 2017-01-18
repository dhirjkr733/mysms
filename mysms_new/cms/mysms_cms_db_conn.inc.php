<?php
$db_name = "mysms3_db";
$db_conn = mysql_connect('localhost','dbsms3','exdb4mysms2') or die ($die_mesg.mysql_error());
mysql_select_db($db_name,$db_conn) or die ($die_mesg.mysql_error());
?>
