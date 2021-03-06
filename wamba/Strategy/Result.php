<?php

namespace Brainstorm\WambaPHP\Strategy;

use Brainstorm\Question\Variant;
use Brainstorm\Strategy;
use Brainstorm\WambaPHP\Question\Answers;
use Brainstorm\WambaPHP\Question\WithImage;

class Result extends Strategy
{
    /**
     * @param string $html
     * @return bool
     */
    public function check($html)
    {
        return mb_strpos($html, 'Результат php-теста:') !== false;
    }

    /**
     * @param string $html
     * @return string
     */
    public function process($html)
    {
        $score = $this->getScore($html);
        var_dump($score);
        var_dump($this->getQuiz()->getDataStorage()->count());
        var_dump($this->getQuiz()->getCurrentStorage()->count());
        sleep(5);

        $currentStorage = $this->getQuiz()->getCurrentStorage();

        $currentStorage->rewind();
        /** @var WithImage $question */
        $question=$currentStorage->current();
        while ($question !== NULL) {
            $variant = $currentStorage->offsetGet($question);
            /** @var Answers $answers */
            $answers = $this->getQuiz()->getDataStorage()->offsetGet($question);
            $answers->increaseWeight($variant, $this->getScoreWeight($score));

            var_dump($question->getText());
            var_dump($answers);

            $this->getQuiz()->getCurrentStorage()->offsetUnset($question);

            $currentStorage->next();
            $question = $currentStorage->current();
        }

        if ($score > 300)
            $this->makeHtml($score, $this->getResultLink($html));

        return $this->getQuiz()->getTransport()->getTo('https://corp.wamba.com/ru/test', true);
    }

    /**
     * @param string $html
     * @return int
     */
    protected function getScore($html)
    {
        if (preg_match("/<dl class=\"points\"><dt>(\d+)<\/dt>/", $html, $matches))
        {
            return (int)$matches[1];
        }
    }

    /**
     * @param string $html
     * @return string
     */
    protected function getResultLink($html)
    {
        if (preg_match("/<textarea(.*)>(.*)<\/textarea>/iUs", $html, $matches))
        {
            return (string)$matches[2];
        }
    }

    /**
     * @param int $score
     * @return float
     */
    protected function getScoreWeight($score) {
        return ($score - 120) / 2000;
    }

    /**
     * @param int $score
     * @param string $link
     */
    protected function makeHtml($score, $link)
    {
        $result = $link . '<br>';
        $storage = $this->getQuiz()->getDataStorage();

        $storage->rewind();
        /** @var WithImage $question */
        $question=$storage->current();
        while ($question !== NULL) {
            /** @var Answers $answers */
            $answers = $storage->offsetGet($question);

            $result .= '<h2>' . $question->getText() . '</h2>';
            if ($question->getImage())
                $result .= '<img src="' . $question->getImage() . '">';

            $result .= '<div><ul>';
            /** @var Variant $variant */
            foreach ($answers->variants as $variant)
            {
                $result .= '<li>(' . $variant->getWeight() . ") " . $variant->getText() . '</li>>';
            }
            $result .= '</ul></div>';

            $storage->next();
            $question = $storage->current();
        }

        file_put_contents('/tmp/' . $score . uniqid('-') . '.html', '<html><body>' . $result. '</body>');
    }
}