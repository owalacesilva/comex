<?php

namespace Infrastructure\Settings;

use Application\Interfaces\SettingsInterface;

/**
 * Represents a settings container that retrieves configuration values based on provided keys.
 * Implements the SettingsInterface to define a common contract for accessing settings.
 */
readonly class EnvSettings implements SettingsInterface
{
    private array $values;

    public function __construct()
    {
        $this->values = [
            'app.name' => getenv('APP_NAME'),
            'app.env' => getenv('APP_ENV'),
            'app.debug' => getenv('APP_DEBUG'),
            'app.base_url' => getenv('APP_BASE_URL'),
            'app.timezone' => getenv('APP_TIMEZONE'),
            'app.locale' => getenv('APP_LOCALE'),
            'app.log_level' => getenv('APP_LOG_LEVEL'),
            'app.log_path' => getenv('APP_LOG_PATH'),
            'db.driver' => getenv('DB_DRIVER'),
            'db.host' => getenv('DB_HOST'),
            'db.port' => getenv('DB_PORT'),
            'db.database' => getenv('DB_DATABASE'),
            'db.username' => getenv('DB_USERNAME'),
            'db.password' => getenv('DB_PASSWORD'),
            'db.charset' => getenv('DB_CHARSET'),
            'db.log_path' => getenv('DB_LOG_PATH'),
            'mail.driver' => getenv('MAIL_DRIVER'),
            'mail.host' => getenv('MAIL_HOST'),
            'mail.port' => getenv('MAIL_PORT'),
            'mail.forward_address' => getenv('MAIL_FORWARD_ADDRESS'),
            'mail.forward_name' => getenv('MAIL_FORWARD_NAME'),
            'mail.charset' => getenv('MAIL_CHARSET'),
            'mail.sendmail' => getenv('MAIL_SENDMAIL'),
            'mail.smtp_auth' => getenv('MAIL_SMTP_AUTH'),
            'mail.debug' => getenv('MAIL_DEBUG'),
        ];
    }

    public function get(string $key, mixed $default = null)
    {
        if (empty($key) || !is_string($key)) {
            return $default;
        }
        return $this->values[$key] ?? $default;
    }
}