<?php

class MpdCmdClearError extends MpdCommand {
	function __construct() {
		parent::__construct('clearerror');
	}
}

class MpdCmdCurrentSong extends MpdCommand {
	function __construct() {
		parent::__construct('currentsong');
	}
}

class MpdCmdStatus extends MpdCommand {
	function __construct() {
		parent::__construct('status');
	}
}

class MpdCmdStats extends MpdCommand {
	function __construct() {
		parent::__construct('stats');
	}
}

?>