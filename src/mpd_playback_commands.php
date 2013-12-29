<?php

class MpdCmdConsume extends MpdCommand {
	function __construct($enabled) {
		parent::__construct('consume', array($enabled ? 1 : 0));
	}
}

class MpdCmdCrossfade extends MpdCommand {
	function __construct($seconds) {
		parent::__construct('crossfade', array($seconds));
	}
}

class MpdCmdMixRampDB extends MpdCommand {
	function __construct($db) {
		parent::__construct('mixrampdb', array($db));
	}
}

class MpdCmdMixRampDelay extends MpdCommand {
	function __construct($seconds) {
		parent::__construct('mixrampdelay', array($seconds));
	}
}

class MpdCmdRandom extends MpdCommand {
	function __construct($enabled) {
		parent::__construct('random', array($enabled ? 1 : 0));
	}
}

class MpdCmdRepeat extends MpdCommand {
	function __construct($enabled) {
		parent::__construct('repeat', array($enabled ? 1 : 0));
	}
}

class MpdCmdSetVolume extends MpdCommand {
	function __construct($volume) {
		parent::__construct('setvol', array($volume));
	}
}

class MpdCmdSingle extends MpdCommand {
	function __construct($enabled) {
		parent::__construct('single', array($enabled ? 1 : 0));
	}
}

class MpdCmdReplayGainMode extends MpdCommand {
	const OFF = 'off';
	const TRACK = 'track';
	const ALBUM = 'album';
	const AUTO = 'auto';

	function __construct($mode) {
		parent::__construct('replay_gain_mode', array($mode));
	}
}

class MpdCmdReplayGainStatus extends MpdCommand {
	function __construct() {
		parent::__construct('replay_gain_status');
	}
}

?>