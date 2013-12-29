<?php

class PhpMpdManager {
	protected $client, $wrappers = array();

	const STATUS_WRAPPER = 'status';
	const PLAYBACK_OPTS_WRAPPER = 'playbackOptions';

	function __construct(PhpMpdClient $client) {
		$this->client = $client;
	}

	function __get($name) {
		switch($name) {
			case self::STATUS_WRAPPER:
			case self::PLAYBACK_OPTS_WRAPPER:
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
			case self::PLAYBACK_OPTS_WRAPPER: return(new MpdPlaybackOptsWrapper($this->client));
		}
	}
}

class MpdCommandsWrapper {
	protected $client;

	function __construct(PhpMpdClient $client) {
		$this->client = $client;
	}
}

class MpdStatusWrapper extends MpdCommandsWrapper {
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

class MpdPlaybackOptsWrapper extends MpdCommandsWrapper {
	function setConsume($enabled) {
		return($this->client->execute(new MpdCmdConsume($enabled)));
	}

	function setCrossfade($seconds) {
		return($this->client->execute(new MpdCmdCrossfade($seconds)));
	}

	function setMixRampDB($db) {
		return($this->client->execute(new MpdCmdMixRampDB($db)));
	}

	function setMixRampDelay($seconds) {
		return($this->client->execute(new MpdCmdMixRampDelay($seconds)));
	}

	function setRandom($enabled) {
		return($this->client->execute(new MpdCmdRandom($enabled)));
	}

	function setRepeat($enabled) {
		return($this->client->execute(new MpdCmdRepeat($enabled)));
	}

	function setVolume($volume) {
		return($this->client->execute(new MpdCmdSetVolume($volume)));
	}

	function setSingle($enabled) {
		return($this->client->execute(new MpdCmdSingle($enabled)));
	}

	function setReplayGainMode($mode) {
		return($this->client->execute(new MpdCmdReplayGainMode($mode)));
	}

	function getReplayGainMode() {
		return($this->client->execute(new MpdCmdReplayGainStatus()));
	}
}

?>