<?php

// Filter Selector
// - config1.inc.php that stores $filters var is needed wherever this include is used

// ADD if not already included, include code

session_start(); // use on all pages that you want session-able, must be before HTML!

// set filter in session
if ($change) {
	$_SESSION['sess_filter'] = $sel_ls;
}

// Filter pulldown
function filter_sel () {
  global $filters, $_SESSION, $PHP_SELF;
  echo "<form action=\"".$PHP_SELF."\" method=\"post\">";
  echo " Show ";
  echo " <SELECT name=\"sel_ls\">\n";
  echo "  <option ";
  if ($_SESSION['sess_filter'] == "") { echo "SELECTED "; }
  echo "value=\"\">ALL</option>\n"; 
  while (list($key,$val) = each($filters)) {
	  echo "  <option value=\"$val\"";
	  if ($val==$_SESSION['sess_filter']) { echo " SELECTED"; }
	  echo ">$val</option>\n";
  }
  echo " </SELECT> \n";
  echo " <input type=\"submit\" name=\"change\" value=\"change\">";
  echo "</form>";
  //echo "SESSION/sess_filter: ".$_SESSION['sess_filter'];
}
?>