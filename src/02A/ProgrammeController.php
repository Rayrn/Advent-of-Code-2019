<?php

namespace AdventOfCode\TwentyNineteen\TwoA;

class ProgrammeController
{
    /**
     * @var ProgrammeReader
     */
    private $programmeReader;

    /**
     * @var ProgrammeRunner
     */
    private $programmeRunner;

    /**
     * @var array
     */
    private $programmeData;

    public function __construct(ProgrammeReader $programmeReader, ProgrammeRunner $programmeRunner)
    {
        $this->programmeReader = $programmeReader;
        $this->programmeRunner = $programmeRunner;
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
                case ProgrammeRunner::ADD:
                    $this->programmeData = $this->addCommand($iteration, $programmeData);
                    break;
                case ProgrammeRunner::MULTIPLY:
                    $this->programmeData = $this->multiplyCommand($iteration, $programmeData);
                    break;
                case ProgrammeRunner::FINISH:
                default:
                    break;
            }
        } while ($command != ProgrammeRunner::FINISH_COMMAND);

        return $command;
    }
}
