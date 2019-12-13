<?php

namespace AdventOfCode\TwentyNineteen\OneA;

class FuelLineController
{
    /**
     * @var FuelCalculator
     */
    private $fuelCalculator;

    /**
     * @var ModuleList
     */
    private $moduleList;

    public function __construct(FuelCalculator $fuelCalculator, ModuleList $moduleList)
    {
        $this->fuelCalculator = $fuelCalculator;
        $this->moduleList = $moduleList;
    }

    /**
     * Calculate the combined fuel required for the modules
     */
    public function calculateFuel(): int
    {
        $this->moduleList->setFileLocation(APP_ROOT . '/src/01A/module-list.yaml');

        $fuel = 0;
        foreach ($this->moduleList as $module) {
            $fuel += $this->fuelCalculator->getModuleFuel($module);
        }

        return $fuel;
    }
}
