<?php

namespace ShurjopayPlugin;

use ShurjopayPlugin\ShurjopayEnvReader;

require_once __DIR__ . '/../src/ShurjopayEnvReader.php';

$env = new ShurjopayEnvReader(__DIR__ . '/_env');
$conf = $env->getConfig();
print_r($conf);
