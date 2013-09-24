<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); 
class CI_Question {
	var $questionData = Array();
	function __construct($data) {
		// parent :: construct();
		$this->questionData =$data;
	}
	
	function setQuestion ($data) {
		$this->questionData ="sdfsfsd";
	}
	
	function getQuestion () {
		// $this->questionData ="sdfsfsd";
		return $this->questionData;
	}
}