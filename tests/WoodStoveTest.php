<?php
use PHPUnit\Framework\TestCase;
use constellation\mynest\Heat\Source\WoodStove;

class WoodStoveTest extends TestCase{
		public function testTempRise(){
				$stove = new WoodStove(array(8=>50, 19=>20));
				$this->assertEquals(20, $stove->rise(new \DateTime("2016-12-29 07:00")));
				$this->assertEquals(50, $stove->rise(new \DateTime("2016-12-29 08:00")));
				$this->assertEquals(50, $stove->rise(new \DateTime("2016-12-29 09:00")));
				$this->assertEquals(20, $stove->rise(new \DateTime("2016-12-29 19:00")));
				$this->assertEquals(20, $stove->rise(new \DateTime("2016-12-29 22:00")));
				$stove = new WoodStove(40);
				$this->assertEquals(40, $stove->rise(new \DateTime("2016-12-29 22:00")));
		}
}

