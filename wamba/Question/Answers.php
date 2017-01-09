<?php

namespace Brainstorm\WambaPHP\Question;

use Brainstorm\Question\Variant;

class Answers extends \Brainstorm\Question\Answers
{
    /**
     * @param string $html
     */
    public function __construct($html)
    {
        if ($i = preg_match_all("/<input type=\"checkbox\" id=\"(.*)\" name=\"(.*)\" value=\"1\" \/>(.*)<\/label>/Uis", $html, $matches)) {
            for ($index = 0; $index < $i; $index++)
                $this->variants[$matches[2][$index]] = new Variant(trim($matches[3][$index]));
        }
    }

    public function __debugInfo() {
        return array_map(function (Variant $variant) {
            return $variant->getWeight() . "\t" . $variant->getText();
        }, $this->variants);
    }
}
