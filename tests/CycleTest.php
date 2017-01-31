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
use constellation\mynest\Heat\Cycles\Cycle;

/**
 * test class for Cycle object
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class CycleTest extends TestCase {
  public function testToArray(){
    $arr = array(
      "start"=>"2017-01-11T11:00:00-0600",
      "length"=>"PT60M",
      "duration"=>"PT30M",
      "source"=>"test",
      "params"=>array("param1"=>1)
    );
    $cyc = new Cycle($arr);
    $ret = $cyc->toArray();
    $this->assertEquals($ret['start'], $arr['start']);
    $this->assertEquals($ret['duration'], $arr['duration']);
    $this->assertEquals($ret['length'], $arr['length']);
    $this->assertEquals($ret['source'], "test");
    $this->assertEquals($ret['params']['param1'], 1);
    return $cyc;
  }
  public function testStatus(){
    $cyc = new Cycle();
    //pretend we started 10 minutes ago
    $start = new DateTime();
    $start->sub(new DateInterval("PT10M"));
    $cyc->start($start);
    $cyc->length(new DateInterval("PT15M"));

    $cyc->duration(new DateInterval("PT12M"));
    $this->assertEquals("on", $cyc->status());

    $cyc->duration(new DateInterval("PT8M"));
    $this->assertEquals("off", $cyc->status());

    $cyc->length(new DateInterval("PT9M"));
    $this->assertEquals("done", $cyc->status());
  }
}

