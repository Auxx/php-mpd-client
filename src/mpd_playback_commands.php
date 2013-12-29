<?php

class MpdCmdNext extends MpdCommand {
	function __construct() {
		parent::__construct('next');
	}
}

class MpdCmdPause extends MpdCommand {
	function __construct($enabled) {
		parent::__construct('pause', array($enabled ? 1 : 0));
	}
}

class MpdCmdPlay extends MpdCommand {
	function __construct($id) {
		parent::__construct('play', array($id));
	}
}

class MpdCmdPlayId extends MpdCommand {
	function __construct($id) {
		parent::__construct('playid', array($id));
	}
}

class MpdCmdPrevious extends MpdCommand {
	function __construct() {
		parent::__construct('previous');
	}
}

class MpdCmdSeek extends MpdCommand {
	function __construct($id, $time) {
		parent::__construct('seek', array($id, $time));
	}
}

class MpdCmdSeekId extends MpdCommand {
	function __construct($id, $time) {
		parent::__construct('seekid', array($id, $time));
	}
}

class MpdCmdSeekCurrent extends MpdCommand {
	function __construct($time) {
		parent::__construct('seekcur', array($time));
	}
}

class MpdCmdStop extends MpdCommand {
	function __construct() {
		parent::__construct('stop');
	}
}

?>