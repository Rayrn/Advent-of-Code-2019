<?php

namespace AdventOfCode\TwentyNineteen\OneA;

class FuelCalculator
{
    /**
     * To find the fuel required for a module, take its mass, divide by three, round down, and subtract 2.
     */
    public function getModuleFuel(int $mass): int
    {
        if ($mass < 9) {
            return 0;
        }

        return intval($mass / 3) - 2;
    }
}
