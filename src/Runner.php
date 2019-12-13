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

        $oneA = $this->get(OneA\FuelLineController::class);
        $output['oneA'] = $oneA->calculateFuel();

        print_r($output);
    }
}
