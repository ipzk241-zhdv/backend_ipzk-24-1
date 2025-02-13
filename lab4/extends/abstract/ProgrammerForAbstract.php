<?php

require_once("./interfaces/iCleanHouse.php");

class ProgrammerForAbstract extends AbstractHuman implements ICleanHouse
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

    public function childNotify()
    {
        return "Отакої... У програміста народилась Ruby...";
    }

    public function cleanKitchen(): string
    {
        return "Програміст прибрав кухню за допомогою нанотехнологічного обладнання.";
    }

    public function cleanRoom(): string
    {
        return "Програміст за допомгою власнорозробленого технологічно автобота прибрав кімнату.";
    }
}