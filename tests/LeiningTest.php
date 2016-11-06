<?php

use Zmanim\Zman;

class LeiningTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function there_is_leining_on_all_mondays()
    {
        $this->assertTrue(Zman::parse('November 7, 2016')->hasLeining());
    }

    /** @test */
    public function there_is_leining_on_all_thursdays()
    {
        $this->assertTrue(Zman::parse('November 10, 2016')->hasLeining());
    }

    /** @test */
    public function there_is_leining_on_all_shabbosim()
    {
        $this->assertTrue(Zman::parse('November 12, 2016')->hasLeining());
    }

    /** @test */
    public function there_is_no_leining_on_regular_weekdays()
    {
        $this->assertFalse(Zman::parse('November 6, 2016')->hasLeining());
        $this->assertFalse(Zman::parse('November 8, 2016')->hasLeining());
        $this->assertFalse(Zman::parse('November 9, 2016')->hasLeining());
        $this->assertFalse(Zman::parse('November 11, 2016')->hasLeining());
    }

    /** @test */
    public function there_is_leining_on_rosh_chodesh()
    {
        $this->assertTrue(Zman::parse('November 1, 2016')->hasLeining());
    }

    /** @test */
    public function there_is_leining_on_fast_days()
    {
        $this->assertTrue(Zman::parse('January 8, 2017')->hasLeining());
    }

    /** @test */
    public function there_is_leining_on_yuntif()
    {
        $this->assertTrue(Zman::parse('April 11, 2017')->hasLeining());
    }

    /** @test */
    public function there_is_leining_on_chol_hamoed()
    {
        $this->assertTrue(Zman::parse('April 14, 2017')->hasLeining());
    }

    // public function there_is_leining_on_chanuka()
    // public function there_is_leining_on_purim()
}
