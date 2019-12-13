<?php

namespace AdventOfCode\TwentyNineteen;

use League\Container\Container;
use League\Container\ReflectionContainer;

class Runner extends Container
{
    public function __construct()
    {
        parent::__construct();

        // Enable auto-wiring in the container
        $this->delegate(new ReflectionContainer());
    }

    public function run()
    {
        $output = [];

        $output['oneA'] = $this->get(OneA\FuelLineController::class)->calculateFuel();
        $output['oneB'] = $this->get(OneB\FuelLineControllerV2::class)->calculateFuel();

        print_r($output);
    }
}
