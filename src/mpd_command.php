<?php

class MpdCommand {
	protected $command, $arguments, $data = array();

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
			if($argument !== null) {
				$query .= PhpMpdClient::MPD_DELIMITER.$this->escape($argument);
			}
		}
		return($query.PhpMpdClient::MPD_LINE_ENDING);
	}

	function processResponse($response) {
		// TODO Fix it!
		print_r($response);

		$this->data = array();
		foreach($response as $line) {
			$array = explode(': ', $line, 2);
			$key = strtolower($array[0]);
			$this->data[$key] = $array[1];
		}
	}

	function getData($key) {
		if(isset($this->data[$key])) {
			return($this->data[$key]);
		}
		else {
			return(null);
		}
	}

	function __get($key) {
		return($this->getData($key));
	}
}

?>