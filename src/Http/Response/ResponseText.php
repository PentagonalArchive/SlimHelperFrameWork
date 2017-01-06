<?php
namespace Pentagonal\SlimHelper\Http\Response;

use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseText
 * @package Pentagonal\SlimHelper\Http\Response
 */
class ResponseText extends ResponseAbstract
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
        $response = $this->response->withBody(new Stream(fopen('php://temp', 'r+')));
        $response->getBody()->write($this->data);
        $responseSerialize = $response->withHeader('Content-Type', $this->generateTheContentType());
        if (isset($this->statusCode)) {
            return $responseSerialize->withStatus($this->statusCode);
        }

        return $responseSerialize;
    }
}
