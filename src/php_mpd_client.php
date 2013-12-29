<?php

require_once realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR.'mpd_exception.php';
require_once realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR.'mpd_command.php';

class PhpMpdClient {
	const PROTOCOL_TCP = 'tcp';
	const PROTOCOL_UDP = 'udp';

	const DEFAULT_HOST = 'localhost';
	const DEFAULT_POST = 6600;
	const DEFAULT_PROTOCOL = self::PROTOCOL_TCP;

	const READ_BUFFER_SIZE = 1024;

	const MPD_LINE_ENDING = "\n";
	const MPD_OK = 'OK';
	const MPD_SIGN = 'MPD';
	const MPD_ACK = 'ACK';
	const MPD_DELIMITER = ' ';

	protected $host, $port, $protocol, $socket = false,
	          $mpdProtocolVersion;

	function __construct($host = self::DEFAULT_HOST, $port = self::DEFAULT_POST, $autoConnect = true) {
		$this->host = $host;
		$this->port = $port;
		$this->protocol = self::DEFAULT_PROTOCOL;
		if($autoConnect) {
			$this->connect();
		}
	}

	function __destruct() {
		$this->disconnect();
	}

	function setProtocol($protocol) {	$this->protocol = $protocol; }
	function setHost($host) {	$this->host = $host; }
	function setPort($port) {	$this->port = $port; }

	function getProtocol() { return($this->protocol); }
	function getHost() { return($this->host); }
	function getPort() { return($this->port); }

	function connect() {
		$this->socket = stream_socket_client("{$this->protocol}://{$this->host}:{$this->port}", $errorNumber, $errorMessage);
		if($this->socket === false) {
			throw new UnexpectedValueException($errorMessage, $errorNumber);
		}

		$response = $this->readLine();
		if(strlen($response) > 0) {
			$array = explode(self::MPD_DELIMITER, $response);
			if(count($array) === 3 && $array[0] === self::MPD_OK && $array[1] === self::MPD_SIGN) {
				$this->mpdProtocolVersion = $array[2];
				return;
			}
		}

		// Got here? Aw, we have problems...
		$this->socket = false;
		throw new InvalidArgumentException('Service is not MPD');
	}

	function connect_silent() {
		try {
			$this->connect();
			return(true);
		}
		catch(UnexpectedValueException $e) {
			return(false);
		}
	}

	function disconnect() {
		if($this->isConnected()) {
			fclose($this->socket);
			$this->socket = false;
		}
	}

	function isConnected() {
		return($this->socket !== false);
	}

	function execute(MpdCommand $command) {
		fwrite($this->socket, $command->makeQuery());
		$command->processResponse($this->readResponse());
	}

	protected function readLine() {
		if($this->socket === false) {
			// TODO Move magic string to constant
			throw new InvalidArgumentException("Not connected.");
		}

		$buffer = '';
		$continue = true;
		do {
			$line = stream_get_line($this->socket, self::READ_BUFFER_SIZE, self::MPD_LINE_ENDING);
			if($line === false || strlen($line) === 0) {
				$continue = false;
			}
			else {
				$buffer .= $line;
				$continue = strlen($line) === self::READ_BUFFER_SIZE;
			}
		} while($continue);

		return($buffer);
	}

	protected function readResponse() {
		$response = array();
		$continue = true;
		do {
			$line = $this->readLine();
			if($line === self::MPD_OK) {
				$continue = false;
			}
			else if(strpos($line, self::MPD_ACK) === 0) {
				$continue = false;
				$array = explode(self::MPD_DELIMITER, $line, 4);
				$codeAndLine = explode("@", $array[1]);
				throw new MpdException($array[3], substr($codeAndLine[0], 1), substr($codeAndLine[1], 0, -1), substr($array[2], 1, strlen($array[2] - 2)));
			}
			else {
				$response[] = $line;
			}
		} while($continue);
		return($response);
	}
}

?>
