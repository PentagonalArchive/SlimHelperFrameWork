<?php
namespace Pentagonal\SlimHelper;

use Pimple\Container;

/**
 * Class Module
 * @package Nat
 */
abstract class Module
{
    /**
     * @var string
     */
    protected $module_author;

    /**
     * @var string
     */
    protected $module_author_url;

    /**
     * @var string
     */
    protected $module_name;

    /**
     * @var string
     */
    protected $module_url;

    /**
     * @var string
     */
    protected $module_version;

    /**
     * Module Version check Uri
     *
     * @var string
     */
    protected $module_version_check_uri;

    /**
     * @var string
     */
    protected $module_description;

    /**
     * Module constructor.
     */
    final public function __construct()
    {
        $this->getModuleName();
        $this->getModuleUri();
        $this->getModuleDescription();
        $this->getModuleVersion();
        $this->getModuleVersionCheckUri();
        $this->getModuleAuthor();
        $this->getModuleAuthorUri();
    }

    /**
     * @return string
     */
    final public function getModuleAuthor()
    {
        if (!is_string($this->module_author) || trim($this->module_author_url) == '') {
            $this->module_author = '';
        }

        return trim($this->module_author);
    }

    /**
     * @return string
     */
    final public function getModuleAuthorUri()
    {
        if (!is_string($this->module_author_url) || trim($this->module_author_url) == '') {
            $this->module_author_url = '';
        }
        return trim($this->module_author_url);
    }

    /**
     * @return string
     */
    final public function getModuleName()
    {
        if (!is_string($this->module_name) || trim($this->module_name) == '') {
            $this->module_name = basename(str_replace('\\', '/', get_class($this)));
        }
        return trim($this->module_name);
    }

    /**
     * @return string
     */
    final public function getModuleUri()
    {
        if (!is_string($this->module_url) || trim($this->module_url) == '') {
            $this->module_url = '';
        }
        return trim($this->module_url);
    }

    /**
     * @return string
     */
    final public function getModuleVersion()
    {
        if (!is_string($this->module_version) && !is_numeric($this->module_version)
            || trim($this->module_version) == ''
        ) {
            $this->module_version = 0;
        }
        return is_string($this->module_version) ? trim($this->module_version) : $this->module_version;
    }

    /**
     * @return string
     */
    final public function getModuleVersionCheckUri()
    {
        if (! is_string($this->module_version_check_uri)
            || trim($this->module_version_check_uri) == ''
            || ! filter_var($this->module_version_check_uri, FILTER_VALIDATE_URL)
        ) {
            $this->module_version_check_uri = false;
        }

        return trim($this->module_version_check_uri);
    }

    /**
     * @return string
     */
    final public function getModuleDescription()
    {
        if (!is_string($this->module_description)
            || trim($this->module_description)
        ) {
            $this->module_description = '';
        }
        return trim($this->module_description);
    }

    /**
     * Initialize
     *
     * @return mixed
     */
    abstract public function init();

    /**
     * Magic method End Of execution
     */
    final public function __destruct()
    {
        // prevent to execute code behaviour
    }
}
