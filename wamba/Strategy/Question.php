<?php

namespace Brainstorm\WambaPHP\Strategy;

use Brainstorm\Strategy;
use Brainstorm\WambaPHP\Question\Answers;
use Brainstorm\WambaPHP\Question\WithImage;

class Question extends Strategy
{
    /**
     * @param string $html
     * @return bool
     */
    public function check($html)
    {
        return mb_strpos($html, 'Php-тест для программистов') !== false
            && mb_strpos($html, 'Результат php-теста:') === false;
    }

    /**
     * @param string $html
     * @return string
     */
    public function process($html)
    {
        $question = new WithImage($html);
        $answers = new Answers($html);

        if (!$this->getQuiz()->getDataStorage()->offsetExists($question)) {
            $this->getQuiz()->getDataStorage()->offsetSet($question, $answers);
        } else {
            $answers = $this->getQuiz()->getDataStorage()->offsetGet($question);
        }

        $answer = $answers->getRandomVariantIndex();
        $this->getQuiz()->getCurrentStorage()->offsetSet($question, $answer);

        return $this->getQuiz()->getTransport()->postTo('https://corp.wamba.com/ru/test/test/', [
            'answer' => 'do',
            $answer => 1,
        ]);
    }
}