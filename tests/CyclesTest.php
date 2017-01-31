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
use constellation\mynest\Cache;
use constellation\mynest\Heat\Cycles;
use constellation\mynest\Heat\Cycles\Cycle;

/**
 * test class for Cycles object
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class CyclesTest extends TestCase {
  public function testCycles(){
    @unlink('tests/cache/cycles.yml');
    $start = new \DateTime();
    $arr = array(
      "start"=>$start->format(\DateTime::ISO8601),
      "length"=>"PT60M",
      "duration"=>"PT30M",
      "source"=>"test",
      "params"=>array("param1"=>1)
    );
    $cycle1 = new Cycle($arr);
    $arr['start'] = "2017-01-01T10:00";
    $cycle2 = new Cycle($arr);

    $cycles = new Cycles(new Cache('tests/cache'));
    $cycles->set(1, $cycle1);
    $cycles->set(2, $cycle2);
    $cycles->save();

    $this->assertEquals($cycle1, $cycles->get(1));
    $this->assertFalse($cycles->get(2));
    
    $exp = $cycles->toArray();
    $this->assertEquals($exp[1]['start'], $start->format(\DateTime::ISO8601));

    $this->assertFileExists("tests/cache/cycles.yml");
  }
}

