<?php

include('src/PorthTermau.php');

$api = new PorthTermau\PorthTermauWrapper(['key' => '', 'referer' => 'http://llennatur.cymru']);

$api->translateTerm('en', 'Vulpes vulpes');

