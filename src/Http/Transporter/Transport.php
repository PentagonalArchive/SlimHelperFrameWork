<?php
namespace Pentagonal\SlimHelper\Http\Transporter;

use GuzzleHttp\Client;
use GuzzleHttp\Cookie\CookieJar;
use GuzzleHttp\Cookie\SessionCookieJar;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Pentagonal\SlimHelper\Exception\TransportMethodNotAllowed;

/**
 * Class Transport
 * @package Pentagonal\SlimHelper\Http\Transporter
 *
 * @method static Transport connect(string $url, array $config = [])
 * @method static Transport copy(string $url, array $config = [])
 * @method static Transport delete(string $url, array $config = [])
 * @method static Transport get(string $url, array $config = [])
 * @method static Transport head(string $url, array $config = [])
 * @method static Transport link(string $url, array $config = [])
 * @method static Transport lock(string $url, array $config = [])
 * @method static Transport options(string $url, array $config = [])
 * @method static Transport post(string $url, array $config = [])
 * @method static Transport put(string $url, array $config = [])
 * @method static Transport purge(string $url, array $config = [])
 * @method static Transport patch(string $url, array $config = [])
 * @method static Transport propfind(string $url, array $config = [])
 * @method static Transport trace(string $url, array $config = [])
 * @method static Transport unlink(string $url, array $config = [])
 * @method static Transport unlock(string $url, array $config = [])
 * @method static Transport view(string $url, array $config = [])
 */
class Transport
{
    /**
     * Default Request Method
     * @const string
     */
    const DEFAULT_METHOD = self::METHOD_GET;
    /**
     * Available Methods
     */
    const METHOD_CONNECT = 'CONNECT';
    const METHOD_COPY    = 'COPY';
    const METHOD_DELETE  = 'DELETE';
    const METHOD_GET     = 'GET';
    const METHOD_HEAD    = 'HEAD';
    const METHOD_LINK    = 'LINK';
    const METHOD_LOCK    = 'LOCK';
    const METHOD_OPTIONS = 'OPTIONS';
    const METHOD_POST    = 'POST';
    const METHOD_PUT     = 'PUT';
    const METHOD_PURGE   = 'PURGE';
    const METHOD_PATCH   = 'PATCH';
    const METHOD_TRACE   = 'TRACE';
    const METHOD_UNLINK  = 'UNLINK';
    const METHOD_UNLOCK  = 'UNLOCK';
    const METHOD_VIEW    = 'VIEW';
    const METHOD_PROPFIND= 'PROFIND';

    const PARAM_FORM  = 'form_params';
    const PARAM_FILES = 'multipart';
    const PARAM_MULTIPART = self::PARAM_FILES;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Client
     */
    protected $client;

    /**
     * Use as Common Browsers
     * @var array
     */
    protected $configs_default = [
        'headers' => [
            'User-Agent' => 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:50.0) Gecko/20100101 Firefox/50.0',
        ],
        'timeout'         => 10,
        'allow_redirects' => true,
    ];

    /**
     * @var array
     */
    protected $configs = [];

    /**
     * @var string
     */
    protected $method = 'GET';

    /**
     * @var Response
     */
    protected $response;

    /**
     * Transport constructor.
     * @param string $url
     * @param array  $config
     */
    public function __construct($url, array $config = [])
    {
        if (is_string($url)) {
            $config['base_uri'] = $url;
        }

        /**
         * Just Manipulate
         */
        $this->configs = array_merge($this->configs_default, $config);
        // roll headers to default
        if (!is_array($this->configs['headers'])) {
            $this->configs['headers'] = $this->configs_default['headers'];
        }

        $this->request = new Request($this->method, $url);
        $this->client = new Client($this->configs);
    }

    /**
     * Manipulating Firefox Version (just fake)
     *      Update interval is about 6 months once
     * @return void
     */
    protected function manipulateUserAgentDefaultConfigs()
    {
        $this->configs_default['headers']['User-Agent'] = self::getBrowserUserAgentGenerated();
    }

    /**
     * Get generate User Agent
     *
     * @return string
     */
    public static function getBrowserUserAgentGenerated()
    {
        static $ua;
        if (isset($ua)) {
            return $ua;
        }

        $year  = abs(@date('Y'));
        if ($year <= 2016) {
            return $ua = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:50.0) Gecko/20100101 Firefox/50.0';
        }

        $user_agent = 'Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:[version].0) Gecko/20100101 Firefox/[version].0';
        $month      = abs(@date('m'));
        $version    = 50;
        $version   += (($year-2017) - (6 % $month === 0 ? 1 : 0));
        return $ua = str_replace('[version]', $version, $user_agent);
    }

    /**
     * Set Method
     *
     * @param string|null|bool $method GET|PUT|HEAD|POST ... etc
     *                                 false|null to fallback to default
     *
     * @return Transport
     */
    public function withMethod($method)
    {
        if ($method === null || $method === false) {
            $method = self::DEFAULT_METHOD;
        }

        if (!is_string($method)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Method must be as a string %s given',
                    gettype($method)
                ),
                E_USER_ERROR
            );
        }
        if ($method == '') {
            throw new \InvalidArgumentException(
                'Method could not to be empty',
                E_USER_ERROR
            );
        }

        $transport = clone $this;
        $method  = trim(strtoupper($method));
        $transport->request = $this->request->withMethod($method);
        $transport->method  = $transport->request->getMethod();
        return $transport;
    }

    /**
     * With URI
     *
     * @param string|UriInterface $uri
     * @return Transport
     */
    public function withUri($uri)
    {
        if (!is_string($uri) && ! $uri instanceof UriInterface) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Url must be as a string %s or %s given',
                    UriInterface::class,
                    gettype($uri)
                ),
                E_USER_ERROR
            );
        }
        if (! $uri instanceof UriInterface) {
            $uri = new Uri($uri);
        }

        $transport = clone $this;
        $transport->request = $transport->request->withUri($uri);
        $configs = $transport->client->getConfig();
        $transport->configs['base_uri'] = (string) $uri;
        $configs['base_uri'] = $transport->configs['base_uri'];
        $transport->client = new Client($configs);

        return $transport;
    }

    /**
     * @param ResponseInterface $response
     * @return Transport
     */
    public function setResponse(ResponseInterface $response)
    {
        $this->response = $response;
        return $this;
    }

    /**
     * Sending Request
     *
     * @param null|string               $method GET|PUT|HEAD|POST ... etc
     *                                      null to fallback default
     * @param string|UriInterface       $uri    Url target
     * @param array                     $config Configurations
     * @return \Psr\Http\Message\ResponseInterface|\Exception
     */
    public function send($method = null, $uri = null, array $config = [])
    {
        // pass reference on send
        $transport =& $this;
        if (is_string($method)) {
            $transport = $this->withMethod($method);
        }

        if (is_string($uri) && trim($uri)) {
            $transport->configs['base_uri'] = $uri;
            $config = $transport->client->getConfig();
            $config['base_uri'] = $uri;
            $transport->client = new Client($config);
        } elseif ($uri && $uri instanceof UriInterface) {
            $transport = $this->withUri($uri);
        }

        try {
            $response = $transport->client->send($transport->request, $config);
            if (!$response instanceof ResponseInterface) {
                return $response;
            }
            return $transport
                ->setResponse($response)
                ->getResponse();
        } catch (\Exception $e) {
            return $e;
        }
    }

    /**
     * Getting Result response Body
     * @param-read null|string          $method GET|PUT|HEAD|POST ... etc
     *                                     null to fallback default
     * @param-read string|UriInterface  $uri    Url target
     * @param-read array                $config Configurations
     *
     * @return Response|null
     */
    public function getResponse()
    {
        if (func_num_args() || ! isset($this->response)) {
            call_user_func_array([$this, 'send'], func_get_args());
        }

        return $this->response;
    }

    /**
     * Getting Result response Body
     *
     * @param-read null|string          $method GET|PUT|HEAD|POST ... etc
     *                                     null to fallback default
     * @param-read string|UriInterface  $uri    Url target
     * @param-read array                $config Configurations
     *
     * @return \GuzzleHttp\Psr7\Stream|null|\Psr\Http\Message\StreamInterface
     */
    public function getResponseBody()
    {
        $response = call_user_func_array([$this, 'getResponse'], func_get_args());
        return $response ? $response->getBody() : null;
    }

    /**
     * Getting Result response Body
     *
     * @param-read null|string          $method GET|PUT|HEAD|POST ... etc
     *                                     null to fallback default
     * @param-read string|UriInterface  $uri    Url target
     * @param-read array                $config Configurations
     *
     * @return string
     */
    public function getResponseString()
    {
        $body = call_user_func_array([$this, 'getResponseBody'], func_get_args());
        return (string) $body;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Get array configurations
     *
     * @return array
     */
    public function getConfigs()
    {
        return $this->configs;
    }

    /**
     * Set Header
     *
     * @param string $keyName Header Name key, The key will be convert into
     *                        First Character after `-`(dash) into uppercase
     *                        And space will be replace as `dash`
     * @param string $value
     * @return Transport
     */
    public function setHeader($keyName, $value)
    {
        if (!is_string($keyName)) {
            return $this;
        }

        $keyName = ucwords(trim($keyName), '-');
        if ($keyName == '') {
            return $this;
        }
        if (!isset($this->configs['headers'])) {
            $this->configs['headers'] = [];
        }
        // convert boolean value
        if (is_bool($value)) {
            $value = $value? '1' : '0';
        }

        if (!is_string($value) && ! is_scalar($value)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Header value for %s must be as a string or scalar value, %s given.',
                    $keyName,
                    gettype($value)
                )
            );
        }
        $this->configs['headers'][$keyName] = $value;
        $this->request = $this->request->withHeader($keyName, $value);

        // set client
        $configs = $this->client->getConfig();
        $configs['headers'] = $this->configs['headers'];
        $this->client = new Client($configs);

        return $this;
    }

    /**
     * Get Header User Agent
     * @param string    $keyName the Key name of header
     * @param bool|null $default default value for header if not exists
     * @return null|mixed
     */
    public function getHeader($keyName, $default = null)
    {
        if (!is_string($keyName)) {
            return $default;
        }
        $keyName = ucwords(trim($keyName), '-');
        if ($keyName !== '') {
            return $default;
        }
        if (! isset($this->configs['headers'])) {
            return $default;
        }
        if (isset($this->configs['headers'][$keyName])) {
            return $this->configs['headers'][$keyName];
        }
        if ($default === true) {
            return isset($this->configs_default['headers'][$keyName])
                ? $this->configs_default['headers'][$keyName]
                : $default;
        }

        return $default;
    }

    /**
     * Remove Header
     *
     * @param string $keyName the key name of header
     * @return Transport
     */
    public function removeHeader($keyName)
    {
        if (is_string($keyName)) {
            $keyName = ucwords(trim($keyName), '-');
            if ($keyName !== '' && isset($this->configs['headers'])) {
                $this->request->withoutHeader($keyName);
                unset($this->configs['headers'][$keyName]);
                // set client
                $configs = $this->client->getConfig();
                if (isset($configs['headers'])) {
                    $configs['headers'] = $this->configs['headers'];
                    $this->client = new Client($configs);
                }
            }
        }
        return $this;
    }

    /**
     * @param Client $client
     * @return Transport
     */
    public function withClient(Client $client)
    {
        $transport = clone $this;
        $transport->client = $client;
        return $transport;
    }

    /**
     * Remove Multiple Headers
     *
     * @param array $headersName Collection of header name
     * @return Transport
     */
    public function removeHeaders(array $headersName)
    {
        foreach ($headersName as $key => $value) {
            $this->removeHeader($value);
        }
        return $this;
    }

    /**
     * Replace Headers Value
     *
     * @param array $headers collection headers array
     * @return Transport
     */
    public function replaceHeaders(array $headers)
    {
        foreach ($headers as $key => $value) {
            $this->setHeader($key, $value);
        }

        return $this;
    }

    /**
     * Set All Headers Value
     *
     * @param array $headers collection headers to replace old headers
     * @return Transport
     */
    public function setHeaders(array $headers)
    {
        $this->configs['headers'] = [];
        return $this->replaceHeaders($headers);
    }

    /**
     * Getting Configs
     *
     * @param string $keyName The config key name
     * @param mixed  $default default value if config does not exists
     * @return mixed
     */
    public function getConfig($keyName, $default)
    {
        if (! is_string($keyName)) {
            return $default;
        }

        if (isset($this->configs[$keyName])) {
            return $this->configs[$keyName];
        }

        return $default;
    }

    /**
     * Set Config
     *
     * @param string $keyName the config key name for config
     * @param mixed  $values   value to save on config
     * @return Transport
     */
    public function setConfig($keyName, $values)
    {
        if (is_string($keyName)) {
            // headers only accept array
            if ($keyName == 'headers') {
                if (! is_array($values)) {
                    return $this;
                }
                $this->replaceHeaders($values);
                return $this;
            }

            $configs = $this->client->getConfig();
            $configs[$keyName] = $values;
            $this->configs[$keyName] = $configs[$keyName];
            $this->client = new Client($configs);
        }

        return $this;
    }

    /**
     * Retrieve Transport with Cookie enabled
     *
     * @return Transport
     */
    public function withCookie()
    {
        $transport = clone $this;
        $transport->setConfig('cookies', true);
        return $transport;
    }

    /**
     * Retrieve Transport with cookie @uses CookieJar
     *
     * @param CookieJar|null $cookieJar
     * @return $this
     */
    public function withCookieJar(CookieJar $cookieJar = null)
    {
        $transport = clone $this;
        $transport->setConfig('cookies', $cookieJar ?: new CookieJar);
        return $transport;
    }

    /**
     * Retrieve Transport with Cookie session @uses SessionCookieJar
     *
     * @param SessionCookieJar|null $cookieJar
     * @return Transport
     */
    public function withCookieSession(SessionCookieJar $cookieJar = null)
    {
        $transport = clone $this;
        $transport->setConfig('cookies', $cookieJar ?: new SessionCookieJar(__CLASS__));
        return $transport;
    }

    /**
     * Retrieve Transport with header like a browser uses
     *
     * @return Transport
     */
    public function withBrowser()
    {
        // browser manipulation
        return $this->replaceHeaders(
            [
                'User-Agent'      => self::getBrowserUserAgentGenerated(),
                'Accept'          => 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8',
                'Accept-Encoding' => 'gzip, deflate',
                'Accept-Language' => 'en-US,en;q=0.5',
                'Connection'      => 'keep-alive',
                'Pragma'          => 'no-cache',
                'Cache-Control'   => 'no-cache',
                'Upgrade-Insecure-Requests' => '1',
            ]
        );
    }

    /**
     * Retrieve Transport with Default Header set
     *
     * @return Transport
     */
    public function withoutBrowser()
    {
        return $this->removeHeaders(
            [
                'Accept',
                'Accept-Encoding',
                'Accept-Language',
                'Connection',
                'Pragma',
                'Upgrade-Insecure-Requests'
            ]
        );
    }

    /**
     * Without Sending Cookie
     *
     * @return Transport
     */
    public function withoutCookie()
    {
        $this->configs['cookies'] = false;
        return $this;
    }

    /**
     * Method Allowed
     *
     * @param string $method
     * @return bool|string string if allowed method
     */
    public static function allowedMethod($method)
    {
        if (is_string($method) && defined(__CLASS__ .'::METHOD_'.trim(strtoupper($method)))) {
            return trim(strtoupper($method));
        }

        return false;
    }

    /**
     * set Parameters
     *
     * @param array  $params
     * @param string $type Transport::PARAM_FORM | Transport::PARAM_MULTIPART
     * @return Transport
     */
    public function setParams(array $params = [], $type = self::PARAM_FORM)
    {
        if ($type != self::PARAM_FORM && $type != self::PARAM_MULTIPART) {
            $type = self::PARAM_FORM;
        }

        return $this->setConfig($type, $params);
    }

    /**
     * Magic Method
     *
     * @param string $method
     * @param array  $arguments
     * @return Transport
     */
    public function __call($method, array $arguments)
    {
        if (empty($arguments)) {
            throw new \InvalidArgumentException(
                'Arguments Could not be empty',
                E_USER_ERROR
            );
        }
        $arguments = array_values($arguments);
        if (!is_string($arguments[0]) && ! $arguments[0] instanceof UriInterface) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Argument 1 must be as a string %s or %s given',
                    UriInterface::class,
                    gettype($arguments[0])
                ),
                E_USER_ERROR
            );
        }

        /**
         *  Check available Method
         */
        $old_method  = $method;
        if (($method = $this->allowedMethod($method)) === false || !is_string($method)) {
            throw new TransportMethodNotAllowed(
                sprintf(
                    'Method %s is not Allowed!',
                    $old_method
                ),
                E_USER_ERROR
            );
        }

        $transport = $this->withMethod($method)->withUri($arguments[0]);
        if (isset($arguments[1]) && !is_array($arguments[1])) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Argument 2 must be as an array %s given',
                    gettype($arguments[0])
                ),
                E_USER_ERROR
            );
        }
        if (isset($arguments[1])) {
            foreach ($arguments[1] as $key => $value) {
                $transport->setConfig($key, $value);
            }
        }

        return $transport;
    }

    /**
     * Call Static Method
     *
     * @param string $name      Method
     * @param array  $arguments Argument array
     * @return Transport
     */
    public static function __callStatic($name, array $arguments)
    {
        if (empty($arguments)) {
            throw new \InvalidArgumentException(
                'Arguments Could not be empty',
                E_USER_ERROR
            );
        }
        $arguments = array_values($arguments);
        if (!is_string($arguments[0]) && ! $arguments[0] instanceof UriInterface) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Argument 1 must be as a string %s or %s given',
                    UriInterface::class,
                    gettype($arguments[0])
                ),
                E_USER_ERROR
            );
        }
        $url = $arguments[0];
        array_shift($arguments);
        array_unshift($arguments, $name);
        array_unshift($arguments, $url);
        return call_user_func_array(
            [Transport::class, 'method'],
            $arguments
        );
    }

    /**
     * Create New Request
     *
     * @param string $method GET|PUT|HEAD|POST ... etc
     *                       null|not string to fallback default @uses Transport::DEFAULT_METHOD
     * @param string $url    Url target
     * @param array  $config Configurations
     * @return Transport
     */
    public static function method($url, $method = self::DEFAULT_METHOD, array $config = [])
    {
        $transport = new static($url, $config);
        if (!is_string($method) || trim($method) == '') {
            $method = static::DEFAULT_METHOD;
        }

        $old_method = $method;
        if (($method = $transport->allowedMethod($method)) === false || !is_string($method)) {
            throw new TransportMethodNotAllowed(
                sprintf(
                    'Method %s is not Allowed!',
                    $old_method
                ),
                E_USER_ERROR
            );
        }

        return $transport->withMethod($method);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->getResponseBody();
    }
}
