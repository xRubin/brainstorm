<?php

namespace Brainstorm\Question;

abstract class Simple
{
    /** @var string */
    protected $text;

    /**
     * @param string $html
     */
    abstract public function __construct($html);

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return md5($this->getText());
    }
}
