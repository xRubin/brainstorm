<?php

namespace Brainstorm\Transport;

use Brainstorm\Interfaces\Transport;

class CUrl implements Transport
{
    protected $curl;
    protected $cookieFile;

    /**
     * @void
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * @void
     */
    public function init()
    {
        $this->curl = curl_init();

        @unlink($this->cookieFile);
        $this->cookieFile = uniqid('/tmp/');

        curl_setopt($this->curl, CURLOPT_COOKIEFILE, $this->cookieFile);
        curl_setopt($this->curl, CURLOPT_COOKIEJAR, $this->cookieFile);
    }

    /**
     * @void
     */
    public function __destruct()
    {
        @unlink($this->cookieFile);
    }

    /**
     * @void
     */
    public function __clone()
    {
        $this->init();
    }

    /**
     * @param string $url
     * @param bool $reset
     * @return string
     */
    public function getTo($url, $reset = false)
    {
        if ($reset) {
            $this->init();
        }

        curl_setopt($this->curl, CURLOPT_POST, false);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_URL, $url);

        return curl_exec($this->curl);
    }

    /**
     * @param string $url
     * @param array $params
     * @return string
     */
    public function postTo($url, array $params)
    {
        curl_setopt($this->curl, CURLOPT_POST, true);
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($this->curl, CURLOPT_URL, $url);

        curl_setopt($this->curl, CURLOPT_POSTFIELDS, http_build_query($params, '', '&'));

        return curl_exec($this->curl);
    }
}