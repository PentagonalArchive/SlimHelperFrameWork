<?php
namespace Pentagonal\SlimHelper;

/**
 * Class AutoLoader
 * @package Pentagonal\SlimHelper
 */
class AutoLoader
{
    /**
     * @var string
     */
    protected $nameSpace = '';

    /**
     * @var string
     */
    protected $directory;

    /**
     * Load Class Name
     *
     * @param string $className
     * @throws \InvalidArgumentException
     */
    public function load($className)
    {
        if (!is_string($className)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Invalid argument 1, Class Name must be as a string %s given',
                    gettype($className)
                ),
                E_ERROR
            );
        }
        $className = ltrim($className, '\\');
        // stop here if not match or class already exists
        if (class_exists($className) || stripos($className, $this->nameSpace) !== 0) {
            return;
        }

        $className = preg_replace('/(\\\|\/)+/', '/', substr($className, strlen($this->nameSpace)));
        $this->protectInclude(rtrim($this->directory, '/') . '/' . ltrim($className, '/') . '.php');
    }

    /**
     * @param $file
     * @return mixed
     */
    public function protectInclude($file)
    {
        $closure =  function ($file) {
            if (file_exists($file)) {
                /** @noinspection PhpIncludeInspection */
                require_once $file;
            }
        };

        $closure->bindTo(new Nop());
        return $closure($file);
    }

    /**
     * Create Object instance
     *
     * @param $nameSpace
     * @param $directory
     * @return AutoLoader
     * @throws \InvalidArgumentException
     */
    public static function create($nameSpace, $directory)
    {
        /**
         * Instance to Current Name Space
         */
        if (!class_exists(__NAMESPACE__ .'\\Nop')) {
            require_once __DIR__ . '/Nop.php';
            $autoload = new static();
            $autoload->nameSpace = __NAMESPACE__;
            $autoload->directory = __DIR__;
            \spl_autoload_register([$autoload, 'load']);
        }

        if ($nameSpace && !is_string($nameSpace)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Autoload Name Space must be as a string %s given',
                    gettype($nameSpace)
                ),
                E_USER_ERROR
            );
        }
        if (!is_string($directory)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Autoload Source Directory must be as a string %s given',
                    gettype($directory)
                ),
                E_USER_ERROR
            );
        }
        if (trim($directory) == '') {
            throw new \InvalidArgumentException(
                'Autoload Source Directory could not be empty',
                E_USER_ERROR
            );
        }
        $autoload = new static();
        $autoload->nameSpace = !$nameSpace ? '' : trim($nameSpace);
        // self resolve
        if ($autoload->nameSpace != '') {
            $autoload->nameSpace = preg_replace('/(\\\|\/)+/', '\\', $autoload->nameSpace);
            $autoload->nameSpace = trim($autoload->nameSpace, '\\') . '\\';
        }

        $autoload->directory = rtrim(preg_replace('/(\\\|\/)+/', '/', $directory), '/');

        return $autoload;
    }

    /**
     * Register Autoload
     *
     * @param string $nameSpace
     * @param string $directory
     * @return bool
     */
    public static function register($nameSpace, $directory)
    {
        /**
         * @var AutoLoader $autoload
         */
        $autoload = call_user_func_array(__CLASS__ . '::create', func_get_args());
        if ($autoload->nameSpace == __NAMESPACE__) {
            return false;
        }
        return \spl_autoload_register($autoload);
    }

    /**
     * Multiple registers
     *
     * @param array $details
     */
    public static function registers(array $details)
    {
        foreach ($details as $nameSpace => $directory) {
            self::register($nameSpace, $directory);
        }
    }

    /**
     * @invokable
     */
    public function __invoke()
    {
        call_user_func_array([$this, 'load'], func_get_args());
    }
}
