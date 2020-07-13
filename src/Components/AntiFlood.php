<?php


namespace Fvy\Group404\Components;


use Memcached;

/**
 * Class AntiFlood
 * @package Fvy\Group404\Components
 */
class AntiFlood
{
    const ALLOWED_ATTEMPTS = 5;

    private $memcached;
    private $timeToStore; // in seconds
    /**
     * @var mixed
     */
    private $counter;

    /**
     * AntiFlood constructor.
     * @param $timeToStore
     */
    function __construct($timeToStore = 10)
    {
        $this->memcached = new Memcached();
        $this->memcached->addServer('memcached', 11211);
        $this->timeToStore = $timeToStore;
        $this->counter = 0;
    }

    public function isFlood(...$params)
    {
        $this->counter = (int) $this->memcached->get(self::makeHash($params));
        if ($this->counter > self::ALLOWED_ATTEMPTS) {
            return true;
        }

        return false;
    }

    public function increaseCounter(...$params)
    {
        $this->memcached->set(self::makeHash($params), ++$this->counter, $this->timeToStore);
    }

    private function makeHash($params)
    {
        return md5(join("|", $params));
    }
}