<?php

namespace App\Helpers;

use Monolog\Handler\StreamHandler;

/**
 * Class Logger
 * @package App\Helpers
 */
class Logger
{
    private static $instance = null;
    const DEFAULT_LOG_PATH = PROJECT_DIR . 'logs/';
    const DEFAULT_LOG_FILE = 'log.log';

    /**
     * @var \Monolog\Logger
     */
    protected $logger;

    /**
     * Logger constructor.
     */
    final private function __construct()
    {
        $this->logger = new \Monolog\Logger('ITAD-Portal');
    }

    /**
     * @param $name
     * @param $args
     * @return mixed
     */
    public static function __callStatic($name, $args)
    {
        $logger = self::getInstance()->getLogger();
        if (method_exists($logger, $name)) {
            return $logger->{$name}(...$args);
        }
    }

    /**
     * @return \Monolog\Logger
     */
    public static function getInstance(string $logFile = null)
    {
        $logFile = !empty($logFile) ? $logFile : self::DEFAULT_LOG_FILE;

        if (null !== static::$instance) {
            static::$instance->pushHandler(
                new StreamHandler(
                    self::DEFAULT_LOG_PATH . $logFile,
                    \Monolog\Logger::DEBUG
                )
            );

            return static::$instance;
        }
        static::$instance = new \Monolog\Logger('ITAD-Portal');

        static::$instance->pushHandler(
            new StreamHandler(
                self::DEFAULT_LOG_PATH . $logFile,
                \Monolog\Logger::DEBUG
            )
        );

        return static::$instance;
    }

    final private function __clone()
    {
    }
}
