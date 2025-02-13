<?php

class Programmer extends Human
{
    private array $ProgramLanguages = [];
    private int $YearsExperiance;

    public function __construct(int $height, int $yearsOld, int $mass, string $colorOfEyes, array $programLanguages, int $yearsExperiance)
    {
        parent::__construct($height, $yearsOld, $mass, $colorOfEyes);
        $this->ProgramLanguages = $programLanguages;
        $this->YearsExperiance = $yearsExperiance;
    }

    public function getProgramLanguages(): array
    {
        return $this->ProgramLanguages;
    }

    public function getYearsExperiance(): int
    {
        return $this->YearsExperiance;
    }

    public function setProgramLanguages(array $programLanguages): void
    {
        $this->ProgramLanguages = $programLanguages;
    }

    public function setYearsExperiance(int $yearsExperiance): void
    {
        $this->YearsExperiance = $yearsExperiance;
    }

    public function addProgramLanguage(string $language): void
    {
        array_push($this->ProgramLanguages, $language);
    }

    public function __toString(): string
    {
        $output = parent::__toString();
        $output = $output . "<br>Є програмістом. Його стаж роботи програмістом - " . $this->YearsExperiance . " років. ";
        $output = $output . "Знає наступні мови програмування: " . implode(", ", $this->ProgramLanguages) . ". ";
        return $output;
    }
}