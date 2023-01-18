<?php

namespace ShurjopayPlugin;

use ShurjopayPlugin\ShurjopayConfig;

require_once __DIR__ . '/ShurjopayConfig.php';

/**
 * 
 * Thanks to F R Michel.
 * Note: https://dev.to/fadymr/php-create-your-own-php-dotenv-3k2i
 * @since 2023-01-17 
 */
class ShurjopayEnvReader
{

    /** directory where the .env file can be located */
    protected $path;

    public function __construct(string $path)
    {
        if (!file_exists($path)) {
            throw new \InvalidArgumentException(sprintf('%s does not exist', $path));
        }
        $this->path = $path;
    }

    public function load(): void
    {
        if (!is_readable($this->path)) {
            throw new \RuntimeException(sprintf('%s file is not readable', $this->path));
        }

        $lines = file($this->path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {

            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);

            if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                putenv(sprintf('%s=%s', $name, $value));
                $_ENV[$name] = $value;
                $_SERVER[$name] = $value;
            }
        }
    }

    public function getConfig()
    {
        $this->load();
        $config = new ShurjopayConfig();
        $config->username = getenv('SP_USERNAME');
        $config->password = getenv('SP_PASSWORD');
        $config->api_endpoint = getenv('SHURJOPAY_API');
        $config->callback_url = getenv('SP_CALLBACK');
        $config->log_path = getenv('SP_LOG_LOCATION');
        $config->order_prefix = getenv('SP_PREFIX');
        $config->ssl_verifypeer = getenv('CURLOPT_SSL_VERIFYPEER');

        return $config;
    }
}
