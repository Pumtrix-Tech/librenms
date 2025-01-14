<?php

$name = 'ss';
$colours = 'psychedelic';
$scale_min = 0;
$polling_type = 'app';
$unit_text = 'Status';
$unitlen = 7;
$bigdescrlen = 20;
$smalldescrlen = 20;

$rrd_list = [];

foreach (array_keys($rrdArray) as $socket_type) {
    $rrd_filename = Rrd::name($device['hostname'], [
        $polling_type,
        $name,
        $app->app_id,
        $socket_type,
    ]);

    if (Rrd::checkRrdExists($rrd_filename)) {
        $i = 0;
        foreach ($rrdArray[$socket_type] as $socket_status => $socket_status_desc) {
            $rrd_list[$i]['filename'] = $rrd_filename;
            $rrd_list[$i]['descr'] = $socket_status_desc['descr'];
            $rrd_list[$i]['ds'] = $socket_status;
            $i++;
        }
    } else {
        d_echo('RRD ' . $rrd_filename . ' not found');
    }
}

require 'includes/html/graphs/generic_multi_line_exact_numbers.inc.php';
