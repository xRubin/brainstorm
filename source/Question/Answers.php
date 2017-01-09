<?php

namespace Brainstorm\Question;

abstract class Answers
{
    const DEFAULT_WEIGHT = 1.0;

    /** @var array Variant[] */
    public $variants = [];

    /**
     * @param string $html
     */
    abstract public function __construct($html);

    /**
     * @return string
     * @throws \ErrorException
     */
    public function getRandomVariantIndex()
    {
        $rand = mt_rand(1, (int)1000 * $this->getWeightSum() - 1);

        foreach ($this->variants as $key => $variant) {
            /** @var Variant $variant */
            $rand -= 1000 * $variant->getWeight();
            if ($rand <= 0) {
                return $key;
            }
        }

        throw new \ErrorException('No variants');
    }

    /**
     * @param string $index
     * @param float $deltaWeight
     */
    public function increaseWeight($index, $deltaWeight)
    {
        foreach ($this->variants as $key => $variant) {
            /** @var Variant $variant */
            $variant->addWeight($index === $key ? $deltaWeight : -$deltaWeight / (count($this->variants) - 1));

            if ($variant->getWeight() < 0)
                $variant->setWeight(0);
        }
    }

    /**
     * @return float
     */
    protected function getWeightSum()
    {
        return array_sum(array_map(function (Variant $variant) {
            return $variant->getWeight();
        }, $this->variants));
    }
}

