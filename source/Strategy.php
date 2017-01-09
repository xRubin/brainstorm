<?php

namespace Brainstorm;

abstract class Strategy
{
    /** @var Quiz */
    protected $quiz;

    /**
     * @param Quiz $quiz
     */
    public function __construct(Quiz $quiz)
    {
        $this->quiz = $quiz;
    }

    /**
     * @return Quiz
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * @param string $html
     * @return bool
     */
    abstract public function check($html);

    /**
     * @param string $html
     * @return string
     */
    abstract public function process($html);
}