<?php

namespace Brainstorm\Interfaces;

interface Transport
{
    /**
     * @param string $url
     * @param bool $reset
     * @return string
     */
    public function getTo($url, $reset = false);

    /**
     * @param string $url
     * @param array $params
     * @return string
     */
    public function postTo($url, array $params);

}