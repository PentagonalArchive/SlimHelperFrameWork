<?php
namespace Pentagonal\SlimHelper;

use Monolog\Logger as MonoLog;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

/**
 * Class Logger
 * @package Nat
 *
 * @see LoggerInterface
 * @see \Monolog\Logger
 */
class Logger extends MonoLog
{
    /**
     * @var array
     */
    private static $fatalErrors = [
        E_ERROR,
        E_PARSE,
        E_CORE_ERROR,
        E_COMPILE_ERROR,
        E_USER_ERROR
    ];

    /**
     * Logger constructor.
     * {@inheritdoc}
     */
    public function __construct($name = null, array $handlers = [])
    {
        if (!$name || !is_numeric($name) && !is_string($name)) {
            $name = __CLASS__;
        }

        parent::__construct($name, $handlers);
    }

    /**
     * @param int $code
     * @return bool
     */
    public static function codeIsFatal($code)
    {
        return (is_numeric($code) && isset(self::$fatalErrors[$code]));
    }

    /**
     * CODE TO LOG LEVEL
     *
     * @param int   $code
     * @param mixed $default
     * @return mixed|string
     */
    public static function codeToLogLevel($code, $default = null)
    {
        $codes = [
            E_ERROR             => LogLevel::CRITICAL,
            E_WARNING           => LogLevel::WARNING,
            E_PARSE             => LogLevel::ALERT,
            E_NOTICE            => LogLevel::NOTICE,
            E_CORE_ERROR        => LogLevel::CRITICAL,
            E_CORE_WARNING      => LogLevel::WARNING,
            E_COMPILE_ERROR     => LogLevel::ALERT,
            E_COMPILE_WARNING   => LogLevel::WARNING,
            E_USER_ERROR        => LogLevel::ERROR,
            E_USER_WARNING      => LogLevel::WARNING,
            E_USER_NOTICE       => LogLevel::NOTICE,
            E_STRICT            => LogLevel::NOTICE,
            E_RECOVERABLE_ERROR => LogLevel::ERROR,
            E_DEPRECATED        => LogLevel::NOTICE,
            E_USER_DEPRECATED   => LogLevel::NOTICE,
        ];

        return is_numeric($code) && isset($codes[$code]) ? $codes[$code] : $default;
    }

    /**
     * Convert Log to String
     *
     * @param int $code
     * @return string
     */
    public static function codeToString($code)
    {
        switch ($code) {
            case E_ERROR:
                return 'E_ERROR';
            case E_WARNING:
                return 'E_WARNING';
            case E_PARSE:
                return 'E_PARSE';
            case E_NOTICE:
                return 'E_NOTICE';
            case E_CORE_ERROR:
                return 'E_CORE_ERROR';
            case E_CORE_WARNING:
                return 'E_CORE_WARNING';
            case E_COMPILE_ERROR:
                return 'E_COMPILE_ERROR';
            case E_COMPILE_WARNING:
                return 'E_COMPILE_WARNING';
            case E_USER_ERROR:
                return 'E_USER_ERROR';
            case E_USER_WARNING:
                return 'E_USER_WARNING';
            case E_USER_NOTICE:
                return 'E_USER_NOTICE';
            case E_STRICT:
                return 'E_STRICT';
            case E_RECOVERABLE_ERROR:
                return 'E_RECOVERABLE_ERROR';
            case E_DEPRECATED:
                return 'E_DEPRECATED';
            case E_USER_DEPRECATED:
                return 'E_USER_DEPRECATED';
        }

        return 'Unknown PHP error';
    }
}
