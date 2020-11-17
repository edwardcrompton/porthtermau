<?php
/**
 * Usage:
 * PORTHTERMAU_API_KEY='KEY_HERE' php tests/index.php
 */
include('src/PorthTermau/PorthTermauWrapper.php');

$api = new PorthTermau\PorthTermauWrapper(['referer' => 'http://llennatur.cymru']);

echo $api->translateTerm('en', 'Vulpes vulpes') . "\n";
echo $api->translateTerm('cy', 'Vulpes vulpes') . "\n";
