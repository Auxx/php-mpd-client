<?php

class MpdException extends Exception {
	protected $mpdLine, $mpdCommand;

	function __construct(string $message = '', int $code = 0, int $mpdLine = 0, string $mpdCommand = '', Exception $previous = NULL) {
		parent::__construct($message, $code, $previous);
		$this->mpdLine = $mpdLine;
		$this->mpdCommand = $mpdCommand;
	}

	function getMpdLine() { return($this->mpdLine); }
	function getMpdCommand() { return($this->mpdCommand); }
}

?>