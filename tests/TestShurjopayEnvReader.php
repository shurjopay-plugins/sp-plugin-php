<?php

namespace ShurjopayPlugin;

use ShurjopayPlugin\ShurjopayEnvReader;

require_once __DIR__ . '/../src/ShurjopayEnvReader.php';

$env = new ShurjopayEnvReader(__DIR__ . '/_env');

$conf = $env->getConfig();
// TODO Redoy to fix it to run as php test
print_r($conf);
