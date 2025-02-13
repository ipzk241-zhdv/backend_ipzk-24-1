<?php

namespace classList\Circles;

class Circle
{
    private int $xCord;
    private int $yCord;
    private int $radius;
    
    /**
     * __toString повертає властивості кола
     *
     * @return string
     */
    public function __toString(): string
    {
        return "Коло з центром в ($this->xCord,$this->yCord) і радіусом $this->radius";
    }


    /**
     * __construct конструктор за замовчуванням
     *
     * @param  int $x x координата кола
     * @param  int $y у координата кола
     * @param  int $radius радіус кола
     * @return void
     */
    public function __construct(int $x, int $y, int $radius)
    {
        $this->xCord = $x;
        $this->yCord = $y;
        $this->radius = $radius;
    }

    /**
     * SetX встановлює $х в х координату кола
     *
     * @param  int $x
     * @return void
     */
    public function SetX(int $x) : void
    {
        $this->xCord = $x;
    }

    /**
     * SetY встановлює $y в х координату кола
     *
     * @param  int $y
     * @return void
     */
    public function SetY(int $y) : void
    {
        $this->yCord = $y;
    }

    /**
     * SetRadius встановлює $radius як радіус кола
     *
     * @param  mixed $radius
     * @return void
     */
    public function SetRadius(int $radius) : void
    {
        $this->radius = $radius;
    }

    /**
     * GetX повертає х координату кола
     *
     * @return int
     */
    public function GetX(): int
    {
        return $this->xCord;
    }

    /**
     * GetY повертає у координату кола
     *
     * @return int
     */
    public function GetY(): int
    {
        return $this->yCord;
    }

    /**
     * GetRadius повертає радіус кола
     *
     * @return int
     */
    public function GetRadius(): int
    {
        return $this->radius;
    }
    
    /**
     * IntersectOther перевіряє чи два кола перетинаються
     *
     * @param  Circle $otherCircle інше коло
     * @return bool повертає істину, якщо кола перетинаються і хибність, якщо ні
     */
    public function IntersectOther(Circle $otherCircle): bool
    {
        // квадрат відстані між колами
        $distanceSquared = pow($otherCircle->GetX() - $this->GetX(), 2) + pow($otherCircle->GetY() - $this->GetX(), 2);

        // квадрат суми радіусів кол
        $radiiSumSquared = pow($this->GetRadius() + $otherCircle->GetRadius(), 2);
        return $distanceSquared < $radiiSumSquared;
    }
}