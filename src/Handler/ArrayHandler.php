<?php
namespace Pentagonal\SlimHelper\Handler;

use Pentagonal\SlimHelper\Record\Arrays\Collection;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

/**
 * Class ArrayHandler
 * @package Pentagonal\SlimHelper\Handler
 */
class ArrayHandler extends AbstractProcessingHandler
{
    protected $collections;

    /**
     * @param int             $level          The minimum logging level at which this handler will be triggered
     * @param Boolean         $bubble         Whether the messages that are handled can bubble up the stack or not
     *
     * @throws \Exception                If a missing directory is not buildable
     * @throws \InvalidArgumentException If stream is not a resource or string
     */
    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);
        $this->collections = new Collection();
    }

    /**
     * @param array $record
     */
    public function write(array $record)
    {
        $this->collections->replace($record);
    }

    /**
     * {@inheritdoc}
     */
    public function close()
    {
        $this->collections->clear();
    }

    /**
     * Get Collection
     *
     * @return Collection
     */
    public function getCollections()
    {
        return $this->collections;
    }
}
