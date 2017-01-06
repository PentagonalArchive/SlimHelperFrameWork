<?php
namespace Pentagonal\SlimHelper\Utilities;

/**
 * Class Path
 * @package Pentagonal\SlimHelper\Utilities
 */
class PathHelper
{
    /**
     * Clean Path As unix
     *
     * @param string $path
     *
     * @return bool|string
     */
    public static function cleanAsUnix($path)
    {
        if (is_string($path)) {
            return preg_replace('/(\\\|\/)+/', '/', $path);
        }

        return false;
    }

    /**
     * Clean Path As Real
     *
     * @param string $path
     *
     * @return bool|string
     */
    public static function cleanAsReal($path)
    {
        if (is_string($path)) {
            return preg_replace('/(\\\|\/)+/', DIRECTORY_SEPARATOR, $path);
        }

        return false;
    }

    /**
     * Clean Slashed As Unix
     *
     * @param string $path
     *
     * @return bool|string
     */
    public static function unTrailSlashAsUnix($path)
    {
        if (is_string($path)) {
            return rtrim(self::cleanAsUnix($path), '/');
        }

        return false;
    }

    /**
     * Clean Slashed As Unix
     *
     * @param string $path
     *
     * @return bool|string
     */
    public static function unTrailSlashAsReal($path)
    {
        if (is_string($path)) {
            return rtrim(self::cleanAsReal($path), DIRECTORY_SEPARATOR);
        }

        return false;
    }

    /**
     * Clean Slashed As Unix
     *
     * @param string $path
     *
     * @return bool|string
     */
    public static function trailSlashAsUnix($path)
    {
        if (is_string($path)) {
            return self::unTrailSlashAsUnix($path) . '/';
        }

        return false;
    }

    /**
     * Clean Slashed As Unix
     *
     * @param string $path
     *
     * @return bool|string
     */
    public static function trailSlashAsReal($path)
    {
        if (is_string($path)) {
            return self::unTrailSlashAsReal($path) . DIRECTORY_SEPARATOR;
        }

        return false;
    }

    /**
     * Test if a give filesystem path is absolute.
     *
     * For example, '/foo/bar', or 'c:\windows'.
     *
     * @since 2.5.0
     *
     * @param string $path File path.
     * @return bool True if path is absolute, false is not absolute.
     */
    public static function isAbsolute($path)
    {
        /*
         * This is definitive if true but fails if $path does not exist or contains
         * a symbolic link.
         */
        if (realpath($path) == $path) {
            return true;
        }

        if (strlen($path) == 0 || $path[0] == '.') {
            return false;
        }

        // Windows allows absolute paths like this.
        if (preg_match('#^[a-zA-Z]:\\\\#', $path)) {
            return true;
        }

        // A path starting with / or \ is absolute; anything else is relative.
        return ($path[0] == '/' || $path[0] == '\\');
    }

    /**
     * Join two filesystem paths together.
     *
     * For example, 'give me $path relative to $base'. If the $path is absolute,
     * then it the full path is returned.
     *
     * @since 2.5.0
     *
     * @param string $base Base path.
     * @param string $path Path relative to $base.
     * @return string The path with the base or absolute path.
     */
    public static function join($base, $path)
    {
        if (self::isAbsolute($path)) {
            return $path;
        }

        return rtrim($base, '/') . '/' . ltrim($path, '/');
    }
}
