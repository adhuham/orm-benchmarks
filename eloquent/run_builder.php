<?php

require dirname(__FILE__) . '/LaravelBuilder.php';

$time = microtime(true);
$memory = memory_get_usage();
$test = new LaravelBuilder();
$test->initialize();

$test->run();
echo sprintf(" %11s | %6.2f |", (memory_get_usage() - $memory), (microtime(true) - $time));
