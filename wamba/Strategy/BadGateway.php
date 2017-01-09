<?php

namespace Brainstorm\WambaPHP\Strategy;

use Brainstorm\Strategy;

class BadGateway extends Strategy
{
    /**
     * @param string $html
     * @return bool
     */
    public function check($html)
    {
        return mb_strpos($html, '502 Bad Gateway') !== false;
    }

    /**
     * @param string $html
     * @return string
     */
    public function process($html)
    {
        var_dump('502 Bad Gateway');
        sleep(180);
        return $this->getQuiz()->getTransport()->getTo('https://corp.wamba.com/ru/test', true);
    }
}