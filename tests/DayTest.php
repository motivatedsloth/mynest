<?php
use PHPUnit\Framework\TestCase;
use constellation\mynest\Schedules\Day;

class DayTest extends TestCase{
  public function testValidTerm(){
    $day = new Day;
    $this->assertEquals("day", $day->validTerm("day"));
    $this->assertEquals("0800", $day->validTerm(8)->format("Hi"));
    $this->assertFalse($day->validTerm(25));
    $this->assertFalse($day->validTerm("blah"));
  }
  public function testSingle(){
    $day = new Day;
    $day->set(100);
    $this->assertEquals(100, $day->val(new DateTime));
  }
  public function testDayNight(){
    $day = new Day;
    $day->set("day", 100);
    $day->set("night", 40);
    $this->assertEquals(100, $day->val(new DateTime("0821")));
    $this->assertEquals(40, $day->val(new DateTime("1821")));
  }
  public function testDayNightException(){
    $day = new Day;
    $day->set("day", 100);
    $this->expectException(RuntimeException);
    $day->val(new DateTime("1821"));
  }
  public function testTimes(){
    $day = new Day;
    $day->set(8, 100);
    $day->set("1830", 20);
    $this->assertEquals(100, $day->val(new DateTime("0900")));
    $this->assertEquals(20, $day->val(new Datetime("2000")));
  }
  public function testTimesException(){
    $day = new Day;
    $day->set(8, 100);
    $day->set("1830", 20);
    $this->expectException(OutOfBoundsException);
    $day->val(new Datetime("0600"));
  }
}

