<?php

namespace Brainstorm\WambaPHP\Question;

use Brainstorm\Question\Simple;

class WithImage extends Simple
{
    /** @var string */
    protected $image;

    /**
     * @param string $html
     */
    public function __construct($html)
    {
        if (preg_match('/<h2>(.*)<\/h2>/Uis', $html, $matches))
        {
            $this->text = $matches[1];
        }

        if (preg_match('/<h2>(.*)<\/h2><img class="source_code01" src="(.*)">/Uis', $html, $matches))
        {
            $this->image = $matches[2];
        }
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return md5($this->getText() . $this->getImage());
    }
}