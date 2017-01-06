<?php
namespace Pentagonal\SlimHelper\Utilities;

/**
 * Class Validation
 * @package Pentagonal\SlimHelper\Utilities
 */
class Validation
{
    /**
     * @param string $string has to check
     * @return bool
     */
    public static function isMaybePasswordHash($string)
    {
        if (!is_string($string)
            || ! in_array(($length = strlen($string)), [20, 34, 60])
            || preg_match('/[^a-zA-Z0-9\.\/\$\_]/', $string)
        ) {
            return false;
        }

        switch ((string) $length) {
            case '20':
                return !($string[0] != '_'
                    || strpos($string, '$') !== false
                    || strpos($string, '.') === false
                );
            case '34':
                return !(substr_count($string, '$') <> 2
                    || !in_array(substr($string, 0, 3), ['$P$', '$H$'])
                );
        }

        return !(
            substr($string, 0, 4) != '$2a$'
            || substr($string, 6, 1) != '$'
            || ! is_numeric(substr($string, 4, 2))
            || substr_count($string, '$') <> 3
        );
    }
}
