<?php
namespace Pentagonal\SlimHelper;

use Pentagonal\SlimHelper\Record\Arrays\Collection;
use Pimple\Container;

/**
 * Class Modules
 * @package Nat
 */
final class Modules
{
    const TYPE_FILE = 1;
    const TYPE_DIRECTORY = 2;

    /**
     * @var string
     */
    protected $moduleDirectory;

    /**
     * @var Collection|Module[][]
     */
    protected $modules;

    /**
     * @var array
     */
    protected $activeModules = [];

    /**
     * @var array
     */
    protected $calledModules = [];

    /**
     * @var array
     */
    protected $invalidModules = [];

    /**
     * @var array
     */
    protected $unwantedFiles = [];

    /**
     * @var bool
     */
    protected $hasInit = false;

    /**
     * @var array
     */
    protected static $registeredAutoload = [];

    /**
     * Modules constructor.
     * @param string $moduleDirectory
     */
    public function __construct($moduleDirectory)
    {
        $this->moduleDirectory = $moduleDirectory;
        $this->modules = new Collection();
    }

    /**
     * @return $this
     */
    public function init()
    {
        if (!$this->hasInit) {
            $this->hasInit = true;
            $this->readModules();
        }
        return $this;
    }

    /**
     * Read The Modules
     */
    protected function readModules()
    {
        if (!is_string($this->moduleDirectory)) {
            throw new \RuntimeException(
                sprintf(
                    'Invalid Module directory define. Module directory must be as string %s given',
                    gettype($this->moduleDirectory)
                )
            );
        }

        if (!is_dir($this->moduleDirectory)) {
            throw new \RuntimeException(
                sprintf(
                    'Invalid Module directory define. Module directory %s does not exists',
                    $this->moduleDirectory
                )
            );
        }

        $iterator = new \RecursiveDirectoryIterator($this->moduleDirectory);
        $this->moduleDirectory = $iterator->getRealPath();
        foreach ($iterator as $keyToCheck => $toCheck) {
            if ($toCheck->getBaseName() == '.' || $toCheck->getBaseName() == '..') {
                continue;
            }
            /**
             * @var \SplFileInfo $toCheck
             */
            if (! $toCheck->isDir()
                || !is_file($toCheck->getRealPath() . '/' . $toCheck->getBasename() .'.php')
                || preg_match('/[^a-z0-9\_]/i', $toCheck->getBasename())
                && ! preg_match('/^[a-z]([a-z0-9\_]+)?/i', $toCheck->getBasename())
            ) {
                $this->unwantedFiles[$toCheck->getRealPath()] = (
                    ! $toCheck->isDir()
                        ? self::TYPE_FILE
                        : self::TYPE_DIRECTORY
                );
                continue;
            }

            $file  = $toCheck->getRealPath() . '/' . $toCheck->getBasename() . '.php';
            $fileInfo = new \SplFileInfo($file);
            if (! $fileInfo->isExecutable()
                && ! $fileInfo->isLink()
                && $fileInfo->isReadable()
                && $fileInfo->getSize() < (4096*4)
            ) {
                $fileName = substr($fileInfo->getBasename(), 0, -4);
                $content = substr(php_strip_whitespace($file), 0, 2048);
                if (preg_match('/\<\?php\s+namespace\s+([^;]+)/ms', $content, $namespace)
                    && !empty($namespace[1]) && $namespace[1] == Module::class
                    && preg_match('/class\s+
                    (?P<class>[a-z][a-z0-9\_]+)   # class Name
                    \s+extends\s+
                    (?P<extends>[^\s]+) # extends
                /msix', $content, $class)
                    && !empty($class['class'])
                    && strtolower($class['class']) == strtolower($fileName)
                ) {
                    if (isset($this->modules[strtolower($class['class'])])) {
                        continue;
                    }
                    $className = '\\'.Module::class.'\\'.$class['class'];
                    if ($class['extends'] == '\\'.Module::class) {
                        // try to require
                        $this->protectedIncludeScope($fileInfo->getRealPath());
                    }
                    if (class_exists($className)) {
                        $this->modules[strtolower($class['class'])] = new $className();
                        continue;
                    }

                    preg_match(
                        '/use\s+
                    (?:\\\{1})?'.preg_quote(Module::class, '/').'
                    (?:\s+as\s+(?P<alias>[a-zA-Z][a-zA-Z0-9]+))?;+
                    /smx',
                        $content,
                        $asAlias
                    );
                    if (empty($asAlias)) {
                        $this->invalidModules[$fileInfo->getRealPath()] = 'Could not determine use class alias';
                        continue;
                    }
                    if (!empty($asAlias['alias'])) {
                        if ($asAlias['alias'] != $class['extends']) {
                            $this->invalidModules[$fileInfo->getRealPath()] = 'Use case class alias does not match';
                            continue;
                        }
                    } elseif ($class['extends'] != 'Module') {
                        $this->invalidModules[$fileInfo->getRealPath()] = 'Module class file does not extends '
                                . 'with Module abstract';
                        continue;
                    }

                    if (! preg_match('/public\s+function\s+init\([^\)]*\)\s*\{/smi', $content, $match)) {
                        $this->invalidModules[$fileInfo->getRealPath()] = 'Module does not have init method';
                        continue;
                    }

                    // try to require
                    $this->protectedIncludeScope($fileInfo->getRealPath());
                    if (!class_exists($className) || ! is_subclass_of($className, Module::class)) {
                        continue;
                    }
                    $this->modules[strtolower($class['class'])] = [
                        'directory'      => dirname($fileInfo->getRealPath()),
                        'object'         => new $className()
                    ];
                }
            }
        }
        unset($iterator, $content);
    }

    /**
     * @param string $path
     * @internal
     */
    private function protectedIncludeScope($path)
    {
        /** @noinspection PhpIncludeInspection */
        require_once $path;
    }

    /**
     * @return array
     */
    public function getInvalidModules()
    {
        $this->init();
        return $this->invalidModules;
    }

    /**
     * @return array
     */
    public function getUnwantedFiles()
    {
        $this->init();
        return $this->unwantedFiles;
    }

    /**
     * @return array
     */
    public function getModulesList()
    {
        $this->init();
        return $this->modules->keys();
    }

    /**
     * @param string $moduleName
     * @return bool
     */
    public function moduleExist($moduleName)
    {
        $this->init();
        if (is_string($moduleName) && trim($moduleName) != '') {
            $moduleName = strtolower($moduleName);
            return $this->modules->has($moduleName);
        } else {
            return false;
        }
    }

    /**
     * @return Collection
     */
    public function getModulesDetail()
    {
        $this->init();
        $retVal = new Collection();
        foreach ($this->modules as $key => $module) {
            $retVal[$key] = new Collection(
                [
                    'name'    => $module->getModuleName(),
                    'url'     => $module->getModuleUri(),
                    'version' => $module->getModuleVersion(),
                    'version_uri' => $module->getModuleVersionCheckUri(),
                    'description' => $module->getModuleDescription(),
                    'author'      => $module->getModuleAuthor(),
                    'author_url'  => $module->getModuleAuthorUri()
                ]
            );
        }

        return $retVal;
    }

    /**
     * Activate Module
     *
     * @param string    $moduleName
     * @param Container $container
     * @return Module|null
     */
    public function load($moduleName, Container $container)
    {
        $this->init();
        if (is_string($moduleName) && trim($moduleName) != '') {
            $moduleName = preg_replace('/(\/|\\\)+/', '/', $moduleName);
            $moduleName = strtolower(basename($moduleName));
            if (isset($this->modules[$moduleName])) {
                if (!in_array($moduleName, $this->calledModules)) {
                    $this->activeModules[$moduleName] = true;
                    $this->calledModules[] = $moduleName;
                    $this->modules[$moduleName]['object']->init($container);
                } else {
                    $this->activeModules[$moduleName] = true;
                }

                return $this->modules[$moduleName]['object'];
            }
        }

        return null;
    }
}
