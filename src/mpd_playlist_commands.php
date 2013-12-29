<?php

class MpdCmdAdd extends MpdCommand {
	function __construct($uri) {
		parent::__construct('add', array($uri));
	}
}

class MpdCmdAddId extends MpdCommand {
	function __construct($uri, $position = null) {
		$args = array($uri);
		if($position !== null) {
			$args[] = $position;
		}
		parent::__construct('add', $args);
	}
}

class MpdCmdClear extends MpdCommand {
	function __construct() {
		parent::__construct('clear');
	}
}

class MpdCmdDelete extends MpdCommand {
	function __construct($start, $end = null) {
		parent::__construct('delete', array($end === null ? $start : $start.':'.$end));
	}
}

class MpdCmdDeleteId extends MpdCommand {
	function __construct($id) {
		parent::__construct('deleteid', array($id));
	}
}

class MpdCmdMove extends MpdCommand {
	function __construct($start, $to, $end = null) {
		parent::__construct('move', array($end === null ? $start : $start.':'.$end, $to));
	}
}

class MpdCmdMoveId extends MpdCommand {
	function __construct($id, $to) {
		parent::__construct('moveid', array($id));
	}
}

class MpdCmdPlaylistFind extends MpdCommand {
	function __construct($tag, $needle) {
		parent::__construct('playlistfind', array($tag, $needle));
	}
}

class MpdCmdPlaylistId extends MpdCommand {
	function __construct($id) {
		parent::__construct('playlistid', array($id));
	}
}

class MpdCmdPlaylistInfo extends MpdCommand {
	function __construct($start, $end = null) {
		parent::__construct('playlistinfo', array($end === null ? $start : $start.':'.$end));
	}
}

?>