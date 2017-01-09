<?php
namespace Brainstorm\Storage;

use Brainstorm\Interfaces\Storage;

/**
 * not ready. just idea.
 * @deprecated
 */
class MySQL extends \CachingIterator implements Storage
{
    private $PDO;
    private $index;

    public $tableName = 'Brainstorm';

    public function __construct($dsn, $user, $password)
    {
        $this->PDO = new \PDO($dsn, $user, $password, [
            \PDO::ATTR_PERSISTENT => true
        ]);
        $this->PDO->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

        $statement = $this->PDO->query("SELECT * FROM {$this->tableName} WHERE 1");

        parent::__construct(new \IteratorIterator($statement), self::FULL_CACHE);
    }

    public function rewind()
    {
        if (NULL === $this->index) {
            parent::rewind();
        }
        $this->index = 0;
    }

    public function current()
    {
        if ($this->offsetExists($this->index)) {
            return $this->offsetGet($this->index);
        }
        return parent::current();
    }

    public function key()
    {
        return $this->index;
    }

    public function next()
    {
        $this->index++;
        if (!$this->offsetExists($this->index)) {
            parent::next();
        }
    }

    public function valid()
    {
        return $this->offsetExists($this->index) || parent::valid();
    }
}
