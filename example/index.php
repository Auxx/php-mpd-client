<?php

include '../src/php_mpd_client.php';

$client = new PhpMpdClient();
echo 'Is connected: '.($client->isConnected() ? 'TRUE' : 'FALSE')."\n";

$command = new MpdCommand('status', array(123, 'abc', 'huj "vam!'));
echo $command->makeQuery()."\n";

?>