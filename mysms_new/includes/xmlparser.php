<?php
/**
* @desc XML utility class: parsing XML string and returns an equivalent PHP data structure.
*/
class XmlParser
{
	var $m_data;
	var $m_parser;			// a reference to the XML parser
	var $m_document;		// the entire XML structure built up so far
	var $m_parent;   		// a pointer to the current parent - the parent will be an array
	var $m_stack;    		// a stack of the most recent m_parent at each nesting level
	var $last_opened_tag;

	function XmlParser() {
	}
	/**
	* @desc parsing XML string and returns an equivalent PHP data structure
	* @param string $xml the xml string
	* @return Mix array if success else false
	*/
	function parse(&$xml){
 		$this->m_parser = &xml_parser_create();
		xml_parser_set_option($this->m_parser, XML_OPTION_CASE_FOLDING, false);
		xml_set_object($this->m_parser, $this);
		xml_set_element_handler($this->m_parser, 'startElemnent', 'endElement');
		xml_set_character_data_handler($this->m_parser, 'data');
		$this->m_document = array();
		$this->m_stack    = array();
		$this->m_parent   = &$this->m_document;
		xml_parse($this->m_parser, $xml, true);
		xml_parser_free($this->m_parser);
		return $this->m_document;
	}
	function startElemnent(&$m_parser, $tag, $attributes){
		$this->m_data = '';
		$this->last_opened_tag = $tag;

		// if you've seen this tag before
		if(is_array($this->m_parent) && array_key_exists($tag, $this->m_parent)) { 
			// if the keys are numeric
			if (is_array($this->m_parent[$tag]) && array_key_exists(0,$this->m_parent[$tag])) {
				// this is the third or later instance of $tag we've come across
				$key = count(array_filter(array_keys($this->m_parent[$tag]), 'is_numeric'));
			} else {
				// this is the second instance of $tag that we've seen. shift around
				if (array_key_exists("$tag attr",$this->m_parent)) {
					$arr = array('0 attr'=>&$this->m_parent["$tag attr"], &$this->m_parent[$tag]);
					unset($this->m_parent["$tag attr"]);
				} else {
					$arr = array(&$this->m_parent[$tag]);
				}
				$this->m_parent[$tag] = &$arr;
				$key = 1;
			}
			$this->m_parent = &$this->m_parent[$tag];
		} else {
			$key = $tag;
		}
		if($attributes) $this->m_parent["$key attr"] = $attributes;
		$this->m_parent  = &$this->m_parent[$key];
		$this->m_stack[] = &$this->m_parent;
	}
	function endElement(&$m_parser, $tag){
		if($this->last_opened_tag == $tag){
			$this->m_parent = $this->m_data;
			$this->last_opened_tag = NULL;
		}
		array_pop($this->m_stack);
		if($this->m_stack) $this->m_parent = &$this->m_stack[count($this->m_stack)-1];
	}
	function data(&$m_parser, $data){
		// you don't need to store whitespace in between tags
		if($this->last_opened_tag != NULL)
			$this->m_data .= $data;
	}
	/*
	function __destruct() {
		unset($this->m_stack);
		unset($this->m_parent);
		unset($this->m_data);
		unset($this->m_parser);
		unset($this->last_opened_tag);
	}
	*/
}

?>