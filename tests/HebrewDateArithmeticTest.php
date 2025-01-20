<?php

namespace Zman\Tests;

use PHPUnit\Framework\TestCase;
use Zman\Zman;

class HebrewDateArithmeticTest extends TestCase
{
    /**
     * Test adding months in a regular year
     */
    public function testAddMonthsInRegularYear(): void
    {
        // Start with 1 Cheshvan 5784 (non-leap year)
        $date = Zman::createFromJewishDate(5784, 2, 1);

        // Add 1 month - should be 1 Kislev 5784
        $result = $date->addHebrewMonth();
        $this->assertEquals(5784, $result->jewishYear);
        $this->assertEquals(3, $result->jewishMonth);
        $this->assertEquals(1, $result->jewishDay);

        // Add 3 months from Cheshvan - should be 1 Shvat 5784
        $result = $date->addHebrewMonths(3);
        $this->assertEquals(5784, $result->jewishYear);
        $this->assertEquals(5, $result->jewishMonth);
        $this->assertEquals(1, $result->jewishDay);

        // Add 11 months from Cheshvan - should be 1 Tishrei 5785
        $result = $date->addHebrewMonths(12);
        $this->assertEquals(5785, $result->jewishYear);
        $this->assertEquals(1, $result->jewishMonth);
        $this->assertEquals(1, $result->jewishDay);
    }

    /**
     * Test adding months in a leap year
     */
    public function testAddMonthsInLeapYear(): void
    {
        // Start with 1 Cheshvan 5786 (non-leap year)
        $date = Zman::createFromJewishDate(5786, 2, 1);

        // Add 15 months - should land in 5787 (leap year) in Adar I
        $result = $date->addHebrewMonths(16);
        $this->assertEquals(5787, $result->jewishYear);
        $this->assertEquals(6, $result->jewishMonth); // Adar I
        $this->assertEquals(1, $result->jewishDay);

        // Add 16 months - should land in 5787 (leap year) in Adar II
        $result = $date->addHebrewMonths(17);
        $this->assertEquals(5787, $result->jewishYear);
        $this->assertEquals(7, $result->jewishMonth); // Adar II
        $this->assertEquals(1, $result->jewishDay);
    }

    /**
     * Test subtracting months
     */
    public function testSubtractMonths(): void
    {
        // Start with 1 Tishrei 5787 (leap year)
        $date = Zman::createFromJewishDate(5787, 1, 1);

        // Subtract 1 month - should be 1 Elul 5786
        $result = $date->subHebrewMonth();
        $this->assertEquals(5786, $result->jewishYear);
        $this->assertEquals(13, $result->jewishMonth);
        $this->assertEquals(1, $result->jewishDay);

        // Subtract 13 months from Tishrei in leap year - should be 1 Elul 5785
        $result = $date->subHebrewMonths(13);
        $this->assertEquals(5785, $result->jewishYear);
        $this->assertEquals(13, $result->jewishMonth);
        $this->assertEquals(1, $result->jewishDay);
    }

    /**
     * Test adding years with special handling of Adar II
     */
    public function testAddYearsWithAdar(): void
    {
        // Start with 1 Adar II 5787 (leap year)
        $date = Zman::createFromJewishDate(5787, 6, 1);

        // Add 1 year - should go to regular Adar in 5788 (non-leap year)
        $result = $date->addHebrewYear();
        $this->assertEquals(5788, $result->jewishYear);
        $this->assertEquals(7, $result->jewishMonth); // Regular Adar
        $this->assertEquals(1, $result->jewishDay);
    }

    /**
     * Test subtracting years with special handling of Adar
     */
    public function testSubtractYearsWithAdar(): void
    {
        // Start with 1 Adar 5788 (regular year)
        $date = Zman::createFromJewishDate(5787, 6, 1);

        // Subtract 1 year - should go to Adar I in 5787 (leap year)
        $result = $date->subHebrewYear();
        $this->assertEquals(5786, $result->jewishYear);
        $this->assertEquals(7, $result->jewishMonth); // Adar
        $this->assertEquals(1, $result->jewishDay);
    }
}
