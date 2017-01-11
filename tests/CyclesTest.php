<?php
/*
 * This file is part of the constellation\mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit\Framework\TestCase;
use constellation\mynest\Config;
use constellation\mynest\Cycles\Cycles;
use constellation\mynest\Cycles\Cycle;
use constellation\mynest\Heat\Zones\Zone;

/**
 * test class for Cycles object
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class CyclesTest extends TestCase {
  public function testCycles(){
    $zn = array(
      "zone"=>1,
      "source"=>array("startup"=>30, "cycle"=>60, "rise"=>50),
      "schedule"=>array("all"=>array("8"=>65, "22"=>60))
    );
    $zone1 = new Zone($zn);
    $zn['zone'] = 2;
    $zone2 = new Zone($zn);

    $start = new \DateTime();
    $arr = array(
      "start"=>$start->format(\DateTime::ISO8601),
      "length"=>"PT60M",
      "duration"=>"PT30M"
    );
    $cycle1 = new Cycle($arr);
    $arr['start'] = "2017-01-01T10:00";
    $cycle2 = new Cycle($arr);

    $cycles = new Cycles();
    $cycles->set($zone1, $cycle1);
    $cycles->set($zone2, $cycle2);

    $this->assertEquals($cycle1, $cycles->get($zone1));
    $this->assertFalse($cycles->get($zone2));
    
    $exp = $cycles->toArray();
    $this->assertEquals($exp[1]['start'], $start->format(\DateTime::ISO8601));
  }
}

