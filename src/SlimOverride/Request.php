<?php
namespace Pentagonal\SlimHelper\SlimOverride;

use Slim\Http\Cookies;
use Slim\Http\Environment;
use Slim\Http\Headers;
use Slim\Http\Request as SlimHttpRequest;
use Slim\Http\RequestBody;
use Slim\Http\UploadedFile;

/**
 * Class Request
 * @package Pentagonal\SlimHelper\SlimOverride
 */
class Request extends SlimHttpRequest
{
    /**
     * Valid request methods
     *
     * @var string[]
     */
    protected $validMethods = [
        'CONNECT' => 1,
        'DELETE' => 1,
        'GET' => 1,
        'HEAD' => 1,
        'OPTIONS' => 1,
        'PATCH' => 1,
        'POST' => 1,
        'PUT' => 1,
        'TRACE' => 1,
        // additional API Response
        'LINK' => 1,
        'UNLINK' => 1,
        'PURGE' => 1,
        'LOCK' => 1,
        'UNLOCK' => 1,
        'PROPFIND' => 1,
        'VIEW' => 1,
    ];

    /**
     * Create new HTTP request with data extracted from the application
     * Environment object
     *
     * @param  Environment $environment The Slim application Environment
     *
     * @return self
     */
    public static function createFromEnvironment(Environment $environment)
    {
        $method = $environment['REQUEST_METHOD'];
        $uri = Uri::createFromEnvironment($environment);
        $headers = Headers::createFromEnvironment($environment);
        $cookies = Cookies::parseHeader($headers->get('Cookie', []));
        $serverParams = $environment->all();
        $body = new RequestBody();
        $uploadedFiles = UploadedFile::createFromEnvironment($environment);

        $request = new static($method, $uri, $headers, $cookies, $serverParams, $body, $uploadedFiles);

        if ($method === 'POST' &&
            in_array($request->getMediaType(), ['application/x-www-form-urlencoded', 'multipart/form-data'])
        ) {
            // parsed body must be $_POST
            $request = $request->withParsedBody($_POST);
        }
        return $request;
    }
}
