<?php

class MpdCommand {
	protected $command, $arguments;

	function __construct(string $command = '', array $arguments = array()) {
		$this->command = $command;
		$this->arguments = $arguments;
	}

	function setCommand(string $command) {	$this->command = $command; }
	function getCommand() {	return($this->command); }
	function getArguments() {	return($this->arguments); }

	function setArguments(mixed $arguments) {
		if(is_array($arguments)) {
			$this->arguments = $arguments;
		}
		else {
			$this->arguments = array($arguments);
		}
	}

	function addArguments(mixed $arguments) {
		if(is_array($arguments)) {
			$this->arguments = array_merge($this->arguments, $arguments);
		}
		else {
			$this->arguments[] = $arguments;
		}
	}

	function escape(string $string) {
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

	function processResponse(array $response) {
		// TODO
	}
}

?>