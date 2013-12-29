<?php

class MpdCommand {
	protected $command, $arguments;

	function __construct($command = '', $arguments = array()) {
		$this->command = $command;
		$this->arguments = $arguments;
	}

	function setCommand($command) {	$this->command = $command; }
	function getCommand() {	return($this->command); }
	function getArguments() {	return($this->arguments); }

	function setArguments($arguments) {
		if(is_array($arguments)) {
			$this->arguments = $arguments;
		}
		else {
			$this->arguments = array($arguments);
		}
	}

	function addArguments($arguments) {
		if(is_array($arguments)) {
			$this->arguments = array_merge($this->arguments, $arguments);
		}
		else {
			$this->arguments[] = $arguments;
		}
	}

	function escape($string) {
		if(strpos($string, PhpMpdClient::MPD_DELIMITER) !== false) {
			return('"'.  str_replace('"', '\\"', $string).'"');
		}
		else {
			return($string);
		}
	}

	function makeQuery() {
		$query = $this->command;
		foreach($this->arguments as $argument) {
			$query .= PhpMpdClient::MPD_DELIMITER.$this->escape($argument);
		}
		return($query.PhpMpdClient::MPD_LINE_ENDING);
	}

	function processResponse($response) {
		print_r($response);
		// TODO
	}
}

?>