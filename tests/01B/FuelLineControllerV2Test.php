<?php

namespace AdventOfCode\TwentyNineteen\Tests\OneB;

use AdventOfCode\TwentyNineteen\OneA\FuelCalculator;
use AdventOfCode\TwentyNineteen\OneA\ModuleList;
use AdventOfCode\TwentyNineteen\OneB\FuelLineControllerV2;
use ArrayIterator;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Parser;

class FuelLineControllerV2Test extends TestCase
{
    use MockeryPHPUnitIntegration;

    private const FILE_LOCATION = 'I/Am/A/File/Location';

    /**
     * @var FuelLineControllerV2
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

        $this->component = new FuelLineControllerV2($this->fuelCalculator, $this->moduleList);
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
        $this->fuelCalculator->shouldReceive('getModuleFuel')->once()->with(100)->andReturn(0);
        $this->fuelCalculator->shouldReceive('getModuleFuel')->once()->with(5)->andReturn(500);
        $this->fuelCalculator->shouldReceive('getModuleFuel')->once()->with(500)->andReturn(0);
        $this->fuelCalculator->shouldReceive('getModuleFuel')->once()->with(10)->andReturn(1000);
        $this->fuelCalculator->shouldReceive('getModuleFuel')->once()->with(1000)->andReturn(0);

        $this->assertSame(1600, $this->component->calculateFuel());
    }

    public function testCalculateFuelIsRecursive()
    {
        $this->moduleList->shouldReceive('setFileLocation')->once();
        $this->moduleList->shouldReceive('getIterator')
            ->once()
            ->andReturn(new ArrayIterator([1969]));

        $this->fuelCalculator->shouldReceive('getModuleFuel')->once()->with(1969)->andReturn(654);
        $this->fuelCalculator->shouldReceive('getModuleFuel')->once()->with(654)->andReturn(216);
        $this->fuelCalculator->shouldReceive('getModuleFuel')->once()->with(216)->andReturn(70);
        $this->fuelCalculator->shouldReceive('getModuleFuel')->once()->with(70)->andReturn(21);
        $this->fuelCalculator->shouldReceive('getModuleFuel')->once()->with(21)->andReturn(5);
        $this->fuelCalculator->shouldReceive('getModuleFuel')->once()->with(5)->andReturn(0);

        $this->assertSame(966, $this->component->calculateFuel());
    }
}
