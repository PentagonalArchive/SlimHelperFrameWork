<?php
namespace Pentagonal\SlimHelper;

use Gettext\Translations;
use Gettext\Translator as GetTextTranslator;

/**
 * Class Translator
 * @package Pentagonal\SlimHelper
 */
class Translator
{
    const DEFAULT_DOMAIN = 'default';

    /**
     * @var GetTextTranslator
     */
    protected $translator;

    /**
     * @var Translations
     */
    protected $translations;

    /**
     * Translator constructor.
     * @param Translations|null $translations
     */
    public function __construct(Translations $translations = null)
    {
        $this->translator = new GetTextTranslator();
        if (!$translations) {
            $translations = new Translations();
            $translations->setDomain(static::DEFAULT_DOMAIN);
        }
        $this->translations =& $translations;
        $this->load($translations)
            ->setDomain($translations->getDomain());
    }

    /**
     * @return Translations
     */
    public function getTranslations()
    {
        return $this->translations;
    }

    /**
     * Loads translation from a Translations instance, a file on an array.
     *
     * @param Translations|string|array $translations
     *
     * @return $this
     */
    public function load($translations)
    {
        $this->translator->loadTranslations($translations);
        return $this;
    }

    /**
     * Set the default domain.
     *
     * @param string $domain
     *
     * @return $this
     */
    public function setDomain($domain)
    {
        $this->translator->defaultDomain($domain);
        return $this;
    }

    /**
     * No Operation, marks the string for translation but returns it unchanged.
     *
     * @param string $original
     *
     * @return string
     */
    public function noTrans($original)
    {
        return $this->translator->noop($original);
    }

    /**
     * Gets a translation using the original string.
     *
     * @param string $original
     *
     * @return string
     */
    public function trans($original)
    {
        if (!$original || !is_string($original)) {
            return $original;
        }

        return $this->translator->gettext($original);
    }

    /**
     * Gets a translation checking the plural form.
     *
     * @param string $original
     * @param string $plural
     * @param string $value
     * @return string
     */
    public function nTrans($original, $plural, $value)
    {
        return $this->translator->ngettext($original, $plural, $value);
    }

    /**
     * Gets a translation checking the domain and the plural form.
     *
     * @param string $domain
     * @param string $original
     * @param string $plural
     * @param string $value
     * @return string
     */
    public function dnTrans($domain, $original, $plural, $value)
    {
        return $this->translator->dngettext($domain, $original, $plural, $value);
    }

    /**
     * Gets a translation checking the context and the plural form.
     *
     * @param string $context
     * @param string $original
     * @param string $plural
     * @param string $value
     *
     * @return string
     */
    public function npTrans($context, $original, $plural, $value)
    {
        return $this->translator->npgettext($context, $original, $plural, $value);
    }

    /**
     * Gets a translation checking the context.
     *
     * @param string $context
     * @param string $original
     *
     * @return string
     */
    public function pTrans($context, $original)
    {
        return $this->translator->pgettext($context, $original);
    }

    /**
     * Gets a translation checking the domain.
     *
     * @param string $domain
     * @param string $original
     *
     * @return string
     */
    public function dTrans($domain, $original)
    {
        return $this->translator->dgettext($domain, $original);
    }

    /**
     * Gets a translation checking the domain and context.
     *
     * @param string $domain
     * @param string $context
     * @param string $original
     *
     * @return string
     */
    public function dpTrans($domain, $context, $original)
    {
        return $this->translator->dpgettext($domain, $context, $original);
    }

    /**
     * Gets a translation checking the domain, the context and the plural form.
     *
     * @param string $domain
     * @param string $context
     * @param string $original
     * @param string $plural
     * @param string $value
     * @return string
     */
    public function dnpTrans($domain, $context, $original, $plural, $value)
    {
        return $this->translator->dnpgettext($domain, $context, $original, $plural, $value);
    }

    /**
     * @param string $original
     * @return string
     */
    public function __invoke($original)
    {
        return $this->trans($original);
    }
}
