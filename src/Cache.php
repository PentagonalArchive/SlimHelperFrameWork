<?php
namespace Pentagonal\SlimHelper;

use Doctrine\Common\Cache\CacheProvider;
use Doctrine\Common\Cache\CouchbaseCache;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\Common\Cache\MemcacheCache;
use Doctrine\Common\Cache\MemcachedCache;
use Doctrine\Common\Cache\PhpFileCache;
use Doctrine\Common\Cache\RedisCache;
use Doctrine\Common\Cache\RiakCache;
use Doctrine\DBAL\Cache\CacheException;

/**
 * Class Cache
 * Cache Manager to manage and abstractions data cache
 *
 * @author awan nawa {@link http://dasdaa} the name of author
 * @author rudi {@link http://dasdaa} the name of author
 * @license MIT @link http://www.domain.com
 * @package Nat
 * @link Nat kikukkk
 * @subpackage Cache
 * @version 1.0
 * @copyright 2016 Pentagonal Development
 * @uses \Doctrine\Common\Cache\CacheProvider
 * @todo use assignment
 * -------------------- List Methods ---------------------
 *
 * @method bool          contains(string $id)
 * @method bool          delete(string $id)
 * @method bool          deleteAll()
 * @method mixed         fetch(string $id)
 * @method array|mixed[] fetchMultiple(array $keys)
 * @method bool          flushAll()
 * @method string        getNamespace()
 * @method array|null    getStats()
 * @method bool          save(string $id, mixed $data, int $lifetime = 0)
 * @method bool          saveMultiple(array $keysAndValues, int $lifetime = 0)
 * @method void          setNamespace(string $nameSpace)
 */
class Cache
{
    /**
     * Default Cache Constant
     */
    const STATS_HITS             = CacheProvider::STATS_HITS;
    const STATS_MISSES           = CacheProvider::STATS_MISSES;
    const STATS_UPTIME           = CacheProvider::STATS_UPTIME;
    const STATS_MEMORY_USAGE     = CacheProvider::STATS_MEMORY_USAGE;
    const STATS_MEMORY_AVAILABLE = CacheProvider::STATS_MEMORY_AVAILABLE;

    /**
     * APC use APCU instead
     */
    const APC   = '\\Doctrine\\Common\\Cache\\ApcuCache';
    const APCU  = self::APC;

    /**
     * use FILE_SYSTEM instead
     */
    const FILE  = '\\Doctrine\\Common\\Cache\\FileSystemCache';
    const FILE_SYSTEM  = self::FILE;

    /**
     * Use COUCH_BASE instead
     */
    const COUCH       = '\\Doctrine\\Common\\Cache\\CouchbaseCache';
    const COUCHBASE   = self::COUCH;
    const COUCH_BASE  = self::COUCH;

    /**
     * use MONGO_DB instead
     */
    const MONGO     = '\\Doctrine\\Common\\Cache\\MongoDBCache';
    const MONGO_DB  = self::MONGO;

    /**
     * php extension file
     */
    const PHP          = '\\Doctrine\\Common\\Cache\\PhpFileCache';
    const PHP_FILE     = self::PHP;
    /**
     * use WIN_CACHE instead
     */
    const WINCACHE     = '\\Doctrine\\Common\\Cache\\WinCacheCache';
    const WIN_CACHE    = self::WINCACHE;
    /**
     * use X_CACHE instead
     */
    const XCACHE    = '\\Doctrine\\Common\\Cache\\XcacheCache';
    const X_CACHE   = self::XCACHE;
    /**
     * use ZEND_DATA instead
     */
    const ZEND      = '\\Doctrine\\Common\\Cache\\ZendDataCache';
    const ZEND_DATA = self::ZEND;

    const ARRAYS        = '\\Doctrine\\Common\\Cache\\ArrayCache';
    const CHAIN        = '\\Doctrine\\Common\\Cache\\ChainCache';
    const MEMCACHE     = '\\Doctrine\\Common\\Cache\\MemcacheCache';
    const MEMCACHED    = '\\Doctrine\\Common\\Cache\\MemcachedCache';
    const PREDIS       = '\\Doctrine\\Common\\Cache\\PredisCache';
    const REDIS        = '\\Doctrine\\Common\\Cache\\RedisCache';
    const RIAK         = '\\Doctrine\\Common\\Cache\\RiakCache';
    const SQLITE       = '\\Doctrine\\Common\\Cache\\SQLite3Cache';
    const SQLITE3      = self::SQLITE;
    const VOID         = '\\Doctrine\\Common\\Cache\\VoidCache';
    const DEFAULT_CACHE= self::ARRAYS;

    /**
     * @var array
     */
    protected $config = [];

    /**
     * @var CacheProvider|MemcachedCache|MemcacheCache|RedisCache|CouchbaseCache|RiakCache
     */
    protected $resource;

    /**
     * Cache constructor.
     * @param array $config configuration structures
     *                      [
     *                          'driver' => string $driver,
     *                          .... follow cache config
     *                      ]
     * @property-read string|\Doctrine\Common\Cache\Cache $driver
     */
    public function __construct(array $config = [])
    {
        $this->sanitizeTest($config);
    }

    /**
     * @param mixed $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->fetch($id);
    }

    /**
     * Magic Method
     *
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        if (method_exists($this->resource, $name)) {
            return call_user_func_array(
                [$this->resource, $name],
                $arguments
            );
        }

        throw new \BadMethodCallException(
            sprintf(
                'Method %s is not defined.',
                E_USER_ERROR
            )
        );
    }

    /**
     * Sanitize & Build resource
     *
     * @param array $config
     * @throws \ErrorException
     * @throws CacheException
     * @throws \ErrorException
     */
    protected function sanitizeTest(array $config)
    {
        if (!isset($config['driver'])) {
            $this->config['driver'] = self::DEFAULT_CACHE;
        } else {
            if (is_object($config['driver'])) {
                if ($config['driver'] instanceof CacheProvider) {
                    $this->config['driver'] = '\\'.get_class($config['driver']);
                    $chain = [];
                    if ($this->config['driver'] == self::CHAIN) {
                        if (isset($config['chain']) && is_array($config['chain'])) {
                            foreach ($config['chain'] as $value) {
                                if ($value instanceof CacheProvider) {
                                    $chain[] = $value;
                                }
                            }
                        }
                    }
                    $this->resource = $config['driver']($chain);
                } elseif (class_exists('MongoCollection')
                    && $config['driver'] instanceof \MongoCollection
                ) {
                    $this->config['driver'] = self::MONGO_DB;
                    $this->resource = new $this->config['driver']($config['driver']);
                } elseif (class_exists('\SQLite3')
                    && $config['driver'] instanceof \SQLite3
                ) {
                    $this->config['driver'] = self::SQLITE3;
                    if (!isset($config['table']) || !is_string($config['table'])) {
                        $config['table'] = 'doctrine_cache';
                    }
                    $this->config['table'] = $config['table'];
                    $this->resource = new $this->config['driver'](
                        $config['driver'],
                        $config['table']
                    );
                } elseif ($config['driver'] instanceof \Memcache) {
                    $this->config['driver'] = self::MEMCACHE;
                    $this->resource = new $this->config['driver'];
                    $this->resource->setMemcache($config['driver']);
                } elseif ($config['driver'] instanceof \Memcached) {
                    $this->config['driver'] = self::MEMCACHED;
                    $this->resource = new $this->config['driver'];
                    $this->resource->setMemCached($config['driver']);
                } /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection
                 *                PhpUndefinedClassInspection
                 *                PhpUndefinedNamespaceInspection
                 */
                elseif (interface_exists('\\Predis\\ClientInterface')
                    && $config['driver'] instanceof \Predis\ClientInterface
                ) {
                    $this->config['driver'] = self::PREDIS;
                    $this->resource = new $this->config['driver']($config['driver']);
                } elseif (class_exists('\\Redis')
                    && $config['driver'] instanceof \Redis
                ) {
                    $this->config['driver'] = self::REDIS;
                    $this->resource = new $this->config['driver'];
                    $this->resource->setRedis($config['driver']);
                } /** @noinspection PhpUndefinedClassInspection */
                elseif (class_exists('\\Couchbase')
                    && $config['driver'] instanceof \Couchbase
                ) {
                    $this->config['driver'] = self::COUCH_BASE;
                    $this->resource = new $this->config['driver'];
                    $this->resource->setCouchbase($config['driver']);
                } /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection
                 *                PhpUndefinedClassInspection
                 *                PhpUndefinedNamespaceInspection
                 */
                elseif (class_exists('\\Riak\\Bucket')
                    && $config['driver'] instanceof \Riak\Bucket
                ) {
                    $this->config['driver'] = self::RIAK;
                    $this->resource = new $this->config['driver']($config['driver']);
                } else {
                    throw new \ErrorException(
                        sprintf(
                            'Invalid selected driver use %s, Doctrine driver does ot exists!',
                            get_class($config['driver'])
                        ),
                        E_USER_ERROR
                    );
                }
            } else {
                $this->config['driver'] = $config['driver'];
            }
        }

        switch ($this->config['driver']) {
            case self::APCU:
                if (!function_exists('apcu_fetch')) {
                    throw new \ErrorException(
                        'APCU driver does not ready to use on your server. Please install APCU extension.',
                        E_ERROR
                    );
                }
                // create new Resource
                if (! $this->resource) {
                    $this->resource = new $this->config['driver'];
                }
                break;
            case self::ARRAYS:
            case self::VOID:
                if (! $this->resource) {
                    $this->resource = new $this->config['driver'];
                }
                break;
            case self::CHAIN:
                if (! $this->resource) {
                    $chain = [];
                    if (isset($config['chain']) && is_array($config['chain'])) {
                        foreach ($config['chain'] as $value) {
                            if ($value instanceof CacheProvider) {
                                $chain[] = $value;
                            }
                        }
                    }
                    $this->resource = new $this->config['driver']($chain);
                }
                break;
            case self::COUCH_BASE:
                if (!class_exists('\Couchbase')) {
                    throw new \ErrorException(
                        'Couchbase driver does not ready to use on your server.',
                        E_ERROR
                    );
                }
                if (! $this->resource) {
                    /** @noinspection PhpUndefinedClassInspection */
                    $couchBase = isset($config['couchbase'])
                    && $config['couchbase'] instanceof \Couchbase
                        ? $config['couchbase']
                        : (
                        isset($config['couch_base'])
                        && $config['couch_base'] instanceof \Couchbase
                            ? $config['couch_base']
                            : null
                        );

                    /** @noinspection PhpUndefinedClassInspection */
                    if (! $couchBase || ! $couchBase instanceof \Couchbase) {
                        throw new \ErrorException(
                            'Config `couchbase` must be determine an instance of \Couchbase class',
                            E_ERROR
                        );
                    }
                    unset($config['couch_base'], $config['couchbase']);
                    $this->resource = new $this->config['driver'];
                    $this->resource->setCouchbase($couchBase);
                }
                break;
            case self::FILE:
            case self::PHP:
                if (! $this->resource) {
                    $directory = isset($config['directory']) ? $config['directory'] : null;
                    $extension = isset($config['extension']) ? $config['extension']
                        : ($this->config['driver'] === self::FILE
                            ? FilesystemCache::EXTENSION
                            : PhpFileCache::EXTENSION
                        );
                    $uMask = isset($config['umask']) ? $config['umask'] : 0002;
                    if (!is_string($directory) || trim($directory)) {
                        throw new \ErrorException(
                            'Directory cache must be string and set as file system cache.',
                            E_ERROR
                        );
                    }
                    $this->resource = $this->config['driver']($directory, $extension, $uMask);
                }
                break;
            case self::MEMCACHE:
                if (!class_exists('\Memcache')) {
                    throw new \ErrorException(
                        'Memcache driver does not ready to use on your server. Please install Memcache extension.',
                        E_ERROR
                    );
                }
                if (! $this->resource) {
                    $config['port'] = isset($config['port']) ? $config['port'] : 11211;
                    $config['host'] = isset($config['host']) ? $config['host'] : 11211;
                    $config['timeout'] = isset($config['timeout']) && is_numeric($config['port'])
                        ? abs($config['timeout'])
                        : 1;
                    $memcache = new \Memcache();
                    $memcache->connect($config['port'], $config['port'], $config['timeout']);
                    $this->resource = new $this->config['driver'];
                    $this->resource->setMemcache($memcache);
                }
                break;
            case self::MEMCACHED:
                if (!class_exists('\Memcached')) {
                    throw new \ErrorException(
                        'Memcached driver does not ready to use on your server. Please install Memcached extension.',
                        E_ERROR
                    );
                }
                if (! $this->resource) {
                    $this->resource = new $this->config['driver'];
                    $this->resource->setMemcached(new \Memcached());
                }
                break;
            case self::MONGO_DB:
                if (!class_exists('\\MongoCollection')) {
                    throw new \ErrorException(
                        'MongoDB driver does not ready to use on your server. Please install MongoDB extension.',
                        E_ERROR
                    );
                }
                if (!$this->resource) {
                    $config['dbname'] = isset($config['dbname'])
                        ? $config['dbname']
                        : (isset($config['db_name'])
                            ? $config['db_name']
                            : null
                        );
                    if (!$config['dbname']) {
                        throw new \ErrorException(
                            'Database name could not be empty.',
                            E_USER_ERROR
                        );
                    }
                    $mongo = isset($config['mongo'])
                    && $config['mongo'] instanceof \MongoDB
                        ? $config['mongo']
                        : \MongoClient::DEFAULT_HOST;
                    $config['port'] = isset($config['port'])
                        ? $config['port']
                        : \MongoClient::DEFAULT_PORT;
                    $config['host'] = isset($config['host']) && is_string($config['host'])
                        ? $config['host']
                        : 'localhost';
                    if (stripos($config['host'], 'mongodb://') === 0) {
                        $config['host'] = substr($config['host'], 12);
                        if (trim($config['host']) == '') {
                            $config['host'] = \MongoClient::DEFAULT_HOST;
                        }
                    }
                    $config['options'] = isset($config['options']) && is_array($config['options'])
                        ? $config['options']
                        : [];
                    $config['options']['connect'] = true;
                    if (!$mongo) {
                        $mongo = new \MongoDB(
                            new \MongoClient(
                                "mongodb://{$config['host']}:{$config['port']}"
                            ),
                            $config['options']
                        );
                    }
                    $this->resource = new $this->config['driver'](
                        new \MongoCollection($mongo, $config['dbname'])
                    );
                }
                break;
            case self::PREDIS:
                if (!class_exists('\\Predis\\ClientInterface')) {
                    throw new \ErrorException(
                        'Invalid selected driver use Predis, Predis library does not exists!',
                        E_USER_ERROR
                    );
                }
                if (!$this->resource) {
                    /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection
                     *                PhpUndefinedClassInspection
                     *                PhpUndefinedNamespaceInspection
                     */
                    $pRedis = !isset($config['predis'])
                    || ! $config['predis'] instanceof \Predis\ClientInterface
                        ? null
                        : $config['predis'];
                    if (!$pRedis) {
                        throw new \ErrorException(
                            'Config pRedis must be defined as instance of \\Predis\\ClientInterface.',
                            E_ERROR
                        );
                    }
                    $this->resource = new $this->config['driver']($pRedis);
                    unset($config['predis']);
                }
                break;
            case self::REDIS:
                if (!class_exists('\Redis')) {
                    throw new \ErrorException(
                        'Redis driver does not ready to use on your server. Please install Redis extension.',
                        E_ERROR
                    );
                }
                if (!$this->resource) {
                    $port = isset($config['port'])
                        ? $config['port']
                        : 6379;
                    $host = isset($config['host'])
                        ? $config['host']
                        : '127.0.0.1';
                    $timeout = isset($config['timeout']) && is_numeric($config['timeout'])
                        ? abs($config['timeout'])
                        : 0.0;
                    if (isset($config['redis'])) {
                        if (!$config['redis'] instanceof \Redis) {
                            throw new \ErrorException(
                                'Config redis must be defined as instance of \\Redis.',
                                E_ERROR
                            );
                        }
                    } else {
                        $config['redis'] = new \Redis();
                    }

                    $connection = $config['redis']->connect($host, $port, $timeout);
                    if ($connection === false) {
                        throw new CacheException(
                            'Could not connect Redis Cache using given configuration'
                        );
                    }

                    $this->resource = new $this->config['driver']();
                    $this->resource->setRedis($config['redis']);
                    unset($config['redis']);
                }
                break;
            case self::RIAK:
                if (!class_exists('\\Riak\\Bucket')) {
                    throw new \ErrorException(
                        'Invalid selected driver use Riak, Riak library does not exists!',
                        E_USER_ERROR
                    );
                }
                if (!$this->resource) {
                    /** @noinspection PhpUnnecessaryFullyQualifiedNameInspection
                     *                PhpUndefinedClassInspection
                     *                PhpUndefinedNamespaceInspection
                     */
                    $bucket = !isset($config['bucket'])
                    || ! $config['bucket'] instanceof \Predis\ClientInterface
                        ? null
                        : $config['bucket'];
                    if (!$bucket) {
                        throw new \ErrorException(
                            'Config `bucket` must be defined as instance of \\Riak\\Bucket.',
                            E_ERROR
                        );
                    }
                    $this->resource = new $this->config['driver']($bucket);
                    unset($config['bucket'], $bucket);
                }
                break;
            case self::SQLITE3:
                if (!class_exists('\\SQLite3')) {
                    throw new \ErrorException(
                        'SQLite3 driver does not ready to use on your server. Please install SQLite3 extension.',
                        E_ERROR
                    );
                }
                if (!$this->resource) {
                    $sqlite = isset($config['sqlite3']) && $config['sqlite3'] instanceof \SQLite3
                        ? $config['sqlite3']
                        : (isset($config['sqlite']) && $config['sqlite'] instanceof \SQLite3
                            ? $config['sqlite']
                            : null
                        );
                    if (!$sqlite) {
                        $config['dbname'] = isset($config['dbname'])
                            ? $config['dbname']
                            : null;
                        if (!is_string($config['dbname'])
                            || !is_dir(dirname($config['dbname']))
                            || !is_writable(dirname($config['dbname']))
                        ) {
                            throw new \ErrorException(
                                'Invalid configuration for `dbname`, '
                                . '`dbname` must be as string and file name and directory must be writable',
                                E_ERROR
                            );
                        }
                        $config['password'] = isset($config['password'])
                            ? $config['password']
                            : null;
                        $sqlite = new \SQLite3(
                            $config['dbname'],
                            \SQLITE3_OPEN_CREATE | \SQLITE3_OPEN_READWRITE,
                            $config['password']
                        );
                    }
                    if (!isset($config['table']) || !is_string('table')) {
                        $config['table'] = 'cache';
                    }
                    $this->resource = new $this->config['driver']($sqlite, $config['table']);
                    unset($config['sqlite3']);
                }
                break;
            case self::WINCACHE:
                if (!function_exists('wincache_ucache_set')) {
                    throw new \ErrorException(
                        'WinCache driver does not ready to use on your server.',
                        E_ERROR
                    );
                }
                if (! $this->resource) {
                    $this->resource = new $this->config['driver'];
                }
                break;
            case self::X_CACHE:
                if (!function_exists('xcache_isset')) {
                    throw new \ErrorException(
                        'XCache driver does not ready to use on your server.',
                        E_ERROR
                    );
                }
                if (! $this->resource) {
                    $this->resource = new $this->config['driver'];
                }
                break;
            case self::ZEND:
                if (!function_exists('zend_disk_cache_store')) {
                    throw new \ErrorException(
                        'Zend Data Cache driver does not ready to use on your server.',
                        E_ERROR
                    );
                }
                if (! $this->resource) {
                    $this->resource = new $this->config['driver'];
                }
                break;
        }
        if (isset($config['namespace'])) {
            $this->resource->setNamespace($config['namespace']);
        }
        $config['driver'] = $this->config['driver'];
        $this->config = $config;
    }
}
