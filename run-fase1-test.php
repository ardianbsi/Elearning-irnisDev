<?php

// Runner sementara: jalankan phpunit dan tulis ringkasan ke file.
// Hapus file ini setelah verifikasi.

$php = 'C:\\laragon\\bin\\php\\php-8.4.26-Win32-vs17-x64\\php.exe';
$cmd = $php.' vendor/bin/phpunit --log-junit '
    . escapeshellarg(__DIR__.'/storage/logs/junit-fase2.xml')
    . ' 2>&1';

exec($cmd, $output, $exit);

file_put_contents(
    __DIR__.'/storage/logs/fase2-verify.txt',
    'EXIT='.$exit.PHP_EOL.implode(PHP_EOL, $output).PHP_EOL
);

echo 'done exit='.$exit.PHP_EOL;
