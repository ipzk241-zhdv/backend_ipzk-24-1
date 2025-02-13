<?php

abstract class AbstractHuman
{
    private int $Height;
    private int $YearsOld;
    private int $Mass;
    private string $ColorOfEyes;

    public function __construct(int $height, int $yearsOld, int $mass, string $colorOfEyes)
    {
        $this->Height = $height;
        $this->YearsOld = $yearsOld;
        $this->Mass = $mass;
        $this->ColorOfEyes = $colorOfEyes;
    }

    public function getHeight(): int
    {
        return $this->Height;
    }

    public function getYearsOld(): int
    {
        return $this->YearsOld;
    }

    public function getMass(): int
    {
        return $this->Mass;
    }

    public function getColorOfEyes(): string
    {
        return $this->ColorOfEyes;
    }

    public function setHeight(int $height): void
    {
        $this->Height = $height;
    }

    public function setYearsOld(int $yearsOld): void
    {
        $this->YearsOld = $yearsOld;
    }

    public function setMass(int $mass): void
    {
        $this->Mass = $mass;
    }

    public function setColorOfEyes(string $colorOfEyes): void
    {
        $this->ColorOfEyes = $colorOfEyes;
    }

    public function __toString(): string
    {
        $output = "Цій людині ";
        $output = $output . $this->YearsOld . " років. ";
        $output = $output . "Її зріст - " . $this->Height . " . ";
        $output = $output . "Вона важить " . $this->Mass . "кг. ";
        $output = $output . "Вона має " . $this->ColorOfEyes . " колір очей.";
        return $output;
    }

    function childBirth(int $year, int $month, int $day)
    {
        $this->childNotify();
    }

    protected abstract function childNotify();

}