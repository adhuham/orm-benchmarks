<?php

require dirname(__FILE__) . '/Eloquent.php';

$time = microtime(true);
$memory = memory_get_usage();
$test = new Eloquent();
$test->initialize();

$test->run();
echo sprintf(" %11s | %6.2f |", (memory_get_usage() - $memory), (microtime(true) - $time));
