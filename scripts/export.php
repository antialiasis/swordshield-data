#!/usr/bin/env php
<?php

require_once __DIR__ . '/bootstrap.php';

$exporter = new class()
{
    private const SRC_DIR = __DIR__ . '/../data/raw';
    private const DEST_DIR = __DIR__ . '/../data/parsed';
};