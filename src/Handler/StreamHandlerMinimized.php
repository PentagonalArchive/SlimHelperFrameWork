<?php
namespace Pentagonal\SlimHelper\Handler;

use Monolog\Handler\StreamHandler;

/**
 * Class StreamHandlerMinimized
 * @package Pentagonal\SlimHelper\Handler
 */
class StreamHandlerMinimized extends StreamHandler
{
    /**
     * {@inheritdoc}
     */
    protected function write(array $record)
    {
        if (!is_resource($this->stream)
            && $this->url &&
            is_file($this->url)
        ) {
            if (filesize($this->url) > (1024*2048)) { # max 2MB
                $exist = file_exists($this->url);
                $extension = pathinfo($this->url, PATHINFO_EXTENSION);
                $dir_name  = pathinfo($this->url, PATHINFO_DIRNAME);
                $file_name = pathinfo($this->url, PATHINFO_FILENAME);
                $file_name = $extension ? $file_name . '_' : $file_name;
                $extension = $extension ? '.'. $extension : $extension;
                $c = 0;
                while ($exist) {
                    $file = $dir_name . '/' . $file_name . $c++ . $extension;
                    $exist = file_exists($file);
                }
                if (isset($file)) {
                    @rename($this->url, $file);
                }
            }
        }

        parent::write($record);
    }

    /**
     * Override to once Log per file
     *
     * {@inheritdoc}
     * @return bool
     */
    public function isHandling(array $record)
    {
        return $record['level'] == $this->level;
    }
}
