<?php

require_once __DIR__ . '/../vendor/autoload.php';

if (false === in_array(\PHP_SAPI, ['cli', 'phpdbg', 'embed'], true)) {
    echo 'Warning: The console should be invoked via the CLI version of PHP, not the ' . \PHP_SAPI . ' SAPI' . \PHP_EOL;
}

set_time_limit(0);

class SwordShieldExporter
{
    public const SRC_DIR = __DIR__ . '/../data/raw';
    public const DEST_DIR = __DIR__ . '/../data/parsed';
}