<?php

namespace AdventOfCode\TwentyNineteen\Tests\TwoA;

use AdventOfCode\TwentyNineteen\TwoA\InvalidOperationException;
use AdventOfCode\TwentyNineteen\TwoA\ProgrammeRunner;
use AdventOfCode\TwentyNineteen\TwoA\UnknownOptCodeException;
use PHPUnit\Framework\TestCase;

class ProgrammeRunnerTest extends TestCase
{
    /**
     * @dataProvider getCommandDataProvider
     */
    public function testGetCommand(int $iteration, array $programmeData, string $expected)
    {
        $this->assertEquals($expected, (new ProgrammeRunner())->getCommand($iteration, $programmeData));
    }

    public function testGetCommandThrowsErrorForUnknownCommand()
    {
        $this->expectException(UnknownOptCodeException::class);
        $this->expectExceptionMessage('Unknown optcode: 33');

        (new ProgrammeRunner())->getCommand(0, [33, 1, 1, 0]);
    }

    public function testGetCommandThrowsErrorForMissingValue()
    {
        $this->expectException(InvalidOperationException::class);
        $this->expectExceptionMessage('Missing optcode at iteration: 4');

        (new ProgrammeRunner())->getCommand(4, [33, 1, 1, 0]);
    }

    /**
     * @dataProvider addDataProvider
     */
    public function testAdd(int $iteration, array $programmeData, array $expected)
    {
        $this->assertEquals($expected, (new ProgrammeRunner())->add($iteration, $programmeData));
    }

    public function testAddCommandThrowsErrorForMissingKeys()
    {
        $this->expectException(InvalidOperationException::class);
        $this->expectExceptionMessage('Failed to retrieve target keys at iteration: 1');

        (new ProgrammeRunner())->add(1, [1, 1, 1, 1]);
    }

    public function testAddCommandThrowsErrorForMissingValues()
    {
        $this->expectException(InvalidOperationException::class);
        $this->expectExceptionMessage('Failed to retrieve target values at iteration: 0');

        (new ProgrammeRunner())->add(0, [1, 100, 1, 1]);
    }

    /**
     * @dataProvider multiplyDataProvider
     */
    public function testMultiply(int $iteration, array $programmeData, array $expected)
    {
        $this->assertEquals($expected, (new ProgrammeRunner())->multiply($iteration, $programmeData));
    }

    public function testMultiplyCommandThrowsErrorForMissingKeys()
    {
        $this->expectException(InvalidOperationException::class);
        $this->expectExceptionMessage('Failed to retrieve target keys at iteration: 1');

        (new ProgrammeRunner())->multiply(1, [1, 1, 1, 1]);
    }

    public function testMultiplyCommandThrowsErrorForMissingValues()
    {
        $this->expectException(InvalidOperationException::class);
        $this->expectExceptionMessage('Failed to retrieve target values at iteration: 0');

        (new ProgrammeRunner())->multiply(0, [1, 100, 1, 1]);
    }

    public function getCommandDataProvider()
    {
        $programmeData = [1, 9, 10, 3, 2, 3, 11, 0, 99, 30, 40, 50];

        return [
            'Add' => [0, $programmeData, ProgrammeRunner::ADD],
            'Multiply' => [1, $programmeData, ProgrammeRunner::MULTIPLY],
            'Finish' => [2, $programmeData, ProgrammeRunner::FINISH],
        ];
    }

    public function addDataProvider()
    {
        $programmeData = [1, 9, 10, 3, 2, 3, 11, 0, 99, 30, 40, 50];

        return [
            '30 + 40 = 70' => [0, $programmeData, array_replace($programmeData, [3 => 70])],
            '3 + 50 = 53' => [1, $programmeData, array_replace($programmeData, [0 => 53])]
        ];
    }

    public function multiplyDataProvider()
    {
        $programmeData = [1, 9, 10, 3, 2, 3, 11, 0, 99, 30, 40, 50];

        return [
            '30 * 40 = 1200' => [0, $programmeData, array_replace($programmeData, [3 => 1200])],
            '3 * 50 = 150' => [1, $programmeData, array_replace($programmeData, [0 => 150])]
        ];
    }
}
