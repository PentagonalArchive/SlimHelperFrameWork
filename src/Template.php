<?php
/**
 * Immutable Template Renderer
 *
 * @author nawa <nawa@yahoo.com>
 */
namespace Pentagonal\SlimHelper;

use Interop\Container\ContainerInterface;
use Pentagonal\SlimHelper;
use Pentagonal\SlimHelper\Exception\TemplateErrorException;
use Pentagonal\SlimHelper\Record\Arrays\Collection;
use Pentagonal\SlimHelper\Utilities\Sanitation;
use Psr\Http\Message\ResponseInterface;

/**
 * Class Template
 * @package Pentagonal\Demonite\Worker\Service
 */
class Template implements \ArrayAccess
{
    /**
     * @const string
     */
    const EXT_TEMPLATE = '.php';

    /**
     * @var string
     */
    protected $templateDirectory;

    /**
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var Collection
     */
    protected $attributes;

    /**
     * @var Collection[]
     */
    protected $listTemplates = [];

    /**
     * @var array
     */
    protected $listLoadedTemplates = [];

    /**
     * @var bool
     */
    protected $inLoad = false;

    /**
     * @var string
     */
    protected $currentDirectoryTemplate;

    /**
     * @var Collection
     */
    protected $logs = [];

    /**
     * Template constructor.
     * @param                    $templateDir
     * @param ContainerInterface $container
     */
    public function __construct($templateDir, ContainerInterface $container)
    {
        $this->templateDirectory = $templateDir;
        $this->container = $container;
        $this->attributes = new Collection();
        if (!is_string($this->templateDirectory)) {
            throw new \InvalidArgumentException(
                'Invalid Template Directory defined',
                E_USER_ERROR
            );
        }
    }

    /**
     * @return array
     */
    public function getLoadedTemplate()
    {
        return $this->listLoadedTemplates;
    }

    /**
     * @return array
     */
    public function getListTemplate()
    {
        return $this->listTemplates;
    }

    /**
     * @return bool
     */
    public function templateHasLoaded()
    {
        return !empty($this->listLoadedTemplates);
    }

    /**
     * @return bool
     */
    public function isEmptyListTemplate()
    {
        return empty($this->listTemplates);
    }

    /**
     * @param string $directory
     * @return Template
     */
    public function withNew($directory)
    {
        $new = new static($directory, $this->container);
        $new->attributes = $this->attributes;
        $new->currentDirectoryTemplate = $this->currentDirectoryTemplate;
        return $new;
    }

    /**
     * @param string $template
     * @return string
     * @throws TemplateErrorException
     */
    protected function sanitizeFileName($template)
    {
        if (!is_string($template)) {
            throw new \InvalidArgumentException(
                'Template Name Must Be as String',
                E_USER_ERROR
            );
        }

        $template = substr($template, -strlen(self::EXT_TEMPLATE)) == self::EXT_TEMPLATE
            ? $template
            : $template . self::EXT_TEMPLATE;
        $oldTemplate = $template;
        $template = $this->getTemplateDirectory() .'/' . $template;
        if (!is_file($template)) {
            if (is_file($this->getTemplateDirectory() . '/' . ucwords($oldTemplate, " \t\r\n\f\v-"))) {
                $this->logs[] = sprintf(
                    'Template %s load use different name uppercase words at : %s',
                    $oldTemplate,
                    ucwords($oldTemplate, " \t\r\n\f\v-")
                );
                $template = $this->currentDirectoryTemplate . '/' . ucwords($oldTemplate, " \t\r\n\f\v-");
            } elseif ($this->currentDirectoryTemplate) {
                if (is_file($this->currentDirectoryTemplate . '/' . $oldTemplate)) {
                    $this->logs[] = sprintf(
                        'Template %s load use different directory at : %s',
                        $oldTemplate,
                        $this->currentDirectoryTemplate
                    );
                    $template = $this->currentDirectoryTemplate . '/' . $oldTemplate;
                } elseif (is_file($this->currentDirectoryTemplate . '/' . ucwords($oldTemplate, " \t\r\n\f\v-"))) {
                    $this->logs[] = sprintf(
                        'Template %s load use different name uppercase words at : %s',
                        $oldTemplate,
                        ucwords($oldTemplate, " \t\r\n\f\v-")
                    );
                    $template = $this->currentDirectoryTemplate . '/' . ucwords($oldTemplate, " \t\r\n\f\v-");
                }
            }
        }

        if (! is_file($template)) {
            throw new TemplateErrorException(
                sprintf(
                    'Template %s has not found',
                    $template
                ),
                E_USER_ERROR
            );
        }

        return realpath($template);
    }

    /**
     * @param string $template
     * @param array  $attr
     */
    public function queue($template, array $attr = [])
    {
        /**
         * please does not render in load of template render process
         * it will be no affected
         * @see partial() , to load partial
         */
        if ($this->inLoad) {
            return;
        }
        $template = $this->sanitizeFileName($template);
        $this->listTemplates[$template] = new Collection($attr);
    }

    /**
     * @param string $template
     * @param array $attr
     * @throws \Exception
     * @throws \Throwable
     */
    public function partial($template, array $attr = [])
    {
        /**
         * please does not render outside load of template render process
         * it will be no affected
         * @see queue() , to load partial on outside template
         */
        if (!$this->inLoad) {
            return;
        }

        /**
         * IN HERE GLOBAL ATTRIBUTES DOES NOT ALLOW TO CLEAR
         */
        $oldTemplate = $template;
        $originalAttributes  = $this->attributes;
        $listTemplate        = $this->listTemplates;
        $listLoadedTemplate  = $this->listLoadedTemplates;
        $templateDirectory   = $this->templateDirectory;
        try {
            // Get Template
            $template = $this->sanitizeFileName($template);
            $logs = $this->logs;
            if (is_string($oldTemplate) && in_array($template, $listLoadedTemplate)) {
                throw new TemplateErrorException(
                    sprintf(
                        'Template %s has been loaded before',
                        $oldTemplate
                    ),
                    E_COMPILE_ERROR
                );
            }

            /**
             * Add Meta Data array to prevent Template Looping
             */
            $this->listLoadedTemplates   = $listLoadedTemplate;
            $this->listLoadedTemplates[] = $template;
            $listLoadedTemplate = $this->listLoadedTemplates;

            $this->attributes->replace($attr);
            $this->protectedIncludeScope($template, $this->attributes->all());
            /**
             * Prevent Looping
             *
             * Fallback To Default
             */
            $this->listLoadedTemplates  = $listLoadedTemplate;
            $this->logs                 = $logs;
            $this->attributes           = $originalAttributes;
            $this->templateDirectory    = $templateDirectory;
            $this->listTemplates        = $listTemplate;
        } catch (TemplateErrorException $e) {
            $this->logs[] = $e->getMessage();
        } catch (\Throwable $e) { // PHP 7+
            throw $e;
        } catch (\Exception $e) { // PHP < 7
            throw $e;
        }
    }

    /**
     * @param array $attr
     */
    public function setAttributes(array $attr)
    {
        $this->attributes->replace($attr);
    }

    /**
     * @param mixed $keyName
     * @param mixed $value
     */
    public function setAttribute($keyName, $value)
    {
        $this->attributes->set($keyName, $value);
    }

    /**
     * Get Attribute
     *
     * @param mixed $keyName
     * @param mixed $default
     * @return mixed
     */
    public function getAttribute($keyName, $default = null)
    {
        return $this->attributes->get($keyName, $default);
    }

    /**
     * @return Collection
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes->all();
    }

    /**
     * CLear Attributes
     */
    public function clearAttributes()
    {
        $this->attributes->clear();
    }

    /**
     * @param array $attr
     */
    public function replaceAttributes(array $attr)
    {
        $this->clearAttributes();
        $this->attributes->replace($attr);
    }

    /**
     * @param string $template
     * @param array $attr
     * @param ResponseInterface|null $response
     * @throws \Exception
     * @throws \Throwable
     * @return  ResponseInterface
     */
    protected function process($template = null, array $attr = [], $response = null)
    {
        if ($template) {
            // render partial
            $this->queue($template, $attr);
        }
        if (empty($this->listTemplates)) {
            throw new TemplateErrorException(
                'No templates to be render',
                E_ERROR
            );
        }
        if (is_null($response)) {
            $response = $this->container->get('response');
        }

        $this->response = $response;

        /**
         * IN HERE GLOBAL ATTRIBUTES DOES NOT ALLOW TO CLEAR
         */
        $originalAttributes     = $this->attributes;
        $listTemplatesQueue     = $this->listTemplates;
        // emptying
        $this->listTemplates    = [];
        $templateDirectory      = $this->templateDirectory;
        $listLoadedTemplate     = $this->listLoadedTemplates;
        $logs = $this->logs;
        try {
            ob_start();
            foreach ($listTemplatesQueue as $key => $collectorSerializable) {
                $this->attributes = $originalAttributes;
                $this->templateDirectory = $templateDirectory;
                $this->attributes->replace($collectorSerializable->all());

                /**
                 * Add Meta Data array to prevent Template Looping
                 */
                $this->listLoadedTemplates   = $listLoadedTemplate;
                $this->listLoadedTemplates[] = $key;
                $listLoadedTemplate = $this->listLoadedTemplates;


                // set In Load
                $this->inLoad = true;
                $this->currentDirectoryTemplate = dirname($key);
                $currentDirectory               = $this->currentDirectoryTemplate;
                $this->protectedIncludeScope($key, $this->attributes->all());
                $this->inLoad = false;
                $this->currentDirectoryTemplate = $currentDirectory;
                /**
                 * Fallback to default
                 */
                $this->logs                   = $logs;
                $this->listLoadedTemplates    = $listLoadedTemplate;
                $this->attributes             = $originalAttributes;
                $this->templateDirectory      = $templateDirectory;
            }
            $response
                ->getBody()
                ->write(
                    Sanitation::multiByteEntities(ob_get_clean(), false)
                );
            return $response;
        } catch (\Throwable $e) { // PHP 7+
            ob_end_clean();
            throw $e;
        } catch (\Exception $e) { // PHP < 7
            ob_end_clean();
            throw $e;
        }
    }

    /**
     * @param-read string $param
     *
     * @return ResponseInterface
     */
    public function render()
    {
        if (func_num_args() < 1) {
            return $this->process();
        }
        $template = func_get_arg(0);
        $extra_data = [];
        $response = null;
        if (func_num_args() > 1) {
            $extra_data = func_get_arg(1);
        }
        if (func_num_args() > 2) {
            $response = func_get_arg(2);
        }
        $arguments = [
            $template = is_string($template) ? $template : (
                is_string($extra_data) ? $extra_data : (
                    is_string($response) ? $response : null
                )
            ),
            is_array($template) ? $template : (
                is_array($extra_data) ? $extra_data : (
                    is_array($response) ? $response :
                        (
                            is_array($response) ? $response : []
                        )
                )
            ),
            $template instanceof ResponseInterface ? $template : (
                $extra_data instanceof ResponseInterface ? $extra_data : (
                    $response instanceof ResponseInterface
                        ? $response
                        : $this->container->get('response')
                )
            ),
        ];

        $template   =& $arguments[0];
        $extra_data =& $arguments[1];
        $response   =& $arguments[2];
        unset($arguments);
        return $this->process($template, $extra_data, $response);
    }

    /**
     * Protect Include
     */
    protected function protectedIncludeScope()
    {
        if (is_string(func_get_arg(0)) && is_file(func_get_arg(0))) {
            $argument = [];
            if (is_array(func_get_arg(1))) {
                $argument = func_get_arg(1);
            }

            $fn = function () {
                // extract(func_get_arg(1));
                /** @noinspection PhpIncludeInspection */
                include func_get_arg(0);
            };
            $fn = $fn->bindTo($this);
            $fn(func_get_arg(0), $argument);
        }
    }

    /**
     * @return string
     * @throws \ErrorException
     */
    public function getTemplateDirectory()
    {
        if (!is_dir($this->templateDirectory)) {
            throw new \ErrorException(
                sprintf(
                    'Template directory %s does not exists',
                    $this->templateDirectory
                ),
                E_ERROR
            );
        }

        return $this->templateDirectory;
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->attributes->has($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->getAttribute($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        return $this->setAttribute($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->attributes->remove($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    /**
     * {@inheritdoc}
     */
    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function __unset($name)
    {
        $this->offsetUnset($name);
    }
}
