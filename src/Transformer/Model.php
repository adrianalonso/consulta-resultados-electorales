<?php

namespace App\Transformer;

use Doctrine\Common\Collections\ArrayCollection;
use League\Csv\Reader;
use League\Csv\Statement;

/**
 * Class Model
 * @package App\Transformer
 */
class Model
{

    /**
     * @var string
     */
    protected $fileTypeIdentifier;

    /**
     * @var string
     */
    protected $filename;

    /**
     * @var ArrayCollection
     */
    protected $rows;

    /**
     * Model constructor.
     * @param string $fileTypeIdentifier
     */
    public function __construct(string $fileTypeIdentifier, $filename)
    {
        $this->rows = new ArrayCollection();
        $this->fileTypeIdentifier = $fileTypeIdentifier;
        $this->parse($filename);
    }

    /**
     * @param $filename
     * @return $this
     */
    private function parse($filename)
    {
        $reader = Reader::createFromPath($filename);

        $records = (new Statement())->process($reader);
        $iterator = $records->getIterator();

        $iterator->next();
        while ($iterator->current()) {
            $row = $iterator->current();
            ;
            $this->rows->add(new ModelRow($row[0], $row[1], $row[2]));
            $iterator->next();
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getHeader()
    {
        $headers=[];
        foreach ($this->getRows() as $row) {
            $headers[]=$row->getColumn();
        }

        return $headers;
    }

    /**
     * @return string
     */
    public function getFileTypeIdentifier()
    {
        return $this->fileTypeIdentifier;
    }

    /**
     * @param string $fileTypeIdentifier
     */
    public function setFileTypeIdentifier($fileTypeIdentifier)
    {
        $this->fileTypeIdentifier = $fileTypeIdentifier;
    }

    /**
     * @return ArrayCollection
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param ArrayCollection $rows
     */
    public function setRows($rows)
    {
        $this->rows = $rows;
    }
}
