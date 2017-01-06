<?php
namespace Pentagonal\SlimHelper;

use Pentagonal\SlimHelper\Record\Arrays\CollectionSortable;

/**
 * Class Hook
 * @package Pentagonal\SlimHelper
 */
class Hook
{
    const KEY_FUNCTION      = 1;
    const KEY_ACCEPTED_ARGS = 2;

    /**
     * @var CollectionSortable[]|CollectionSortable[][]
     */
    protected $filters;

    /**
     * @var CollectionSortable
     */
    protected $merged;

    /**
     * @var CollectionSortable
     */
    protected $current;

    /**
     * @var array
     */
    protected $actions = [];

    /**
     * Hook constructor.
     */
    final public function __construct()
    {
        $this->filters = new CollectionSortable();
        $this->merged = new CollectionSortable();
        $this->current = new CollectionSortable();
    }

    /**
     * Create Unique ID if function is not string
     *
     * @param callable $function function to call
     *
     * @access private
     * @return string|bool
     */
    final private function uniqueId($function)
    {
        if (is_string($function)) {
            return $function;
        }

        if (is_object($function)) {
            // Closures are currently implemented as objects
            $function = [ $function, '' ];
        } elseif (!is_array($function)) {
            $function = [ $function ];
        }

        $function = array_values($function);
        if (is_object($function[0])) {
            return \spl_object_hash($function[0]) . $function[1];
        } elseif (count($function) > 1 || is_string($function[0])) {
            // call as static
            return $function[0] . '::' . $function[1];
        }

        // unexpected result
        return null;
    }

    /**
     * Sanitize Key
     *
     * @param string $keyName
     * @return bool|string
     */
    protected function sanitizeKeyName($keyName)
    {
        return is_string($keyName) && trim($keyName) != ''
            ? trim($keyName)
            : false;
    }

    /**
     * Add Hooks Function it just like a WordPress add_action() / add_filter() hooks
     *
     * @param string   $hookName          Hook Name
     * @param Callable $callable          Callable
     * @param integer  $priority          priority
     * @param integer  $acceptedArguments num count of accepted args / parameter
     *
     * @return boolean
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function add(
        $hookName,
        callable $callable,
        $priority = 10,
        $acceptedArguments = 1
    ) {
        $hookName = $this->sanitizeKeyName($hookName);
        if (!$hookName) {
            throw new \InvalidArgumentException(
                'Invalid Hook Name Specified',
                E_USER_ERROR
            );
        }

        $id = $this->uniqueId($callable);
        if ($id === null) {
            throw new \RuntimeException(
                sprintf(
                    'Invalid callable specified on hook name %s',
                    $hookName
                ),
                E_USER_ERROR
            );
        }
        $priority = !is_numeric($priority)
            ? 10
            : abs(intval($priority));

        if (!$this->filters->has($hookName)) {
            $this->filters[$hookName] = new CollectionSortable();
        }
        if (!$this->filters[$hookName]->has($priority)) {
            $this->filters[$hookName]->set($priority, new CollectionSortable());
        }

        $this
            ->filters
            ->get($hookName)
            ->get($priority)
            ->set(
                $id,
                [
                    self::KEY_FUNCTION      => $callable,
                    self::KEY_ACCEPTED_ARGS => $acceptedArguments
                ]
            );

        // remove merged hook
        $this->merged->remove($hookName);
        return true;
    }

    /**
     * Check if hook name exists
     *
     * @param  string       $hookName        Hook name
     * @param  string|mixed $functionToCheck Specially Functions on Hook
     *
     * @return boolean|int
     */
    public function exists($hookName, $functionToCheck = false)
    {
        $hookName = $this->sanitizeKeyName($hookName);
        if (!$hookName || ! $this->filters->has($hookName)) {
            return false;
        }

        // Don't reset the internal array pointer
        $has    = $this->filters[$hookName]->isEmpty();
        // Make sure at least one priority has a filter callback
        if ($has) {
            $exists = false;
            foreach ($this->filters[$hookName] as $callbacks) {
                if (! empty($callbacks)) {
                    $exists = true;
                    break;
                }
            }

            if (! $exists) {
                $has = false;
            }
        }

        // recheck
        if ($functionToCheck === false || $has === false) {
            return $has;
        }

        if (! $id = $this->uniqueId($functionToCheck)) {
            return false;
        }

        foreach ($this->filters[$hookName] as $priority) {
            if ($priority->has($id)) {
                return $priority;
            }
        }

        return false;
    }

    /**
     * Applying Hooks for replaceable and returning as $value param
     *
     * @param  string $hookName Hook Name replaceable
     * @param  mixed $value     returning value
     *
     * @return mixed
     */
    public function apply($hookName, $value)
    {
        $hookName = $this->sanitizeKeyName($hookName);
        if (!$hookName) {
            throw new \InvalidArgumentException(
                'Invalid Hook Name Specified',
                E_USER_ERROR
            );
        }
        if ($this->filters->has($hookName)) {
            return $value;
        }

        // add increment data
        $this->current->increment($hookName);

        /**
         * Sorting
         */
        if ($this->merged->has($hookName)) {
            $this->filters[$hookName]->kSort();
            $this->merged->set($hookName, true);
        }

        // reset sorting position
        $this->filters[$hookName]->reset();
        $args = func_get_args();
        do {
            foreach ($this->filters[$hookName]->current() as $collection) {
                if (!is_null($collection[self::KEY_FUNCTION])) {
                    $args[1] = $value;
                    $value = call_user_func_array(
                        $collection[self::KEY_FUNCTION],
                        array_slice(
                            $args,
                            1,
                            (int) $collection[self::KEY_ACCEPTED_ARGS]
                        )
                    );
                }
            }
        } while ($this->filters[$hookName]->next() !== false);

        $this->current->pop();

        return $value;
    }
    /**
     * Call hook from existing declared hook record
     *
     * @param  string $hookName Hook Name
     * @param  string $arg      the arguments for next parameter
     *
     * @return boolean
     */
    public function call($hookName, $arg = '')
    {
        $hookName = $this->sanitizeKeyName($hookName);
        if (!$hookName) {
            return false;
        }

        if (! isset($this->actions[$hookName])) {
            $this->actions[$hookName] = 1;
        } else {
            $this->actions[$hookName]++;
        }

        if (! $this->filters->has($hookName)) {
            return null;
        }

        $this->current->increment($hookName);

        $args = [];
        if (is_array($arg) && 1 == count($arg) && isset($arg[0]) && is_object($arg[0])) {
            $args[] =& $arg[0];
        } else {
            $args[] = $arg;
        }

        for ($a = 2, $num = func_num_args(); $a < $num; $a++) {
            $args[] = func_get_arg($a);
        }

        // Sort
        if (! $this->merged->has($hookName)) {
            $this->filters[$hookName]->kSort();
            $this->merged->set($hookName, true);
        }
        $this->filters[$hookName]->reset();
        do {
            foreach ($this->filters[$hookName]->current() as $collection) {
                if (!is_null($collection[self::KEY_FUNCTION])) {
                    call_user_func_array(
                        $collection[self::KEY_FUNCTION],
                        array_slice(
                            $args,
                            0,
                            (int) $collection[self::KEY_ACCEPTED_ARGS]
                        )
                    );
                }
            }
        } while ($this->filters[$hookName]->next() !== false);

        $this->current->pop();
        return true;
    }

    /**
     * Replace Hooks Function, this will replace all existing hooks
     *
     * @param  string   $hookName          Hook Name
     * @param  string   $functionToReplace Function to replace
     * @param  Callable $callable          Callable
     * @param  integer  $priority          priority
     * @param  integer  $acceptedArguments num count of accepted args / parameter
     * @param  boolean  $create            true if want to create new if not exists
     *
     * @return boolean
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function replace(
        $hookName,
        $functionToReplace,
        $callable,
        $priority = 10,
        $acceptedArguments = 1,
        $create = true
    ) {
        $hookName = $this->sanitizeKeyName($hookName);
        if (!$hookName) {
            throw new \InvalidArgumentException(
                "Invalid Hook Name Specified",
                E_USER_ERROR
            );
        }

        if (!is_callable($callable)) {
            throw new \RuntimeException(
                "Invalid Hook Callable Specified",
                E_USER_ERROR
            );
        }

        if (($has = $this->exists($hookName, $functionToReplace)) || $create) {
            $has && $this->remove($hookName, $functionToReplace);
            // add hooks first
            return $this->add($hookName, $callable, $priority, $acceptedArguments);
        }

        return false;
    }

    /**
     * Removing Hook (remove single hook)
     *
     * @param  string  $hookName         Hook Name
     * @param  string  $functionToRemove functions that to remove from determine $hookName
     * @param  integer $priority         priority
     *
     * @return boolean
     */
    public function remove($hookName, $functionToRemove, $priority = 10)
    {
        $hookName = $this->sanitizeKeyName($hookName);
        if (!$hookName) {
            return false;
        }

        $functionToRemove = $this->uniqueId($functionToRemove);
        $r = $this->filters[$hookName]->get($priority);
        $r = $r ? $r->has($functionToRemove) : false;
        if ($r === true) {
            $this->filters[$hookName][$priority]->remove($functionToRemove);
            if ($this->filters[$hookName][$priority]->isEmpty()) {
                $this->filters[$hookName]->remove($priority);
            }
            if ($this->filters[$hookName]->isEmpty()) {
                $this->filters[$hookName]->clear();
            }
            $this->merged->remove($hookName);
        }

        return $r;
    }

    /**
     * Remove all of the hooks from a filter.
     *
     * @param string   $hookName    The filter to remove hooks from.
     * @param int|bool $priority    Optional. The priority number to remove. Default false.
     *
     * @return boolean
     */
    public function removeAll($hookName, $priority = false)
    {
        if (isset($this->filters[$hookName])) {
            if (false === $priority || $priority === null) {
                $this->filters[$hookName]->clear();
            } elseif ($this->filters[$hookName]->has($priority)) {
                $this->filters[$hookName][$priority]->clear();
            }
        }

        $this->merged->remove($hookName);
        return true;
    }

    /**
     * Current position
     *
     * @return string functions
     */
    public function current()
    {
        return $this->current->end();
    }

    /**
     * Count all existences Hook
     *
     * @param string $hookName Hook name
     *
     * @return integer          Hooks Count
     */
    public function count($hookName)
    {
        $hookName = $this->sanitizeKeyName($hookName);
        if (!$hookName || ! $this->filters->has($hookName)) {
            return false;
        }
        return $this->filters[$hookName]->count();
    }

    /**
     * Check if hook has doing
     *
     * @param string $hookName Hook name
     *
     * @return boolean           true if has doing
     */
    public function hasDoing($hookName = null)
    {
        if (null === $hookName) {
            return ! empty($this->current);
        }

        $hookName = $this->sanitizeKeyName($hookName);
        return $hookName && $this->current->has($hookName);
    }

    /**
     * Check if action hook as execute
     *
     * @param string $hookName Hook Name
     *
     * @return integer Count of hook action if has did action
     */
    public function hasCalled($hookName)
    {
        $hookName = $this->sanitizeKeyName($hookName);
        if (!$hookName || ! isset($this->actions[$hookName])) {
            return 0;
        }

        return $this->actions[$hookName];
    }
}
