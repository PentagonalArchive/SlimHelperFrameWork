<?php
namespace Pentagonal\SlimHelper\Traits;

/**
 * Class ArrayBracket
 * @package Pentagonal\SlimHelper\Traits
 */
trait ArrayBracket
{
    /**
     * @return array
     */
    protected function collections()
    {
        return [];
    }

    /**
     * Fetch from array
     * Internal method used to retrieve values from global arrays.
     * alias of fetchFrom[];
     *
     * @param   mixed   $index   Index for item to be fetched from $array
     * @param   mixed   $default Default return if not exist
     * @return  mixed
     */
    public function fetch($index = null, $default = null)
    {
        return $this->fetchFromArray($index, $default);
    }

    /**
     * Fetch from array
     *
     * Internal method used to retrieve values from global arrays.
     *
     * @param   mixed   $index   Index for item to be fetched from $array
     * @param   mixed   $default Default return if not exist
     * @return  mixed
     * @throws \ErrorException
     */
    protected function fetchFromArray($index = null, $default = null)
    {
        $array = $this->collections();
        if (empty($array)) {
            return $default;
        }
        if (!is_array($array)) {
            throw new \ErrorException(
                'Invalid records for array collections',
                E_ERROR
            );
        }

        // If $index is NULL, it means that the whole $array is requested
        isset($index) || $index = array_keys($array);
        // allow fetching multiple keys at once
        if (is_array($index)) {
            $output = [];
            foreach ($index as $key) {
                $output[$key] = $this->fetchFromArray($key);
            }
            return $output;
        }
        if (isset($array[$index])) {
            $value = $array[$index];
        } elseif (($count = preg_match_all('/(?:^[^\[]+)|\[[^]]*\]/', $index, $matches)) > 1) {
            // Does the index contain array notation
            $value = $array;
            for ($i = 0; $i < $count; $i++) {
                $key = trim($matches[0][$i], '[]');
                // Empty notation will return the value as array
                if ($key === '') {
                    break;
                }
                if (isset($value[$key])) {
                    $value = $value[$key];
                } else {
                    return $default;
                }
            }
        } else {
            return $default;
        }

        return $value;
    }
}
