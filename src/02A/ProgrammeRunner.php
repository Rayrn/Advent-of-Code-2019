<?php

namespace AdventOfCode\TwentyNineteen\TwoA;

class ProgrammeRunner
{
    public const ADD = 'add';
    public const MULTIPLY = 'multiply';
    public const FINISH = 'finish';

    /**
     * throws InvalidOperationException
     * throws UnknownOptCodeException
     */
    public function getCommand(int $iteration, array $programmeData): string
    {
        if (!isset($programmeData[$iteration * 4])) {
            throw new InvalidOperationException(
                "Missing optcode at iteration: $iteration, Data: " . print_r($programmeData, true)
            );
        }

        $optCode = $programmeData[$iteration * 4];

        if ($optCode === 1) {
            return self::ADD;
        }

        if ($optCode === 2) {
            return self::MULTIPLY;
        }

        if ($optCode === 99) {
            return self::FINISH;
        }

        throw new UnknownOptCodeException("Unknown optcode: $optCode");
    }

    /**
     * throws InvalidOperationException
     */
    public function add(int $iteration, array $programmeData): array
    {
        [$alphaValue, $betaValue, $targetKey] = $this->getElements($iteration, $programmeData);

        $programmeData[$targetKey] = $alphaValue + $betaValue;

        return $programmeData;
    }

    /**
     * throws InvalidOperationException
     */
    public function multiply(int $iteration, array $programmeData): array
    {
        [$alphaValue, $betaValue, $targetKey] = $this->getElements($iteration, $programmeData);

        $programmeData[$targetKey] = $alphaValue * $betaValue;

        return $programmeData;
    }

    /**
     * throws InvalidOperationException
     */
    private function getElements(int $iteration, array $programmeData): array
    {
        $baseIndex = $iteration * 4;

        $alphaKey = $programmeData[$baseIndex + 1] ?? -1;
        $betaKey = $programmeData[$baseIndex + 2] ?? -1;
        $targetKey = $programmeData[$baseIndex + 3] ?? -1;

        if (in_array(-1, [$alphaKey, $betaKey, $targetKey])) {
            throw new InvalidOperationException(
                "Failed to retrieve target keys at iteration: $iteration, Data: " . print_r($programmeData, true)
            );
        }

        $alphaValue = $programmeData[$alphaKey] ?? -1;
        $betaValue = $programmeData[$betaKey] ?? -1;

        if (in_array(-1, [$alphaValue, $betaValue])) {
            throw new InvalidOperationException(
                "Failed to retrieve target values at iteration: $iteration, Data: " . print_r($programmeData, true)
            );
        }

        return [$alphaValue, $betaValue, $targetKey];
    }
}
