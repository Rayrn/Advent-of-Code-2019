<?php

namespace AdventOfCode\TwentyNineteen\Tests\TwoA;

use AdventOfCode\TwentyNineteen\TwoA\ProgrammeReader;
use ArrayIterator;
use PHPUnit\Framework\TestCase;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Parser;

class ProgrammeReaderTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private const FILE_LOCATION = 'I/Am/A/File/Location';

    /**
     * @var ProgrammeReader
     */
    private $component;

    /**
     * @var Parser
     */
    private $parser;

    public function setUp(): void
    {
        $this->parser = Mockery::mock(Parser::class);
        $this->component = new ProgrammeReader($this->parser);
    }

    public function testGetIteratorReturnsEmptyOnNoFilePath()
    {
        $this->parser->shouldReceive('parseFile')->never();

        $this->assertSame([], $this->component->getIterator()->getArrayCopy());
    }

    public function testGetIteratorReturnsEmptyOnParseException()
    {
        $this->parser->shouldReceive('parseFile')
            ->once()
            ->with(self::FILE_LOCATION)
            ->andThrow(new ParseException('Test message'));

        $this->component->setFileLocation(self::FILE_LOCATION);

        $this->assertSame([], $this->component->getIterator()->getArrayCopy());
    }

    public function testGetIteratorReturnsCorrectItemsOnValidInput()
    {
        $this->parser->shouldReceive('parseFile')
            ->once()
            ->with(self::FILE_LOCATION)
            ->andReturn('10,20,30,40,50,60,70,80,90,100');

        $this->component->setFileLocation(self::FILE_LOCATION);

        $this->assertSame(
            [10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
            $this->component->getIterator()->getArrayCopy()
        );
    }

    public function testGetIteratorSkipsOnKnownFileContents()
    {
        $this->parser->shouldReceive('parseFile')
            ->once()
            ->with(self::FILE_LOCATION)
            ->andReturn('10,20,30,40,50,60,70,80,90,100');

        $this->component->setFileLocation(self::FILE_LOCATION);

        // Fire twice
        $this->component->getIterator();
        $this->component->getIterator();

        $this->assertSame(
            [10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
            $this->component->getIterator()->getArrayCopy()
        );
    }

    public function testFileContentsIsResetWhenNewLocationIsPassed()
    {
        $this->parser->shouldReceive('parseFile')
            ->once()
            ->with(self::FILE_LOCATION)
            ->andReturn('10,20,30,40,50,60,70,80,90,100');

        $this->parser->shouldReceive('parseFile')
            ->once()
            ->with(self::FILE_LOCATION . 'b')
            ->andReturn('10000');

        $this->component->setFileLocation(self::FILE_LOCATION);
        $this->assertSame(
            [10, 20, 30, 40, 50, 60, 70, 80, 90, 100],
            $this->component->getIterator()->getArrayCopy()
        );

        $this->component->setFileLocation(self::FILE_LOCATION . 'b');
        $this->assertSame(
            [10000],
            $this->component->getIterator()->getArrayCopy()
        );
    }
}
