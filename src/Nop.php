<?php
namespace Pentagonal\SlimHelper;

/**
 * Class Nop
 * @package Pentagonal\SlimHelper
 */
class Nop
{
    /**
     * @return string
     */
    public function __toString()
    {
        return get_class($this) . '::' . spl_object_hash($this);
    }
}
