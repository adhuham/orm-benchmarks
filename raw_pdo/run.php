<?php

require dirname(__FILE__) . '/RawPdo.php';

$time = microtime(true);
$memory = memory_get_usage();
$test = new RawPdo();
$test->initialize();

$test->run();
echo sprintf(" %11s | %6.2f |", (memory_get_usage() - $memory), (microtime(true) - $time));
