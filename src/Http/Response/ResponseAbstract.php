<?php
namespace Pentagonal\SlimHelper\Http\Response;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class ResponseAbstract
 * @package Pentagonal\SlimHelper\Http\Response
 */
abstract class ResponseAbstract
{
    /**
     * @var string
     */
    protected $mimeType;

    /**
     * @var bool
     */
    protected $recheckMimeType = true;

    /**
     * @var ServerRequestInterface
     */
    protected $request;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @var string
     */
    protected $charset = 'utf-8';

    /**
     * @var int
     */
    protected $statusCode = 200;

    /**
     * @var int
     */
    protected $encoding = 0;

    /**
     * ResponseAbstract constructor.
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     */
    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Set Data
     *
     * @param mixed $data
     * @return static
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Get data
     *
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $data
     * @return static
     */
    public function setCharset($data)
    {
        if (is_string($data)) {
            $data = strtolower(trim($data));
            if ($data == '') {
                $data = null;
            } elseif (preg_match('/([^0-9]*)[\-]([0-9]+)?$/', $data, $match)) {
                // sanitize to default utf8
                $data = $match[0] . '-' . (!empty($match[1]) ? $match[1] : '8');
            }
        }

        $this->charset = $data;
        return $this;
    }

    /**
     * Get character set
     *
     * @return string
     */
    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * Generate content type
     *
     * @return string
     */
    protected function generateTheContentType()
    {
        $charset = $this->getCharset();
        if (!is_string($this->mimeType) || trim($this->mimeType) == '') {
            $this->mimeType = 'text/html'; # fallback to default
        } elseif ($this->recheckMimeType || strpos($this->mimeType, '/') === false) {
            if (stripos($this->mimeType, 'htm')) {
                $this->mimeType = 'text/html';
            } elseif (strpos($this->mimeType, 'javascript') !== false) {
                $this->mimeType = 'text/javascript';
            } elseif (stripos($this->mimeType, 'calendar') !== false) {
                $this->mimeType = 'text/calendar';
            } elseif (stripos($this->mimeType, 'css') !== false) {
                $this->mimeType = 'text/css';
            } elseif (stripos($this->mimeType, 'plain') !== false) {
                $this->mimeType = 'text/css';
            } elseif (stripos($this->mimeType, 'ico') !== false || stripos($this->mimeType, 'icns') !== false) {
                $this->mimeType = 'image/x-icon';
                $charset = null;
            } elseif (stripos($this->mimeType, 'sgm') !== false) {
                $this->mimeType = 'text/sgml';
            } elseif (preg_match(
                '/(?:(?:[^/]*)(?:\\\+|\/+))?(ja?son|xml|ogg|pdf|postscript|zip)/',
                trim(strtolower($this->mimeType)),
                $match
            ) && !empty($match[1])
            ) {
                if ($match[1] == 'jason') {
                    $match[1] = 'json';
                }
                $this->mimeType = 'application/' . $match[1];
            } elseif (preg_match(
                '/(?:(?:[^/]*)(?:\\\+|\/+))?(jpe?g?|png|w?bmp|gif|pbm|tif(?:f+)?|png|ppm|ras|xbm|xpm|xwd)/',
                trim(strtolower($this->mimeType)),
                $match
            )
                && !empty($match[1])
            ) {
                if (strpos($match[1], 'tif') !== false) {
                    $match[1] = 'tiff';
                }
                $this->mimeType = \GuzzleHttp\Psr7\mimetype_from_extension($match[1]);
            } else {
                $mimeType = null;
                $this->mimeType = preg_replace('/(\\\|\/)+/', '/', trim($this->mimeType));
                if (preg_match('/([^\]*)(?:\/(.+(\+.+)?)/?', $this->mimeType, $match) && !empty($match)) {
                    if (!empty($match[3])) {
                        $mimeType = \GuzzleHttp\Psr7\mimetype_from_extension($match[3]);
                    }
                    if (!$mimeType && !empty($match[2])) {
                        $mimeType = \GuzzleHttp\Psr7\mimetype_from_extension($match[2]);
                    }
                    if (!$mimeType) {
                        $mimeType = \GuzzleHttp\Psr7\mimetype_from_extension($match[1]);
                    }
                }
                if (!$mimeType) {
                    if (preg_match('/te?xt|plain|ini/', $this->mimeType)) {
                        $mimeType = 'txt';
                    }
                    $mimeType = \GuzzleHttp\Psr7\mimetype_from_extension($mimeType);
                    // fallback to default `text/html`
                    if (!$mimeType) {
                        $mimeType = 'text/html';
                    }
                    $this->mimeType = $mimeType;
                }
            }
        }

        return $this->mimeType . ($charset ? ';charset=' . $charset : '');
    }

    /**
     * Get Mime Type
     *
     * @return string
     */
    public function getMimeType()
    {
        $this->generateTheContentType();
        return $this->mimeType;
    }

    /**
     * @param $encoding
     * @return static
     */
    public function setEncoding($encoding)
    {
        $this->encoding = $encoding;
        return $this;
    }

    /**
     * Set Response Status
     *
     * @param int $status
     * @return static
     */
    public function setStatusCode($status)
    {
        if ($this->response->withStatus($status)->getReasonPhrase() == '') {
            throw new \InvalidArgumentException(
                'Invalid response code given.',
                E_USER_ERROR
            );
        }
        $this->statusCode = abs($status);
        return $this;
    }

    /**
     * Get Status Code
     *
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Generate
     *
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @return static
     */
    public static function generate(ServerRequestInterface $request, ResponseInterface $response)
    {
        return new static($request, $response);
    }

    /**
     * Serve The response
     *
     * @return ResponseInterface
     */
    abstract public function serve();
}
