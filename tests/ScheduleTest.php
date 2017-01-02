<?php
use PHPUnit\Framework\TestCase;
use constellation\mynest\Schedules\Schedule;

class ScheduleTest extends TestCase{
		public function testValidTerm(){
				$sched = new Schedule();
                $this->assertEquals("mon", $sched->validTerm("mon"));
                $this->assertEquals("tue", $sched->validTerm("tues"));
                $this->assertFalse($sched->validTerm("blah"));
		}
}

