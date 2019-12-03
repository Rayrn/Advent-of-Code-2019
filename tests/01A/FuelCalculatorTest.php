<?php

namespace AdventOfCode\TwentyNineteen\Tests\OneA;

use dventOfCode\TwentyNineteen\OneA\FuelCalculator;
use PHPUnit\Framework\TestCase;

class FuelCalculatorTest extends TestCase
{
    /**
     * @dataProvider moduleFuelMassCalculator
     */
    public function testGetModuleFuel(int $mass, int $expectedFuel)
    {
        $this->assertEquals($expectedFuel, (new FuelCalculator())->getModuleFuel($mass));
    }

    public function moduleFuelMassCalculator()
    {
        return [
            'Preset A' => [12, 2],
            'Preset B' => [14, 2],
            'Preset C' => [1969, 654],
            'Preset D' => [100756, 33583],
            'Negative' => [-10000, 0],
            'Zero' => [0, 0],
            'Less than nine' => [8, 0],
            'Exactly nine' => [9, 1]
        ];
    }
}
