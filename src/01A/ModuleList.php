<?php

namespace AdventOfCode\TwentyNineteen\OneA;

use ArrayIterator;
use IteratorAggregate;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

class ModuleList implements IteratorAggregate
{
    /**
     * @var string|null
     */
    private $fileLocation;

    /**
     * @var array|null
     */
    private $fileContents;

    /**
     * @var Parser
     */
    private $parser;

    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    public function setFileLocation(string $fileLocation)
    {
         $this->fileLocation = $fileLocation;
         $this->fileContents = null;
    }

    /**
     * Output a list each modules weight
     */
    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->getFileContents());
    }

    private function getFileContents(): array
    {
        if ($this->fileLocation === null) {
            return [];
        }

        if ($this->fileContents !== null) {
            return $this->fileContents;
        }

        try {
            $fileContents = $this->parser->parseFile($this->fileLocation);

            $this->fileContents = array_map('intval', explode(' ', $fileContents));
        } catch (ParseException $e) {
            $this->fileContents = [];
        }

        return $this->fileContents;
    }
}
