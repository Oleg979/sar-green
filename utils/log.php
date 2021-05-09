<?php
function writeToServerLog($text) {
    // Пишем в логи, чтобы потом удобнее было отлаживать
    $file = 'logs/admin.log';
    $current = file_get_contents($file);
    $current .= date("M,d,Y h:i:s A")."\n";
    $current .= $text;
    $current .= "\n\n";
    file_put_contents($file, $current);
}