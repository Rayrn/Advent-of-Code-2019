<?php

namespace AdventOfCode\TwentyNineteen\Tests\OneA;

use AdventOfCode\TwentyNineteen\OneA\FuelCalculator;
use AdventOfCode\TwentyNineteen\OneA\FuelLineController;
use AdventOfCode\TwentyNineteen\OneA\ModuleList;
use ArrayIterator;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Parser;

class FuelLineControllerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    private const FILE_LOCATION = 'I/Am/A/File/Location';

    /**
     * @var FuelLineController
     */
    private $component;

    /**
     * @var FuelCalculator
     */
    private $fuelCalculator;

    /**
     * @var ModuleList
     */
    private $moduleList;

    public function setUp(): void
    {
        $this->fuelCalculator = Mockery::mock(FuelCalculator::class);
        $this->moduleList = Mockery::mock(ModuleList::class);

        $this->component = new FuelLineController($this->fuelCalculator, $this->moduleList);
    }

    public function testCalculateFuelAllowsForEmptyResponse()
    {
        $this->moduleList->shouldReceive('setFileLocation')->once();
        $this->moduleList->shouldReceive('getIterator')
            ->once()
            ->andReturn(new ArrayIterator([]));

        $this->fuelCalculator->shouldReceive('getModuleFuel')->never();

        $this->assertSame(0, $this->component->calculateFuel());
    }

    public function testCalculateFuelReturnsCompleteList()
    {
        $this->moduleList->shouldReceive('setFileLocation')->once();
        $this->moduleList->shouldReceive('getIterator')
            ->once()
            ->andReturn(new ArrayIterator([1, 5, 10]));

        $this->fuelCalculator->shouldReceive('getModuleFuel')->once()->with(1)->andReturn(100);
        $this->fuelCalculator->shouldReceive('getModuleFuel')->once()->with(5)->andReturn(500);
        $this->fuelCalculator->shouldReceive('getModuleFuel')->once()->with(10)->andReturn(1000);

        $this->assertSame(1600, $this->component->calculateFuel());
    }
}
