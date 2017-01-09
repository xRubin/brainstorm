<?php
require_once __DIR__ . '/vendor/autoload.php';

use Brainstorm\WambaPHP\Strategy;

(new \Brainstorm\Quiz())
    ->setTransport(new \Brainstorm\Transport\CUrl())
    ->setDataStorage(new \Brainstorm\Storage\Memory())
    ->setCurrentStorage(new \Brainstorm\Storage\Memory())
    ->addStrategy(Strategy\Init::class)
    ->addStrategy(Strategy\Question::class)
    ->addStrategy(Strategy\Result::class)
    ->addStrategy(Strategy\BadGateway::class)
    ->run('https://corp.wamba.com/ru/test/');
