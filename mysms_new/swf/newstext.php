<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');

include_once($_SERVER['DOCUMENT_ROOT'].'/cms/config1.inc.php'); // stores important required info
include_once($displaytools); // required for output
$edit_ary["chunk2"] = array (
		"title"=>"News Scroller",
		"description"=>"News Items list.",		
		"display_type" => array (
			"name"=>"news_scroller",
			"entry_type"=>"edit_one",
			"change_id_label"=>"id",
			"display_label"=>"item",
			"select_existing_default"=>"Select Item...",
			"select_existing_query"=>"SELECT id,heading FROM news_items",
			"heading_color"=>"#000000",
			"display_sort_by_field"=>"heading",
			"link_text"=>"Go"
			),		
		"blanks"=>"1",		
		"table_name"=>"news_items",		
		);
content_display("chunk2","",""); 
?>