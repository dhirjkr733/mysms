<?php
$mydate=date("Y-m-d");
$filename=$_GET['f'];
$dfilename=str_replace(".csv","-$mydate.csv",$filename);
header("Content-Type:application/force-download");
header("Content-Length:".filesize($filename));
header("Content-Disposition:attachment;filename=$dfilename");
readfile($filename);
exit;
?>

