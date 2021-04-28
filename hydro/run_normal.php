<?php

require dirname(__FILE__) . '/Hydro.php';

$time = microtime(true);
$memory = memory_get_usage();
$test = new Hydro();
$test->initialize();

$test->run();
echo sprintf(" %11s | %6.2f |", (memory_get_usage() - $memory), (microtime(true) - $time));
