<?php
namespace Brainstorm\Storage;

use Brainstorm\Interfaces\Storage;
use Brainstorm\Question\Simple;

class Memory extends \SplObjectStorage implements Storage
{
    /**
     * @param Simple $obj
     * @return mixed
     */
    public function getHash($obj) {
        return $obj->getHash();
    }
}
