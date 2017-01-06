<?php
namespace Pentagonal\SlimHelper\Http\Response;

use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseSerialize
 * @package Pentagonal\SlimHelper\Http\Response
 */
class ResponseSerialize extends ResponseAbstract
{
    /**
     * @var string
     */
    protected $mimeType = 'text/plain';

    /**
     * @var bool
     */
    protected $recheckMimeType = false;

    /**
     * {@inheritdoc}
     * @return ResponseInterface
     */
    public function serve()
    {
        return ResponseText::generate($this->request, $this->response)
            ->setData($this->data)
            ->setCharset($this->charset)
            ->serve();
    }
}
