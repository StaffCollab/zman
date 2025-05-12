<?php

namespace Zman\Tests;

use PHPUnit\Framework\TestCase;
use Zman\Zman;
use Zman\VessetCalculator;

class VessetCalculatorTest extends TestCase
{
    private VessetCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new VessetCalculator();
    }

    /**
     * Test וסת החודש קבוע - when a woman sees on the same Jewish date for 3 times
     */
    public function testVessetHachodeshKavua(): void
    {
        // Woman who sees on 15th of each month for 3 consecutive months
        $periods = [
            Zman::createFromJewishDate(5784, 1, 15), // 15 Tishrei
            Zman::createFromJewishDate(5784, 2, 15), // 15 Cheshvan
            Zman::createFromJewishDate(5784, 3, 15), // 15 Kislev
        ];

        $vessetot = $this->calculator->calculateVessetot($periods);

        $this->assertTrue($vessetot->hasVessetHachodeshKavua());
        $this->assertEquals(15, $vessetot->getVessetHachodesh()->getDayOfMonth());
    }

    /**
     * Test וסת הפלגה קבוע - when there's a fixed interval between periods
     */
    public function testVessetHaflagaKavua(): void
    {
        // Woman who sees every 30 days for 3 times
        $periods = [
            Zman::create('2024-01-01'),
            Zman::create('2024-01-31'),
            Zman::create('2024-03-01'),
            Zman::create('2024-03-31'),
        ];

        $vessetot = $this->calculator->calculateVessetot($periods);

        $this->assertTrue($vessetot->hasVessetHaflagaKavua());
        $this->assertEquals(30, $vessetot->getVessetHaflaga()->getInterval());
    }

    /**
     * Test וסת הדילוג - when there's a pattern of skipping
     */
    public function testVessetHadilug(): void
    {
        // Woman who sees on increasing dates: 1st, then 2nd, then 3rd of month
        $periods = [
            Zman::createFromJewishDate(5784, 1, 1),  // 1 Tishrei
            Zman::createFromJewishDate(5784, 2, 2),  // 2 Cheshvan
            Zman::createFromJewishDate(5784, 3, 3),  // 3 Kislev
        ];

        $vessetot = $this->calculator->calculateVessetot($periods);

        $this->assertTrue($vessetot->hasVessetHadilug());
        $this->assertEquals(1, $vessetot->getVessetHadilug()->getDilugInterval());
    }

    /**
     * Test עקירת וסת - when a pattern is broken
     */
    public function testAkiratVesset(): void
    {
        // Establish a וסת החודש
        $periods = [
            Zman::createFromJewishDate(5784, 1, 15),
            Zman::createFromJewishDate(5784, 2, 15),
            Zman::createFromJewishDate(5784, 3, 15),
        ];

        $calculator = $this->calculator;
        $vessetot = $calculator->calculateVessetot($periods);
        $this->assertTrue($vessetot->hasVessetHachodeshKavua());

        // Add a period that breaks the pattern
        $periods[] = Zman::createFromJewishDate(5784, 4, 20);
        $vessetot = $calculator->calculateVessetot($periods);

        // The וסת should now be considered עקור after one miss
        $this->assertFalse($vessetot->hasVessetHachodeshKavua());
    }

    /**
     * Test וסת שאינו קבוע - when there's a pattern but not established
     */
    public function testVessetSheEinoKavua(): void
    {
        // Two occurrences on the 15th - not enough to establish קביעות
        $periods = [
            Zman::createFromJewishDate(5784, 1, 15),
            Zman::createFromJewishDate(5784, 2, 15),
        ];

        $vessetot = $this->calculator->calculateVessetot($periods);

        $this->assertFalse($vessetot->hasVessetHachodeshKavua());
        $this->assertTrue($vessetot->hasVessetHachodeshSheEinoKavua());
    }
}
