<?php
namespace Pentagonal\SlimHelper\Interfaces\Record;

/**
 * Interface ArrayInterface
 * @package Pentagonal\SlimHelper\Interfaces\Record
 */
interface ArrayInterface extends \ArrayAccess, \Countable, \IteratorAggregate
{
    /**
     * Set Values
     *
     * @param mixed $key
     * @param mixed $value
     */
    public function set($key, $value);

    /**
     * Get Value
     *
     * @param mixed $key
     * @param mixed $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Replace Collections
     *
     * @param array $items
     */
    public function replace(array $items);

    /**
     * Get All Data
     *
     * @return array
     */
    public function all();

    /**
     * Check if records exists with certain key name
     *
     * @param mixed $key
     * @return bool
     */
    public function has($key);

    /**
     * Get Last values
     *
     * @return mixed
     */
    public function end();

    /**
     * Get first Values
     *
     * @return mixed
     */
    public function reset();

    /**
     * Get first key Data
     *
     * @return mixed
     */
    public function key();

    /**
     * Get next pointer value
     *
     * @return mixed
     */
    public function next();

    /**
     * Get previous pointer value
     *
     * @return mixed
     */
    public function prev();

    /**
     * Get current pointer value
     *
     * @return mixed
     */
    public function current();

    /**
     * push data into the end
     *
     * @param mixed $keyName
     * @param mixed $value optional arguments
     * @return mixed|int
     */
    public function push($keyName, $value = null);

    /**
     * Increment or add array set like
     *              $array[] = $value
     *
     * @param mixed $value
     * @return mixed
     */
    public function increment($value);

    /**
     * Remove Last Data
     * @return mixed|int
     */
    public function pop();

    /**
     * Remove first data
     * @return mixed|int
     */
    public function shift();

    /**
     * Insert into first of position
     *
     * @param mixed $keyName
     * @param mixed $value optional arguments
     * @return mixed|int
     */
    public function unShift($keyName, $value = null);

    /**
     * Get Match value on data
     *
     * @param mixed $values
     * @return array
     */
    public function filter($values);

    /**
     * Check if Contain data ( identical )
     *
     * @param mixed $values
     * @return bool
     */
    public function contain($values);

    /**
     * Get key name for data
     *
     * @param mixed $values
     * @return mixed|bool false if empty
     */
    public function indexOf($values);

    /**
     * Check whether data is empty
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Remove Data
     *
     * @param mixed $key
     */
    public function remove($key);

    /**
     * Clearing Data
     */
    public function clear();
}
