<?php

namespace Brainstorm;

use Brainstorm\Interfaces\Transport;
use Brainstorm\Interfaces\Storage;

class Quiz
{
    /** @var Storage */
    protected $dataStorage;

    /** @var Storage */
    protected $currentStorage;

    /** @var Transport */
    protected $transport;
    protected $strategies = [];

    /**
     * @param Transport $transport
     * @return $this
     */
    public function setTransport(Transport $transport)
    {
        $this->transport = $transport;
        return $this;
    }

    /**
     * @return Transport
     */
    public function getTransport()
    {
        return $this->transport;
    }

    /**
     * @return Storage
     */
    public function getDataStorage()
    {
        return $this->dataStorage;
    }

    /**
     * @param Storage $dataStorage
     * @return $this
     */
    public function setDataStorage(Storage $dataStorage)
    {
        $this->dataStorage = $dataStorage;
        return $this;
    }

    /**
     * @return Storage
     */
    public function getCurrentStorage()
    {
        return $this->currentStorage;
    }

    /**
     * @param Storage $currentStorage
     * @return $this
     */
    public function setCurrentStorage(Storage $currentStorage)
    {
        $this->currentStorage = $currentStorage;
        return $this;
    }

    /**
     * @param string $class
     * @return $this
     * @throws \ErrorException
     */
    public function addStrategy($class)
    {
        $this->strategies[$class] = new $class($this);
        return $this;
    }

    /**
     * @param string $url
     * @throws \ErrorException
     */
    public function run($url) {

        $html = $this->getTransport()->getTo($url);

        do {
            foreach ($this->strategies as $strategy) {
                /** @var Strategy $strategy */
                if ($strategy->check($html)) {
                    $html = $strategy->process($html);
                    continue 2;
                }
            }
            var_dump($html);

            throw new \ErrorException('Suitable strategy not found');
        } while (true);
    }
}
