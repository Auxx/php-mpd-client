<?php

include '../src/php_mpd_client.php';

$client = new PhpMpdClient();
echo 'Is connected: '.($client->isConnected() ? 'TRUE' : 'FALSE')."\n";

$command = new MpdCommand('status');
$client->execute($command);

?>