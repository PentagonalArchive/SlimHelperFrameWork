<?php
/**
 * @todo Completion Methods
 */
namespace Pentagonal\SlimHelper\Utilities;

use Pentagonal\SlimHelper\Record\Arrays\Collection;

/**
 * Class CommentDoc
 * @package Pentagonal\SlimHelper\Utilities
 */
class CommentDoc
{
    /**
     * TYPE name to check
     */
    const TYPE_OBJECT   = 1;
    const TYPE_METHOD   = 2;
    const TYPE_FUNCTION = 2;
    /**
     * TAG name to check
     */
    const TAG_ACCESS     = '@access';
    const TAG_API        = '@api';
    const TAG_AUTHOR     = '@author';
    const TAG_CATEGORY   = '@category';
    const TAG_COPYRIGHT  = '@copyright';
    const TAG_DEPRECATED = '@deprecated';
    const TAG_EXAMPLE    = '@example';
    const TAG_FILE_SOURCE= '@filesource';
    const TAG_FINAL      = '@final';
    const TAG_GLOBAL     = '@global';
    const TAG_IGNORE     = '@ignore';
    const TAG_INTERNAL   = '@internal';
    const TAG_LICENSE    = '@license';
    const TAG_LINK       = '@link';
    const TAG_METHOD     = '@method';
    const TAG_PACKAGE    = '@package';
    const TAG_PARAM      = '@param';
    const TAG_PROPERTY   = '@property';
    const TAG_PROPERTY_READ  = '@property-read';
    const TAG_PROPERTY_WRITE = '@property-write';
    const TAG_RETURN     = '@return';
    const TAG_SEE     = '@see';
    const TAG_SINCE   = '@since';
    const TAG_SOURCE  = '@source';
    const TAG_SUBPACKAGE = '@subpackage';
    const TAG_THROWS  = '@throws';
    const TAG_TODO   = '@todo';
    const TAG_USES   = '@uses';
    const TAG_VAR    = '@var';
    const TAG_VERSION= '@version';

    /**
     * @var \Reflector
     */
    protected $reflection;

    /**
     * @var string
     */
    protected $named_string;
    /**
     * @var string
     */
    protected $description;
    /**
     * @var Collection|Collection[]
     */
    protected $tags;

    /**
     * @var string
     */
    protected $commentString = '';

    /**
     * @var int
     */
    protected $type;

    /**
     * @return Collection|Collection[]|null
     */
    public function getAccesses()
    {
        return $this->getTag(self::TAG_ACCESS);
    }

    /**
     * Get Access Collection
     *
     * @return Collection|null
     */
    public function getAccess()
    {
        if (($collection = $this->getAccesses()) !== null) {
            return $collection->first();
        }

        return null;
    }

    /**
     * @return Collection|Collection[]|null
     */
    public function getAPIs()
    {
        return $this->getTag(self::TAG_API);
    }

    /**
     * Get Api Collection
     *
     * @return Collection|null
     */
    public function getAPI()
    {
        if (($collection = $this->getAPIs()) !== null) {
            return $collection->first();
        }

        return null;
    }

    /**
     * @return Collection|Collection[]|null
     */
    public function getAuthors()
    {
        return $this->getTag(self::TAG_AUTHOR);
    }

    /**
     * Get Author Collection
     *
     * @return Collection|null
     */
    public function getAuthor()
    {
        if (($collection = $this->getAuthors()) !== null) {
            return $collection->first();
        }

        return null;
    }

    /**
     * @return Collection|Collection[]|null
     */
    public function getCategories()
    {
        return $this->getTag(self::TAG_CATEGORY);
    }

    /**
     * Get Category Collection
     *
     * @return Collection|null
     */
    public function getCategory()
    {
        if (($collection = $this->getCategories()) !== null) {
            return $collection->first();
        }

        return null;
    }

    /**
     * @return Collection|Collection[]|null
     */
    public function getCopyrights()
    {
        return $this->getTag(self::TAG_COPYRIGHT);
    }

    /**
     * Get Copyright Collection
     *
     * @return Collection|null
     */
    public function getCopyright()
    {
        if (($collection = $this->getCopyrights()) !== null) {
            return $collection->first();
        }

        return null;
    }

    /**
     * CommentDoc constructor.
     * @param mixed $name
     */
    public function __construct($name)
    {
        $this->tags = new Collection();
        $this->reflection = null;
        if (empty($name) || is_string($name) && trim($name) == '') {
            throw new \InvalidArgumentException(
                'Invalid argument 1 to check Comment Doc'
            );
        }

        if (is_object($name) || $name instanceof \Closure) {
            $this->type       = self::TYPE_OBJECT;
            $this->reflection = new \ReflectionObject($name);
            $this->named_string = $this->reflection->getName();
        } elseif (is_array($name)) {
            $counted = count($name);
            if ($counted <> 2) {
                throw new \InvalidArgumentException(
                    sprintf(
                        'Invalid method given. Method commonly use 1 methods %d given.',
                        count($counted)-1
                    )
                );
            }
            $name = array_values($name);
            if (is_object($name[0])) {
                $name[0] = get_class($name[0]);
            }
            $name = implode('::', $name);
        }

        if (is_string($name)) {
            if (strpos($name, '::')) {
                $fullyQualified = explode('::', $name);
                if (count($fullyQualified) <> 2) {
                    throw new \InvalidArgumentException(
                        sprintf(
                            'Invalid method given. Method commonly use 1 methods %d given.',
                            count($fullyQualified)-1
                        )
                    );
                }
                if (trim($fullyQualified[0]) == '') {
                    throw new \InvalidArgumentException(
                        'Invalid class given. Method Could not use empty class.'
                    );
                }

                if (trim($fullyQualified[1]) == '') {
                    throw new \InvalidArgumentException(
                        'Invalid method given. Method Could not use empty method.'
                    );
                }
                if (!class_exists($fullyQualified[0])) {
                    throw new \InvalidArgumentException(
                        sprintf(
                            'Class %s does not exists.',
                            $fullyQualified[0]
                        )
                    );
                }
                if (!method_exists($fullyQualified[0], $fullyQualified[1])) {
                    throw new \InvalidArgumentException(
                        sprintf(
                            'Method %s does not exist in Class of %s.',
                            $fullyQualified[0]
                        )
                    );
                }
                $this->type       = self::TYPE_METHOD;
                $this->reflection = new \ReflectionMethod(
                    $fullyQualified[0],
                    $fullyQualified[1]
                );
                $this->named_string = $this->reflection->class . '::' . $this->reflection->name;
            } else {
                if (class_exists($name)) {
                    $this->type = self::TYPE_OBJECT;
                    $this->reflection = new \ReflectionClass($name);
                    $this->named_string = $this->reflection->getName();
                } elseif (function_exists($name)) {
                    $this->type = self::TYPE_FUNCTION;
                    $this->reflection = new \ReflectionFunction($name);
                    $this->named_string = $this->reflection->getName();
                } else {
                    throw new \InvalidArgumentException(
                        sprintf(
                            'Could not find Class or Function %s exists.',
                            $name
                        )
                    );
                }
            }
        }

        if ($this->reflection) {
            $this->processDocumentCommentCheck();
            return;
        }

        throw new \InvalidArgumentException(
            'Invalid argument given.'
        );
    }

    /**
     * Processing Comments Parse
     */
    protected function processDocumentCommentCheck()
    {
        $this->commentString = $this->reflection->getDocComment();
        if (trim($this->commentString) == '' || strpos($this->commentString, '@') === false) {
            return;
        }
        preg_match(
            '/(?:\s*\*+\s*)([^\@]+)/',
            preg_replace('/^\/?\s*\*/m', '', $this->commentString),
            $match
        );
        $this->description = !empty($match[1]) ? trim($match[1]) : '';
        if ($this->description) {
            $this->description = preg_replace('/\s*\n+\s*/', "\n", $this->description);
        }
        $available_tags = [
            self::TAG_API,
            self::TAG_AUTHOR,
            self::TAG_CATEGORY,
            self::TAG_COPYRIGHT,
            self::TAG_DEPRECATED,
            self::TAG_EXAMPLE,
            self::TAG_FILE_SOURCE,
            self::TAG_FINAL,
            self::TAG_GLOBAL,
            self::TAG_IGNORE,
            self::TAG_INTERNAL,
            self::TAG_LICENSE,
            self::TAG_LINK,
            self::TAG_METHOD,
            self::TAG_PACKAGE,
            self::TAG_PARAM,
            self::TAG_PROPERTY,
            self::TAG_PROPERTY_READ,
            self::TAG_PROPERTY_WRITE,
            self::TAG_RETURN,
            self::TAG_SEE,
            self::TAG_SINCE,
            self::TAG_SOURCE,
            self::TAG_SUBPACKAGE,
            self::TAG_THROWS,
            self::TAG_TODO,
            self::TAG_USES,
            self::TAG_VAR,
            self::TAG_VERSION,
        ];
        $regex = '/\*\s*\@(';
        foreach ($available_tags as $v) {
            $regex .= substr($v, 1) . '|';
        }
        $regex = rtrim($regex, '|');
        $regex .= ')(?:\s+(.+))?/';
        preg_match_all(
            $regex,
            $this->commentString,
            $match,
            PREG_OFFSET_CAPTURE
        );
        foreach ($match[1] as $key => $value) {
            $keyName = '@'. str_replace('_', '-', $value[0]);
            !isset($this->tags[$keyName])
            && $this->tags[$keyName] = new Collection();
            $value = $this->parseMatch($keyName, $match[2][$key][0]);
            if (!empty($value)) {
                $this->tags[$keyName]->unshift(new Collection($value));
            }
        }
    }

    /**
     * Parse Match Comments
     *
     * @param string $keyName
     * @param string $value
     * @return array
     */
    protected function parseMatch($keyName, $value)
    {
        $return = [];
        switch ($keyName) {
            case self::TAG_ACCESS:
                preg_match(
                    '/^(?P<name>(?:(?:private|protect|public|internal)\s*)?(?P<description>.+))?/',
                    $value,
                    $return
                );
                break;
            case self::TAG_AUTHOR:
                preg_match(
                    '/^(?P<name>.+)(?:(?:\s+\<\s*(?P<email>[^\>]*)\s*\>)(?:\s+(?P<description>.+)\s*)?)/',
                    $value,
                    $return
                );
                if (!empty($return['description'])) {
                    if (strpos($return['description'], '@link')) {
                        preg_match(
                            '/^\{?\@link\s+(?P<link>[^\}\s]*)\s*\}?\s*(?P<description>.+)/',
                            $return['description'],
                            $desc
                        );
                        if (isset($desc['description'])) {
                            $return['description'] = $desc['description'];
                        }
                        if (isset($desc['link'])) {
                            $return['link'] = $desc['link'];
                        }
                    }
                } elseif (empty($match) && strpos($value, '@link')) {
                    preg_match(
                        '/^(?P<name>.+)\s*\{?\@link\s+(?P<link>[^\}\s]*)\s*\}?\s*(?P<description>.+)/',
                        $value,
                        $return
                    );
                    if (isset($return['name'])) {
                        $return['name'] = trim(rtrim($return['name'], '{'));
                    }
                }
                if (!empty($return) && !isset($return['email'])) {
                    $return['email'] = '';
                }
                break;
            case self::TAG_FINAL:
            case self::TAG_API:
            case self::TAG_IGNORE:
            case self::TAG_TODO:
                $name = $keyName == self::TAG_TODO || $keyName == self::TAG_API
                    ? 'description'
                    : 'name';
                preg_match('/^(?P<'.$name.'>.+)/', $value, $return);
                if (isset($return[$name])) {
                    $return[$name] = trim($return[$name]);
                }
                if ($keyName == self::TAG_API) {
                    $return['api'] = true;
                } elseif ($keyName == self::TAG_FINAL) {
                    $return['final'] = true;
                }
                break;
            case self::TAG_COPYRIGHT:
                preg_match('/^(?P<name>.+)/', $value, $return);
                if (isset($return['name']) && strpos($return['name'], '@link')) {
                    preg_match(
                        '/^(?P<name>.+)\s*\{?\@link\s+(?P<link>[^\}\s]*)\s*\}?\s*(?P<description>.+)/',
                        $value,
                        $return
                    );
                    if (isset($return['name'])) {
                        $return['name'] = trim(rtrim($return['name'], '{'));
                    }
                }
                break;
            case self::TAG_DEPRECATED:
                preg_match('/^(?P<version>[^\s]*)?(?:\s+(?P<description>.+)?/', $value, $return);
                if (empty($return['description'])) {
                    $return['description'] = '';
                }
                if (!empty($return['version']) && ! preg_match('/[0-9]/', $return['version'])) {
                    $return['description'] .= $return['version'];
                    unset($return['version']);
                }
                $return['is_deprecated'] = true;
                break;
            case self::TAG_CATEGORY:
            case self::TAG_SOURCE:
            case self::TAG_FILE_SOURCE:
            case self::TAG_GLOBAL:
            case self::TAG_PACKAGE:
            case self::TAG_SUBPACKAGE:
            case self::TAG_SINCE:
            case self::TAG_VERSION:
            case self::TAG_LINK:
                $name = $keyName == self::TAG_LINK
                    ? 'link'
                    : 'name';
                preg_match('/^(?P<'.$name.'>[^\s]*)(?:\s+(?P<description>.+))?/', $value, $return);
                if (!empty($return)) {
                    $return['description'] = isset($return['description'])
                        ? $return['description']
                        : '';
                }
                break;
            case self::TAG_EXAMPLE:
                preg_match('/^(?P<example>(?:[^\s]*|\"[^\"]*)(?:\s+(?P<description>.+))?/', $value, $return);
                if (!empty($return) && empty($return['description'])) {
                    $return['description'] = '';
                }
                break;
            case self::TAG_LICENSE:
                preg_match(
                    '#^(?P<name>[^\s]*)
                        (?:
                            \s+
                            (?P<link>(\{?\@link\s*)?
                                (?:http?\:\/\/.+[^\s]*|\<\s*.+\s*\>|.+\s*\})
                            )
                            |\s+
                            (?P<description>.+)
                        )?
                    #x',
                    $value,
                    $return
                );
                if (!empty($return)) {
                    if (isset($return['link'])) {
                        if (strpos($return['link'], '@link') !== false) {
                            $return['link'] = trim(ltrim($return['link'], '@link'));
                        }
                        $return['link'] = ltrim(rtrim(trim($return['link'], '}'), '>'), '<');
                    }
                    $return['description'] = isset($return['description'])
                        ? $return['description']
                        : '';
                }
                break;
            case self::TAG_METHOD:
                $value = preg_replace('/\s+([\|\[\||\)\(])/', '$1', $value);
                preg_match(
                    '#^(?P<is_static>static\s+)?
                        (?:
                            (?P<return>.[^\(\s]+)\s+)?
                            (?:
                                (?P<name>(?P<method>[a-zA-Z\_\s]+)
                                \((?P<arguments>[^\)]*[^\)])?\)
                            )
                        )
                        (?:[\;]+)
                        ?(?P<description>.+)?
                    #x',
                    $value,
                    $return
                );
                $return['is_static'] = isset($return['is_static']) && trim($return['is_static']) != '';
                if (isset($return['return'])) {
                    $return['return'] = explode('|', $return['return']);
                } else {
                    $return['return'] = [];
                }
                $args = isset($return['arguments'])
                    ? $return['arguments']
                    : '';
                $return['arguments'] = [];
                foreach (explode(',', $args) as $value) {
                    $value = trim($value);
                    if ($value != '') {
                        preg_match(
                            '#^(?:
                                    (?P<type>[^\s\$]*)\s+)?
                                    (?P<parameter>[^\s\=]*)
                                    (?:\s*\=(?P<default_value>.+)
                                )?
                            #x',
                            $value,
                            $match
                        );
                        if (!empty($match)) {
                            foreach ($match as $key => $v) {
                                if (is_numeric($key)) {
                                    unset($match[$key]);
                                }
                            }
                            if (isset($match['default_value'])) {
                                $default = trim($match['default_value']);
                                $match['default_value'] = [];
                                if ($default == '' || in_array(substr($default, 0, 1), ['"', "'"])) {
                                    $match['default_value']['type'] = 'string';
                                    $default = substr($default, 0, 1) == '"'
                                        ? trim($default, '"')
                                        : trim($default, "'");
                                } elseif (substr($default, 0, 1) == '[' && substr($default, -1)) {
                                    $match['default_value']['type'] = 'array';
                                } elseif (is_numeric($default)) {
                                    $match['default_value']['type'] = strpos($default, '.') !== false
                                        ? 'float'
                                        : 'integer';
                                } else {
                                    $lower = strtolower($default);
                                    if (strpos($lower, 'array(')) {
                                        $match['default_value']['type'] = 'array';
                                    } else {
                                        switch ($lower) {
                                            case 'true':
                                            case 'false':
                                                $match['default_value']['type'] = 'boolean';
                                                break;
                                            case 'null':
                                                $match['default_value']['type'] = 'null';
                                                break;
                                            default:
                                                $match['default_value']['type'] = isset($match['type'])
                                                    ? $match['type']
                                                    : '';
                                        }
                                    }
                                }
                                $match['default_value']['value'] = $default;
                            }
                        } else {
                            continue;
                        }
                        if (isset($match['type'])) {
                            $match['type'] = explode('|', $match['type']);
                        }
                        $return['arguments'][] = $match;
                    }
                }
                $return['description'] = isset($return['description'])
                    ? $return['description']
                    : '';
                break;
            case self::TAG_SEE:
            case self::TAG_THROWS:
            case self::TAG_USES:
                preg_match('/^(?P<name>[^\s]+)(?P<description>.+)?/', $value, $return);
                if (!empty($return['description']) && strpos($return['description'], '@link')) {
                    preg_match(
                        '/^\{?\@link\s+(?P<link>[^\}\s]*)\s*\}?\s*(?P<description>.+)/',
                        $return['description'],
                        $desc
                    );
                    if (isset($desc['description'])) {
                        $return['description'] = $desc['description'];
                    }
                    if (isset($desc['link'])) {
                        $return['link'] = $desc['link'];
                    }
                }

                $return['description'] = isset($return['description'])
                    ? $return['description']
                    : '';
                break;
            case self::TAG_PROPERTY:
            case self::TAG_PROPERTY_READ:
            case self::TAG_PROPERTY_WRITE:
            case self::TAG_PARAM:
            case self::TAG_RETURN:
                $value = preg_replace('/\s+([\|\[\||\)\(])/', '$1', $value);
                preg_match(
                    '#
                        ^(?P<type>[^\$]+)?
                        (?P<parameter>\$[a-zA-Z\_][a-z0-9A-Z\_]+)
                        (?:\s+(?P<description>.+))?
                    #x',
                    $value,
                    $return
                );
                if (!empty($return)) {
                    if (!empty($return['type'])) {
                        if (trim($return['type']) == '') {
                            $return['type'] = [];
                        } else {
                            $return['type'] = str_replace([' ', "\r"], '', $return['type']);
                            $return['type'] = explode('|', $return['type']);
                        }
                    }
                }
                break;
        }
        foreach ($return as $key => $v) {
            if (is_numeric($key)) {
                unset($return[$key]);
            }
        }
        return $return;
    }

    /**
     * Get Fully Qualified Given Reflection Name
     *
     * @return string
     */
    public function getNamedString()
    {
        return $this->named_string;
    }

    /**
     * Get Description of Reflection
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get Document Comment
     *
     * @return string
     */
    public function getCommentString()
    {
        return $this->commentString;
    }

    /**
     * Getting Reflection instance
     *
     * @return \Reflector
     */
    public function getReflection()
    {
        return $this->reflection;
    }

    /**
     * Get Current Type
     *
     * @return int
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Get Tags Collection
     *
     * @return Collection|Collection[]
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Get Collection Tags
     *
     * @param string $name
     * @return Collection|Collection[]|null
     */
    public function getTag($name)
    {
        if (!is_string($name)) {
            return null;
        }
        $name = '@'.trim(strtolower($name), '@');
        if ($this->tags->has($name)) {
            return $this->tags->get($name);
        }
        return null;
    }
}
