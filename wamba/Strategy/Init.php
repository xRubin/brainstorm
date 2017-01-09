<?php

namespace Brainstorm\WambaPHP\Strategy;

use Brainstorm\Strategy;

class Init extends Strategy
{
    /**
     * @param string $html
     * @return bool
     */
    public function check($html)
    {
        return mb_strpos($html, 'Международный сервис знакомств и общения подготовил небольшое испытание для всех PHP разработчиков Рунета.') !== false;
    }

    /**
     * @param string $html
     * @return string
     */
    public function process($html)
    {
        return $this->getQuiz()->getTransport()->getTo('https://corp.wamba.com/ru/test/test/');
    }
}