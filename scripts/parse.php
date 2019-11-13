#!/usr/bin/env php
<?php

use route1rodent\SwordShieldData\PokemonParser;

require_once __DIR__ . '/../bootstrap.php';

$pokemonParser = new PokemonParser();
$pokemonParser->export();