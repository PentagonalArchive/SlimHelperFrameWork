<?php
namespace Pentagonal\SlimHelper\Utilities;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * Class Sanitation
 * @package Pentagonal\SlimHelper\Utilities
 */
class Sanitation
{
    /* --------------------------------------------------------------------------------*
     |                              Serialize Helper                                   |
     |                                                                                 |
     | Custom From WordPress Core wp-includes/functions.php                            |
     |---------------------------------------------------------------------------------|
     */

    /**
     * Check value to find if it was serialized.
     * If $data is not an string, then returned value will always be false.
     * Serialized data is always a string.
     *
     * @param  mixed $data   Value to check to see if was serialized.
     * @param  bool  $strict Optional. Whether to be strict about the end of the string. Defaults true.
     * @return bool  false if not serialized and true if it was.
     */
    public static function isSerialized($data, $strict = true)
    {
        /* if it isn't a string, it isn't serialized
         ------------------------------------------- */
        if (! is_string($data) || trim($data) == '') {
            return false;
        }

        $data = trim($data);
        // null && boolean
        if ('N;' == $data || $data == 'b:0;' || 'b:1;' == $data) {
            return true;
        }

        if (strlen($data) < 4 || ':' !== $data[1]) {
            return false;
        }

        if ($strict) {
            $last_char = substr($data, -1);
            if (';' !== $last_char && '}' !== $last_char) {
                return false;
            }
        } else {
            $semicolon = strpos($data, ';');
            $brace     = strpos($data, '}');

            // Either ; or } must exist.
            if (false === $semicolon && false === $brace
                || false !== $semicolon && $semicolon < 3
                || false !== $brace && $brace < 4
            ) {
                return false;
            }
        }

        $token = $data[0];
        switch ($token) {
            /** @noinspection PhpMissingBreakStatementInspection */
            case 's':
                if ($strict) {
                    if ('"' !== substr($data, -2, 1)) {
                        return false;
                    }
                } elseif (false === strpos($data, '"')) {
                    return false;
                }
            // or else fall through
            case 'a':
            case 'O':
                return (bool) preg_match("/^{$token}:[0-9]+:/s", $data);
            case 'i':
            case 'd':
                $end = $strict ? '$' : '';
                return (bool) preg_match("/^{$token}:[0-9.E-]+;$end/", $data);
        }

        return false;
    }

    /**
     * Un-serialize value only if it was serialized.
     *
     * @param  string $original Maybe un-serialized original, if is needed.
     * @return mixed  Un-serialized data can be any type.
     */
    public static function maybeUnSerialize($original)
    {
        if (! is_string($original) || trim($original) == '') {
            return $original;
        }

        /**
         * Check if serialized
         * check with trim
         */
        if (static::isSerialized($original)) {
            /**
             * use trim if possible
             * Serialized value could not start & end with white space
             */
            return @unserialize(trim($original));
        }

        return $original;
    }

    /**
     * Serialize data, if needed. @uses for ( un-compress serialize values )
     * This method to use safe as save data on database. Value that has been
     * Serialized will be double serialize to make sure data is stored as original
     *
     *
     * @param  mixed $data Data that might be serialized.
     * @return mixed A scalar data
     */
    public static function maybeSerialize($data)
    {
        if (is_array($data) || is_object($data)) {
            return @serialize($data);
        }

        // Double serialization is required for backward compatibility.
        if (static::isSerialized($data, false)) {
            return serialize($data);
        }

        return $data;
    }

    /* --------------------------------------------------------------------------------*
     |                              Entity Helper                                      |
     |                                                                                 |
     |                                                                                 |
     |---------------------------------------------------------------------------------|
     */

    /**
     * Entities the Multi bytes deep string
     *
     * @param mixed $mixed  the string to detect multi bytes
     * @param bool  $entity true if want to entity the output
     *
     * @return mixed
     */
    public static function multiByteEntities($mixed, $entity = false)
    {
        static $hasIconV = null;
        if (!isset($hasIconV)) {
            // safe resource check
            $hasIconV = function_exists('iconv');
        }

        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = self::multiByteEntities($value, $entity);
            }

            return $mixed;
        }

        if (is_object($mixed)) {
            foreach (get_object_vars($mixed) as $key => $value) {
                $mixed->{$key} = self::multiByteEntities($value, $entity);
            }

            return $mixed;
        }

        if (! $hasIconV) {
            if ($entity) {
                return htmlentities(html_entity_decode($mixed));
            }
            return $mixed;
        }

        /**
         * Work Safe with Parse 4096 Bit | 4KB data split for regex callback & safe memory usage
         * that maybe fail on very long string
         */
        if (strlen($mixed) > 4096) {
            return implode('', self::multiByteEntities(str_split($mixed, 4096), $entity));
        }

        if ($entity) {
            $mixed = htmlentities(html_entity_decode($mixed));
        }
        return preg_replace_callback(
            '/[\x{80}-\x{10FFFF}]/u',
            function ($match) {
                $char = current($match);
                $utf  = iconv('UTF-8', 'UCS-4//IGNORE', $char);
                return sprintf("&#x%s;", ltrim(strtolower(bin2hex($utf)), "0"));
            },
            $mixed
        );
    }

    /**
     * Set cookie domain with .domain.ext for multi sub domain
     *
     * @param  string|RequestInterface|UriInterface  $domain
     * @return string $return domain ( .domain.com )
     */
    public static function splitCrossDomain($domain)
    {
        if ($domain instanceof RequestInterface) {
            $domain = $domain->getUri()->getHost();
            if (!$domain) {
                return null;
            }
        } elseif ($domain instanceof UriInterface) {
            $domain = $domain->getHost();
            if (!$domain) {
                return null;
            }
        }

        // domain must be string
        if (! is_string($domain)) {
            return $domain;
        }

        // make it domain lower
        $domain = strtolower($domain);
        $domain = preg_replace('/((http|ftp)s?|sftp|xmp):\/\//i', '', $domain);
        $domain = preg_replace('/\/.*$/', '', $domain);
        $is_ip = filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4);
        if (!$is_ip) {
            $is_ip = filter_var($domain, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
        }

        if (!$is_ip) {
            $parse  = parse_url('http://'.$domain.'/');
            $domain = isset($parse['host']) ? $parse['host'] : null;
            if ($domain === null) {
                return null;
            }
        }
        if (!preg_match('/^((\[[0-9a-f:]+\])|(\d{1,3}(\.\d{1,3}){3})|[a-z0-9\-\.]+)(:\d+)?$/i', $domain)
            || $is_ip
            || $domain == '127.0.0.1'
            || $domain == 'localhost'
        ) {
            return $domain;
        }

        $domain = preg_replace('/[~!@#$%^&*()+`\{\}\]\[\/\\\'\;\<\>\,\"\?\=\|]/', '', $domain);
        if (strpos($domain, '.') !== false) {
            if (preg_match('/(.*\.)+(.*\.)+(.*)/', $domain)) {
                $return     = '.'.preg_replace('/(.*\.)+(.*\.)+(.*)/', '$2$3', $domain);
            } else {
                $return = '.'.$domain;
            }
        } else {
            $return = $domain;
        }
        return $return;
    }
}
