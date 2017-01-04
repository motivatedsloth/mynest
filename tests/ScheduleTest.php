<?php
use PHPUnit\Framework\TestCase;
use constellation\mynest\Schedules\Schedule;

class ScheduleTest extends TestCase{
  public function testValidTerm(){
    $sched = new Schedule();
    $this->assertEquals("mon", $sched->validTerm("mon"));
    $this->assertEquals("tue", $sched->validTerm("tues"));
    $this->assertEquals("all", $sched->validTerm("all"));
    $this->assertFalse($sched->validTerm("blah"));
  }
  public function testAllSingle(){
    $sched = new Schedule;
    $sched->set("all", 100);
    $this->assertEquals(100, $sched->val(new DateTime("0900")));
  }
  public function testSetAll(){
    $sched = new Schedule;
    $sched->set("all", 8, 100);
    $sched->set("all", 18, 20);
    $this->assertEquals(100, $sched->val(new DateTime("0900")));
    $this->assertEquals(20, $sched->val(new DateTime("2000")));
    $this->assertEquals(20, $sched->val(new DateTime("0200")));
  }
  public function testSetWeekend(){
    $sched = new Schedule;
    $sched->set("weekend",100);
    $sched->set("weekday", 20);
    $this->assertEquals(100, $sched->val(new DateTime("2017-01-01")));
    $this->assertEquals(20, $sched->val(new DateTime("2017-01-02")));
  }
  public function testSetDays(){
    $s = array("mon"=>array(20=>100), "tue"=>array(6=>20, 18=>40) );
    $sched = new Schedule($s);
    $this->assertEquals(100, $sched->val(new DateTime("2017-01-03 02:00")));
    $this->assertEquals(20, $sched->val(new DateTime("2017-01-03 08:00")));
    $this->assertEquals(40, $sched->val(new DateTime("2017-01-03 20:00")));
  }
}

