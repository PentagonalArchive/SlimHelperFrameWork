<?php
namespace Pentagonal\SlimHelper\Http\Transporter;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SessionCookieJar;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use Pentagonal\SlimHelper\Record\Arrays\CollectionSortable;
use Psr\Http\Message\ResponseInterface;

/**
 * Class MultipleTransport
 * @package Pentagonal\SlimHelper\Http\Transporter
 */
class MultipleTransport
{
    /**
     * @var Transport[]
     */
    protected $transport_collections = [];

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var CollectionSortable|ResponseInterface
     */
    protected $last_response;

    /**
     * @var int
     */
    protected $increment = 1;

    /**
     * MultipleTransport constructor.
     * @param Transport|null $transport
     */
    public function __construct(Transport $transport = null)
    {
        if (is_null($transport)) {
            $this->client = new Client();
        } else {
            $this->client = $transport->getClient();
        }
        $this->last_response = new CollectionSortable();
    }

    /**
     * Add Transport Request
     *
     * @param Transport|string $transport
     * @return MultipleTransport
     */
    public function add($transport)
    {
        if (! $transport instanceof Transport) {
            $transport = new Transport($transport);
        }

        $args = new CollectionSortable(func_get_args());
        $args->shift();
        $methodHasSet = false;
        foreach ($args as $prop) {
            if (is_array($prop)) {
                $prop = new Client($prop);
            }
            if ($prop instanceof Client) {
                $transport = $transport->withClient($prop);
                continue;
            }
            if (is_string($prop)) {
                if (! $methodHasSet
                    && strlen($prop) > 2
                    && strlen($prop) < 8
                    && defined(Transport::class . '::'. $prop)
                ) {
                    $transport = $transport->withMethod($prop);
                } else {
                    $name = $prop;
                }
                continue;
            }
            if ($prop instanceof CookieJar) {
                $transport = $transport->withCookieJar($prop);
                continue;
            }
            if ($prop instanceof SessionCookieJar) {
                $transport = $transport->withCookieSession($prop);
                continue;
            }
        }

        if (!isset($name) || !$name) {
            $name = $this->increment++;
        }

        $this->transport_collections[$name] = $transport;
        return $this;
    }

    /**
     * Clearing The Request
     *
     * @return MultipleTransport
     */
    public function clear()
    {
        $this->transport_collections = [];
        $this->last_response->clear();
        return $this;
    }

    /**
     * Remove Request
     *
     * @param int|string $position integer key name or Domain name parse
     * @return MultipleTransport
     */
    public function remove($position)
    {
        if (empty($this->transport_collections)) {
            return $this;
        }
        if (is_numeric($position)) {
            unset($this->transport_collections[$position]);
        } elseif (is_string($position)) {
            $position = trim(strtolower($position));
            if ($position == '') {
                return $this;
            }

            $changed = false;
            foreach ($this->transport_collections as $key => $transport) {
                if ($transport->getRequest()->getUri() == $position) {
                    $changed = true;
                    unset($this->transport_collections[$key]);
                }
            }

            if ($changed) {
                $this->transport_collections = array_values($this->transport_collections);
            }
        }
        return $this;
    }

    /**
     * Sending Transport Batch Pool
     *
     * @param null|Transport|Client $transport
     * @return CollectionSortable|Transport[]|RequestException[]|\Exception[]
     */
    public function send($transport = null)
    {
        if (empty($this->transport_collections)) {
            return null;
        }
        if (!is_null($transport)) {
            if ($transport instanceof Client) {
                $this->client = $transport;
            } elseif ($transport instanceof Transport) {
                $this->client = $transport->getClient();
            }
        }

        $this->last_response->clear();
        $pools = [];
        foreach ($this->transport_collections as $key => $transport) {
            $pools[$key] = $transport->getRequest();
        }
        $result = Pool::batch(
            $this->client,
            $pools
        );
        unset($pools);
        foreach ($this->transport_collections as $key => $transport) {
            if (isset($result[$key])) {
                if ($result[$key] instanceof ResponseInterface) {
                    $transport->setResponse($result[$key]);
                } else {
                    $transport = $result[$key];
                }
            }

            $this->last_response->set($key, $transport);
        }
        return $this->last_response;
    }

    /**
     * Create New Object instance
     *
     * @param Transport|null $transport
     * @return static
     */
    public static function create(Transport $transport = null)
    {
        if (!is_null($transport)) {
            return new static;
        }

        return new static($transport);
    }
}
