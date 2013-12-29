<?php

include '../src/php_mpd_client.php';

$client = new PhpMpdClient();
echo 'Is connected: '.($client->isConnected() ? 'TRUE' : 'FALSE')."\n";

$client->execute(new MpdCmdClearError());
$cs = new MpdCmdCurrentSong();
$client->execute($cs);
$client->execute(new MpdCmdStats());
$client->execute(new MpdCmdStatus());

echo "---\n\n";
echo "Artist: ".$cs->artist;

//$client->execute(new MpdCommand('status'));
//try {
//	$client->execute(new MpdCommand('penis', array(1)));
//}
//catch(Exception $e) {
//	print_r($e);
//}

?>