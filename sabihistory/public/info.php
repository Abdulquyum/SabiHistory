<?php

header('Content-Type: text/plain; charset=UTF-8');

echo 'PHP Version: ' . PHP_VERSION . PHP_EOL;
echo 'SAPI: ' . PHP_SAPI . PHP_EOL;
echo 'Loaded INI: ' . (php_ini_loaded_file() ?: 'none') . PHP_EOL;
echo 'phpinfo available: ' . (function_exists('phpinfo') ? 'yes' : 'no') . PHP_EOL;