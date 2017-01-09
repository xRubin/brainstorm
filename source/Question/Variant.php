<?php

namespace Brainstorm\Question;

class Variant
{
    /** @var string */
    protected $text;
    /** @var float */
    protected $weight;

    /**
     * @param string $text
     * @param float $weight
     */
    public function __construct($text, $weight = Answers::DEFAULT_WEIGHT)
    {
        $this->text = $text;
        $this->weight = $weight;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param float $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @param float $weight
     */
    public function addWeight($weight)
    {
        $this->weight += $weight;
    }
}
