<?php
/**
 * Json result object
 */
namespace Pentagonal\SlimHelper\Http\Response;

use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseJSON
 * @package Pentagonal\SlimHelper\Http\Response
 */
class ResponseJSON extends ResponseAbstract
{
    /**
     * @var string
     */
    protected $mimeType = 'application/json';

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
        if (func_num_args() > 0) {
            $this->setData(func_get_arg(0));
            if (func_num_args() > 1) {
                $this->setStatusCode(func_get_arg(1));
            }
        }

        $response = $this->response->withBody(new Stream(fopen('php://temp', 'r+')));
        $response->getBody()->write($json = json_encode($this->data, $this->encoding));

        // Ensure that the json encoding passed successfully
        if ($json === false) {
            throw new \RuntimeException(\json_last_error_msg(), \json_last_error());
        }

        $responseWithJson = $response->withHeader('Content-Type', $this->generateTheContentType());
        if (isset($this->statusCode)) {
            return $responseWithJson->withStatus($this->statusCode);
        }

        return $responseWithJson;
    }
}
