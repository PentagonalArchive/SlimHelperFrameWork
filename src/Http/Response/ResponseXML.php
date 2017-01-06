<?php
/**
 * XML Result point
 * if value as array key is numeric is convert key name as <array identifier="[0-9]+" type="integer">value</array>
 * and if data is numeric will be <integer identifier="[0-9]+" type="integer"></integer>
 */
namespace Pentagonal\SlimHelper\Http\Response;

use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ResponseXML
 * @package Pentagonal\SlimHelper\Http\Response
 */
class ResponseXML extends ResponseAbstract
{
    /**
     * @var string
     */
    protected $mimeType = 'application/xml';
    /**
     * @var bool
     */
    protected $recheckMimeType = false;

    /**
     * Callback XML Looping
     *
     * @param \SimpleXMLElement $xml
     * @param mixed             $data
     */
    protected function xmlLoop(\SimpleXMLElement &$xml, $data)
    {
        if (is_array($data) || $data instanceof \Iterator) {
            foreach ($data as $key => $value) {
                if (is_array($value) || $value instanceof \Iterator) {
                    if (is_numeric($key) || is_float($key)) {
                        $xml2 = $xml->addChild('array');
                        $xml2->addAttribute('identifier', $key);
                        $xml2->addAttribute('type', gettype($key));
                    } else {
                        $xml2 = $xml->addChild($key);
                    }
                    $this->xmlLoop($xml2, $value);
                    continue;
                }
                if (is_numeric($key)) {
                    $xml2 = $xml->addChild('array', $value);
                    $xml2->addAttribute('identifier', $key);
                    $xml2->addAttribute('type', gettype($key));
                    continue;
                }

                $xml->addChild($key, $value);
            }
        } else {
            if (! is_string($data) || is_numeric($data) || is_float($data)) {
                $xml2 = $xml->addChild(gettype($data), $data);
                if (!is_numeric($data) && is_float($data)) {
                    $data = serialize($data);
                } else {
                    $xml2->addAttribute('identifier', $data);
                }
                $xml2->addAttribute('type', gettype($data));
                return;
            }
            $xml->addChild($data);
        }
    }

    /**
     * {@inheritdoc}
     * @return ResponseInterface
     */
    public function serve()
    {
        $xml = new \SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><root/>');
        $this->xmlLoop($xml, $this->data);
        $response = $this->response->withBody(new Stream(fopen('php://temp', 'r+')));
        if ($this->encoding == JSON_PRETTY_PRINT && function_exists('dom_import_simplexml')) {
            $xml = dom_import_simplexml($xml)->ownerDocument;
            $xml->formatOutput = true;
            $xml = $xml->saveXML();
        } else {
            $xml = $xml->asXML();
        }

        $response->getBody()->write($xml);
        $responseWithXml = $response->withHeader('Content-Type', $this->generateTheContentType());
        if (isset($this->statusCode)) {
            return $responseWithXml->withStatus($this->statusCode);
        }

        return $responseWithXml;
    }
}
