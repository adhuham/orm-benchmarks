<?php 

exec('php eloquent/run_eloquent.php', $o1);
exec('php eloquent/run_builder.php', $o2);
exec('php hydro/run_model.php', $o3);
exec('php hydro/run_normal.php', $o4);
exec('php hydro/run_raw.php', $o5);
exec('php raw_pdo/run.php', $o6);

$result = [];

foreach ([$o1, $o2, $o3, $o4, $o5, $o6] as $item) {
    $item = explode('|', $item[0]);
    $test = trim($item[1]);
    $result['Insert'][$test] = trim($item[2]);
    $result['Select'][$test] = trim($item[3]);
    $result['Where'][$test] = trim($item[4]);
    $result['Hydrate'][$test] = trim($item[5]);
    $result['Join'][$test] = trim($item[6]);
    $result['Memory'][$test] = trim($item[7]);
}

foreach ($result as $type => $item) {
    echo '|--------------------------------------------------|' . "\n";
    echo '| ' . $type . ' (Lower is better) ' . "\n";
    echo '|--------------------------------------------------|' . "\n\n";

    $total = array_sum(array_values($item));
    foreach ($item as $test => $value) {
        if ($type == 'Memory') {
            $label = 'm=' . number_format($value);
        } else {
            $label = 't=' . $value . 'ms';
        }

        printf('%-10s %-50s', $label, $test);

        echo "\n";
        echo str_repeat('=', ( ((int) $value) / $total) * 100);
        echo "\n\n";
    }
    echo "\n\n";
}
