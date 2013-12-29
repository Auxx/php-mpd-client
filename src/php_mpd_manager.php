<?php

class PhpMpdManager {
	protected $client, $wrappers = array();

	const STATUS_WRAPPER = 'status';

	function __construct(PhpMpdClient $client) {
		$this->client = $client;
	}

	function __get($name) {
		switch($name) {
			case self::STATUS_WRAPPER:
				return($this->getWrapper($name));
		}
	}

	protected function getWrapper($name) {
		if(!isset($this->wrappers[$name])) {
			$this->wrappers[$name] = $this->initWrapper($name);
		}
	}

	protected function initWrapper($name) {
		switch($name) {
			case self::STATUS_WRAPPER: return(new MpdStatusWrapper($this->client));
		}
	}
}

class MpdStatusWrapper {
	protected $client;

	function __construct(PhpMpdClient $client) {
		$this->client = $client;
	}

	function clearError() {
		return($this->client->execute(new MpdCmdClearError()));
	}

	function getCurrentSong() {
		return($this->client->execute(new MpdCmdCurrentSong()));
	}

	function getStatus() {
		return($this->client->execute(new MpdCmdStatus()));
	}

	function getStats() {
		return($this->client->execute(new MpdCmdStats()));
	}
}

?>