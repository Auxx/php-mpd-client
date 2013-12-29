<?php

require_once realpath(dirname(__FILE__)).DIRECTORY_SEPARATOR.'php_mpd_client.php';

class PhpMpdManager {
	protected $client, $wrappers = array();

	const STATUS_WRAPPER = 'status';
	const PLAYBACK_OPTS_WRAPPER = 'playbackOptions';
	const PLAYBACK_WRAPPER = 'playback';
	const PLAYLIST_WRAPPER = 'playlist';

	function __construct(PhpMpdClient $client) {
		$this->client = $client;
	}

	function __get($name) {
		switch($name) {
			case self::STATUS_WRAPPER:
			case self::PLAYBACK_OPTS_WRAPPER:
			case self::PLAYBACK_WRAPPER:
			case self::PLAYLIST_WRAPPER:
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
			case self::PLAYBACK_WRAPPER: return(new MpdPlaybackWrapper($this->client));
			case self::PLAYLIST_WRAPPER: return(new MpdPlaylistWrapper($this->client));
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

class MpdPlaybackWrapper extends MpdCommandsWrapper {
	function next() {
		return($this->client->execute(new MpdCmdNext()));
	}

	function pause($enabled) {
		return($this->client->execute(new MpdCmdPause($enabled)));
	}

	function play($id) {
		return($this->client->execute(new MpdCmdPlay($id)));
	}

	function playById($id) {
		return($this->client->execute(new MpdCmdPlayId($id)));
	}

	function previous() {
		return($this->client->execute(new MpdCmdPrevious()));
	}

	function seek($id, $time) {
		return($this->client->execute(new MpdCmdSeek($id, $time)));
	}

	function seekById($id, $time) {
		return($this->client->execute(new MpdCmdSeekId($id, $time)));
	}

	function seekCurrent($time) {
		return($this->client->execute(new MpdCmdSeekCurrent($id, $time)));
	}

	function stop() {
		return($this->client->execute(new MpdCmdStop()));
	}
}

class MpdPlaylistWrapper extends MpdCommandsWrapper {
	function add($uri) {
		return($this->client->execute(new MpdCmdAdd($uri)));
	}

	function addWithId($uri, $position = null) {
		return($this->client->execute(new MpdCmdAddId($uri, $position)));
	}

	function clear() {
		return($this->client->execute(new MpdCmdClear()));
	}

	function delete($start, $end = null) {
		return($this->client->execute(new MpdCmdDelete($start, $end)));
	}

	function deleteById($id) {
		return($this->client->execute(new MpdCmdDeleteId($id)));
	}

	function move($start, $to, $end = null) {
		return($this->client->execute(new MpdCmdMove($start, $to, $end)));
	}

	function moveById($id, $to) {
		return($this->client->execute(new MpdCmdMoveId($id, $to)));
	}

	function find($tag, $needle) {
		return($this->client->execute(new MpdCmdPlaylistFind($tag, $needle)));
	}

	function getExtendedInfo($id = null) {
		return($this->client->execute(new MpdCmdPlaylistId($id)));
	}

	function getInfo($start = null, $end = null) {
		return($this->client->execute(new MpdCmdPlaylistInfo($start, $end)));
	}
}

?>