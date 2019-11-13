#!/usr/bin/env php
<?php

require_once __DIR__ . '/bootstrap.php';

$pokemonExporter = include __DIR__ . '/exporter-pokemon.php';
$pokemonExporter->export();