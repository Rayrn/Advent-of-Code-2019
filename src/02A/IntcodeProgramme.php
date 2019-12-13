<?php

namespace AdventOfCode\TwentyNineteen\TwoA;

class IntcodeProgramme
{
    private const ADD_COMMAND = 'add';
    private const MULTIPLY_COMMAND = 'multiply';
    private const FINISH_COMMAND = 'finish';

    /**
     * @var ProgrammeReader
     */
    private $programmeReader;

    /**
     * @var array
     */
    private $programmeData;

    public function __construct(ProgrammeReader $ProgrammeReader)
    {
        $this->programmeReader = $programmeReader;
        $this->programmeData = [];
    }

    /**
     * throws UnknownOptCodeException
     */
    public function runProgramme(): array
    {
        $this->programmeReader->setFileLocation(APP_ROOT . '/src/02A/command-list.yaml');
        $this->programmeData = $this->programmeReader->getIterator()->getArrayCopy();

        $iteration = 0;

        do {
            $command = $this->getCommand($iteration, $this->programmeData);

            switch ($command) {
                case self::ADD_COMMAND:
                    $this->programmeData = $this->addCommand($iteration, $programmeData);
                    break;
                case self::MULTIPLY_COMMAND:
                    $this->programmeData = $this->multiplyCommand($iteration, $programmeData);
                    break;
                default:
                    throw new UnknownOptCodeException("Unknown optcode: $optCode");
                    break;
            }
        } while ($command != self::FINISH_COMMAND);


        return $command;
    }

    /**
     * throws UnknownOptCodeException
     */
    private function getCommand(int $iteration, array $programmeData): int
    {
        $optCode = $programmeData[$iteration * 4] ?? -1;

        if ($optCode === 1) {
            return self::ADD_COMMAND;
        }

        if ($optCode === 2) {
            return self::MULTIPLY_COMMAND;
        }

        if ($optCode === 99) {
            return self::FINISH_COMMAND;
        }

        throw new UnknownOptCodeException("Unknown optcode: $optCode");
    }

    private function addCommand(int $iteration, array $programmeData): array
    {
        $alpha = $programmeData[($iteration * 4) + 1];
        $beta = $programmeData[($iteration * 4) + 2];
        $target = $programmeData[($iteration * 4) + 3];

        $programmeData[$target] = $programmeData[$alpha] + $programmeData[$beta];

        return $programmeData;
    }

    private function multiplyCommand(int $iteration, array $programmeData): array
    {
        $alpha = $programmeData[($iteration * 4) + 1];
        $beta = $programmeData[($iteration * 4) + 2];
        $target = $programmeData[($iteration * 4) + 3];

        $programmeData[$target] = $programmeData[$alpha] + $programmeData[$beta];

        return $programmeData;
    }
}
