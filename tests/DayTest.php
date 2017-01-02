<?php
use PHPUnit\Framework\TestCase;
use constellation\mynest\Schedules\Day;

class DayTest extends TestCase{
		public function testValidTerm(){
				$sched = new Day();
                $this->assertEquals("8", $sched->validTerm("8"));
                $this->assertEquals("day", $sched->validTerm("day"));
                $this->assertFalse($sched->validTerm("blah"));
                $this->assertFalse($sched->validTerm("26"));
		}
}

