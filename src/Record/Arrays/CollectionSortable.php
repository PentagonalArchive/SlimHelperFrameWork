<?php
namespace Pentagonal\SlimHelper\Record\Arrays;

/**
 * Class CollectionSortable
 * @package Pentagonal\SlimHelper\Record\Arrays
 */
class CollectionSortable extends Collection
{
    /**
     * Sort an array collection
     *
     * @param null|int $sort
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function sort($sort = null)
    {
        if ($sort !== null && ! is_int($sort)) {
            throw new \InvalidArgumentException(
                'Invalid sort type',
                E_USER_ERROR
            );
        }

        return $sort === null
            ? sort($this->storedData)
            : sort($this->storedData, $sort);
    }

    /**
     * Sort an array collection by key
     * @link http://php.net/manual/en/function.ksort.php
     *
     * @param int|null $sort
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function kSort($sort = null)
    {
        if ($sort !== null && ! is_int($sort)) {
            throw new \InvalidArgumentException(
                'Invalid sort type',
                E_USER_ERROR
            );
        }

        return ksort($this->storedData, $sort);
    }

    /**
     * Sort an array collection using a "natural order" algorithm
     * @link http://php.net/manual/en/function.natsort.php
     *
     * @return bool true on success or false on failure.
     */
    public function natSort()
    {
        return natsort($this->storedData);
    }

    /**
     * Sort an array collection using a case insensitive "natural order" algorithm
     * @link http://php.net/manual/en/function.natcasesort.php
     *
     * @return bool true on success or false on failure.
     */
    public function natCaseSort()
    {
        return natcasesort($this->storedData);
    }

    /**
     * Sort an array collection in reverse order and maintain index association
     * @link http://php.net/manual/en/function.arsort.php
     *
     * @param int|null $sort
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function arSort($sort = null)
    {
        if ($sort !== null && ! is_int($sort)) {
            throw new \InvalidArgumentException(
                'Invalid sort type',
                E_USER_ERROR
            );
        }

        return $sort === null
            ? arsort($this->storedData)
            : arsort($this->storedData, $sort);
    }

    /**
     * Sort an array collection and maintain index association
     * @link http://php.net/manual/en/function.asort.php
     *
     * @param int|null $sort
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function aSort($sort = null)
    {
        if ($sort !== null && ! is_int($sort)) {
            throw new \InvalidArgumentException(
                'Invalid sort type',
                E_USER_ERROR
            );
        }

        return $sort === null
            ? asort($this->storedData)
            : asort($this->storedData, $sort);
    }

    /**
     * Sort an array collection in reverse order
     * @link http://php.net/manual/en/function.rsort.php
     *
     * @param int|int $sort
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function rSort($sort = null)
    {
        if ($sort !== null && ! is_int($sort)) {
            throw new \InvalidArgumentException(
                'Invalid sort type',
                E_USER_ERROR
            );
        }

        return $sort === null
            ? rsort($this->storedData)
            : rsort($this->storedData, $sort);
    }

    /**
     * Sort an array collection by values using a user-defined comparison function
     * @link http://php.net/manual/en/function.usort.php
     *
     * @param callback $cmp_function
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function uSort($cmp_function)
    {
        return usort($this->storedData, $cmp_function);
    }

    /**
     * Sort an array collection with a user-defined comparison function and maintain index association
     * @link http://php.net/manual/en/function.uasort.php
     *
     * @param callback $cmp_function
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function uaSort($cmp_function)
    {
        return uasort($this->storedData, $cmp_function);
    }

    /**
     * Sort an array collection by keys using a user-defined comparison function
     * @link http://php.net/manual/en/function.uksort.php
     *
     * @param callback $cmp_function
     * @return bool
     * @throws \InvalidArgumentException
     */
    public function ukSort($cmp_function)
    {
        return uksort($this->storedData, $cmp_function);
    }

    /**
     * Shuffle an array collection
     * @link http://php.net/manual/en/function.shuffle.php
     *
     * @return bool
     */
    public function shuffle()
    {
        return shuffle($this->storedData);
    }
}
