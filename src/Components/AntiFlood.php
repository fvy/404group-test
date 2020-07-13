<?php


namespace Fvy\Group404\Components;


use Memcached;

class AntiFlood
{
    const ALLOWED_ATTEMPTS = 5;
    private $shelf;
    private $timeToStore;

    /**
     * AntiFlood constructor.
     * @param $timeToStore
     */
    function __construct($timeToStore = 10)
    {
        $this->shelf = new Memcached();
        $this->shelf->addServer('memcached', 11211);
        $this->timeToStore = $timeToStore;
    }

    /**
     * @param $key
     * @param $url
     */
    function putOnShelf($key, $url)
    {
        $this->shelf->set($key, $url, $this->timeToStore);
    }

    /**
     * @param $url
     * @param $userAgent
     * @param $userIp
     * @return mixed
     */
    function isOverLimit($url, $userAgent, $userIp)
    {
        $key = crc32(join("|", [$url, $userAgent, $userIp]));

        $counter = $this->shelf->get($key);
        $counter++;
        print_r("<pre style='background-color: black; color: limegreen;'>");
        print_r([$key,$counter]);
        print_r("</pre>");
        if ($counter < self::ALLOWED_ATTEMPTS) {
            $this->shelf->set($key, $counter, $this->timeToStore);

            return false;
        }

        return trure;
    }
}