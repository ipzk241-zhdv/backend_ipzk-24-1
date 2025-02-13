<?php

require_once("./interfaces/iCleanHouse.php");


class StudentForAbstract extends AbstractHuman implements ICleanHouse
{
    private int $Course;
    private int $StudentId;
    private string $College;

    public function __construct(int $height, int $yearsOld, int $mass, string $colorOfEyes, int $course, int $studentId, string $college)
    {
        parent::__construct($height, $yearsOld, $mass, $colorOfEyes);
        $this->Course = $course;
        $this->StudentId = $studentId;
        $this->College = $college;
    }

    public function getCourse(): int
    {
        return $this->Course;
    }

    public function getStudentId(): int
    {
        return $this->StudentId;
    }

    public function getCollege(): string
    {
        return $this->College;
    }

    public function setCourse($course): void
    {
        $this->Course = $course;
    }

    public function setStudentID($studentId): void
    {
        $this->StudentId = $studentId;
    }

    public function setCollege($college): void
    {
        $this->College = $college;
    }

    public function __toString(): string
    {
        $output = parent::__toString();
        $output = $output . "<br>";
        $output = $output . "Є студентом наступного закладу: " . $this->College . ". ";
        $output = $output . "Номер його студентського квитка: " . $this->StudentId . ". ";
        $output = $output . "Навчається на " . $this->Course . " курсі.";
        return $output;
    }

    /**
     * toNewCourse переводить студента на новий курс, додаючи до Course одиницю.
     *
     * @return void
     */
    public function toNewCourse(): void
    {
        $this->StudentId = $this->StudentId + 1000;
        $this->Course++;
    }

    public function childNotify()
    {
        return "Отакої... Цей студент не встиг вилучити квадратний корінь із рівняння і в підсумку вийшла відповідь з неправильним дробом...";
    }

    public function cleanKitchen(): string
    {
        return "Студент прибрав кухню.";
    }

    public function cleanRoom(): string
    {
        return "Студент прибрав кімнату.";
    }
}