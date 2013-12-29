<?php

class MpdException extends Exception {
	protected $mpdLine, $mpdCommand;

	function __construct($message = '', $code = 0, $mpdLine = 0, $mpdCommand = '', Exception $previous = NULL) {
		parent::__construct($message, $code, $previous);
		$this->mpdLine = $mpdLine;
		$this->mpdCommand = $mpdCommand;
	}

	function getMpdLine() { return($this->mpdLine); }
	function getMpdCommand() { return($this->mpdCommand); }
}

?>