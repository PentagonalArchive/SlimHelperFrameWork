<?php
namespace Pentagonal\SlimHelper\Record\Arrays;

/**
 * Class CollectionSerializable
 * @package Pentagonal\SlimHelper\Record\Arrays
 */
class CollectionSerializable extends Collection implements
    \Serializable,
    \JsonSerializable
{
    /**
     * Serialize array
     *
     * @return string
     */
    public function serialize()
    {
        return serialize($this->all());
    }

    /**
     * Un-serialize Magic Method
     *
     * @param string $serialized
     */
    public function unserialize($serialized)
    {
        $serialized = @unserialize($serialized);
        if (!is_array($serialized)) {
            throw new \InvalidArgumentException(
                'Invalid argument 1, arguments must be serialized of array',
                E_USER_ERROR
            );
        }

        $this->replace($serialized);
    }

    /**
     * Returning Encoded Json
     *
     * @return string
     */
    public function jsonSerialize()
    {
        return json_encode($this->all());
    }
}
