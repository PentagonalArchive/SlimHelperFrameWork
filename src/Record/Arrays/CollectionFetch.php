<?php
namespace Pentagonal\SlimHelper\Record\Arrays;

use Pentagonal\SlimHelper\Traits\ArrayBracket;

/**
 * Class CollectionFetch
 * @package Pentagonal\SlimHelper\Record\Arrays
 */
class CollectionFetch extends Collection
{
    use ArrayBracket;

    /**
     * @return array
     */
    public function collections()
    {
        return $this->all();
    }
}
