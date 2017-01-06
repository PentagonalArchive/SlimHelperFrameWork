<?php
namespace Pentagonal\SlimHelper;

use Aura\Session\CsrfToken;
use Aura\Session\Segment;
use Aura\Session\SessionFactory;

/**
 * Class Session
 * @package Nat
 *
 * @see Segment::get()
 * @method mixed get(string $key, mixed $alt = null)
 *
 * @see Segment::set()
 * @method void  set(string $key, mixed $val)
 *
 * @see Segment::clear()
 * @method void  clear()
 *
 * @see Segment::setFlash()
 * @method void  setFlash(string $key, mixed $val)
 *
 * @see Segment::getFlash()
 * @method mixed getFlash(string $key, mixed $alt = null)
 *
 * @see Segment::clearFlash()
 * @method void  clearFlash()
 *
 * @see Segment::getFlashNext()
 * @method mixed getFlashNext(string $key, mixed $alt = null)
 *
 * @see Segment::setFlashNow()
 * @method void  setFlashNow(string $key, mixed $val)
 *
 * @see Segment::clearFlashNow()
 * @method void  clearFlashNow()
 *
 * @see Segment::keepFlash()
 * @method void  keepFlash()
 */
class Session implements \ArrayAccess
{
    /**
     * @var \Aura\Session\Session
     */
    protected $session;

    /**
     * @var string
     */
    protected $segmentName = '';

    /**
     * Session constructor.
     * @param \Aura\Session\Session $session
     */
    public function __construct(\Aura\Session\Session $session = null)
    {
        if (is_null($session)) {
            $session = (new SessionFactory)->newInstance($_COOKIE);
        }
        $this->session =& $session;
        $this->setSegmentName(__CLASS__);
    }

    /**
     * This Method also change Segments
     *
     * @param string $name
     */
    public function setSegmentName($name)
    {
        if (!is_string($name)) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Session Segment Name must be as a string %s given',
                    gettype($name)
                ),
                E_USER_ERROR
            );
        }

        $this->segmentName = $name;
    }

    /**
     * Create Instance Session
     *
     * @param string|null                $name
     * @param \Aura\Session\Session|null $session
     * @return Session
     * @throws \InvalidArgumentException
     */
    public static function &createWithName($name = null, \Aura\Session\Session $session = null)
    {
        $session = ! is_null($session) ? new static : new static($session);
        if (is_null($name)) {
            return $session;
        }

        $session->setSegmentName($name);
        return $session;
    }

    /**
     * Get object Session
     *
     * @return \Aura\Session\Session
     */
    public function &getSession()
    {
        return $this->session;
    }

    /**
     * Get the Session segment
     *
     * @return Segment
     */
    public function getSegment()
    {
        $segment = $this->getSession()->getSegment($this->getSegmentName());
        return $segment;
    }

    /**
     * Get session stored Name Value
     *
     * @return string
     */
    public function getSegmentName()
    {
        return $this->segmentName;
    }

    /**
     * Get C.S.R.F from Aura session
     *
     * @return CsrfToken
     */
    public function getCsrfToken()
    {
        return $this->getSession()->getCsrfToken();
    }

    /**
     * Getting C.S.R.F token values
     *
     * @return string
     */
    public function getCsrfTokenValue()
    {
        return $this->getCsrfToken()->getValue();
    }

    /**
     * validate token set
     *
     * @param string $value
     * @return bool
     */
    public function validateToken($value)
    {
        if (!is_string($value)) {
            return false;
        }

        return $this->getCsrfToken()->isValid($value);
    }

    /**
     * @param string $keyName
     * @param mixed $value
     */
    public function flash($keyName, $value)
    {
        $this->setFlash($keyName, $value);
    }

    /**
     * @param string $keyName
     * @param mixed $value
     */
    public function flashNow($keyName, $value)
    {
        $this->setFlashNow($keyName, $value);
    }

    /**
     * Check whether Session is exists or not on segment
     *
     * @param string $keyName
     * @return bool
     */
    public function exist($keyName)
    {
        # double check
        return
            $this->get($keyName, true) !== true
            && $this->get($keyName, false) !== false;
    }

    /**
     * Remove Session from segment
     *
     * @param string $keyName
     */
    public function remove($keyName)
    {
        if ($this->exist($keyName)) {
            unset($_SESSION[$this->getSegmentName()][$keyName]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function offsetExists($offset)
    {
        return $this->exist($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetGet($offset)
    {
        return $this->get($offset);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetSet($offset, $value)
    {
        $this->set($offset, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * Magic Method Call for BackWards Compatibility
     *
     * @uses   Segment
     * @param  string $name
     * @param  array  $arguments
     * @return mixed
     */
    public function __call($name, array $arguments)
    {
        $return = call_user_func_array(
            [$this->getSegment(), $name],
            $arguments
        );
        return $return;
    }
}
