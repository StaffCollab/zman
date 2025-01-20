<?php

namespace Zman\Helpers;

trait HebrewDateArithmetic
{
    /**
     * Add Hebrew months to the current date
     *
     * @param int $months Number of months to add
     * @return static
     */
    public function addHebrewMonths(int $months = 1): static
    {
        $month = $this->jdate['month'];
        $year = $this->jdate['year'];
        $day = $this->jdate['day'] === 30 ? 29 : $this->jdate['day'];

        while ($months > 0) {
            if ($month < 13) {
                $month++;
            } else {
                $month = 1;
                $year++;
            }
            $months--;

            if ($month === 6 && !isJewishLeapYear($year)) $month = 7;
        }

        while ($months < 0) {
            if ($month > 1) {
                $month--;
            } else {
                $month = 13;
                $year--;
            }
            $months++;

            if ($month === 6 && !isJewishLeapYear($year)) $month = 5;
        }

        return static::createFromJewishDate($year, $month, $day);
    }

    /**
     * Subtract Hebrew months from the current date
     *
     * @param int $months Number of months to subtract
     * @return static
     */
    public function subHebrewMonths(int $months = 1): static
    {
        return $this->addHebrewMonths(-$months);
    }

    /**
     * Add Hebrew years to the current date
     *
     * @param int $years Number of years to add
     * @return static
     */
    public function addHebrewYears(int $years = 1): static
    {
        $year = $this->jdate['year'] + $years;
        $month = $this->jdate['month'];
        $day = $this->jdate['day'] === 30 ? 29 : $this->jdate['day'];

        if ($month === 6 && !isJewishLeapYear($year)) $month = 7;

        return static::createFromJewishDate($year, $month, $day);
    }

    /**
     * Subtract Hebrew years from the current date
     *
     * @param int $years Number of years to subtract
     * @return static
     */
    public function subHebrewYears(int $years = 1): static
    {
        return $this->addHebrewYears(-$years);
    }

    /**
     * Add a single Hebrew month
     *
     * @return static
     */
    public function addHebrewMonth(): static
    {
        return $this->addHebrewMonths(1);
    }

    /**
     * Subtract a single Hebrew month
     *
     * @return static
     */
    public function subHebrewMonth(): static
    {
        return $this->subHebrewMonths(1);
    }

    /**
     * Add a single Hebrew year
     *
     * @return static
     */
    public function addHebrewYear(): static
    {
        return $this->addHebrewYears(1);
    }

    /**
     * Subtract a single Hebrew year
     *
     * @return static
     */
    public function subHebrewYear(): static
    {
        return $this->subHebrewYears(1);
    }
}
