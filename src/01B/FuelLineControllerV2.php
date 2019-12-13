<?php

namespace AdventOfCode\TwentyNineteen\OneB;

use AdventOfCode\TwentyNineteen\OneA;

class FuelLineControllerV2
{
    /**
     * @var OneA\FuelCalculator
     */
    private $fuelCalculator;

    /**
     * @var OneA\ModuleList
     */
    private $moduleList;

    public function __construct(OneA\FuelCalculator $fuelCalculator, OneA\ModuleList $moduleList)
    {
        $this->fuelCalculator = $fuelCalculator;
        $this->moduleList = $moduleList;
    }

    /**
     * Calculate the combined fuel required for the modules (accounting for fuel)
     */
    public function calculateFuel(): int
    {
        $this->moduleList->setFileLocation(APP_ROOT . '/src/01A/module-list.yaml');

        $totalFuel = 0;
        foreach ($this->moduleList as $module) {
            $fuel = $this->getFuelByMass($module);

            do {
                $totalFuel += $fuel;

                $fuel = $this->getFuelByMass($fuel);
            } while ($fuel > 0);
        }

        return $totalFuel;
    }

    private function getFuelByMass(int $mass): int
    {
        return $this->fuelCalculator->getModuleFuel($mass);
    }
}
