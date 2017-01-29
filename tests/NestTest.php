<?php
use PHPUnit\Framework\TestCase;
use constellation\mynest\Config;
use constellation\mynest\Nest;
use constellation\mynest\Heat\Cycles\Cycle;

class NestTest extends TestCase{
  function build(){
    $nest = new Nest('tests/config/config.yml');
    return $nest;
  }
  function testSetCycle(){
    $nest = $this->build();
    $cycle = new Cycle;
    $cycle->length(new DateInterval("PT10M"))->duration(new DateInterval("PT4M"));
    $nest->setCycle(1, $cycle);
    $cur = $nest->getCycle(1);
    $arr = $cur->toArray();
    $this->assertEquals("PT10M", $arr['length']);
    $nest->apply();
    $cont = $nest->get("controller");
    $this->assertEquals(1, $cont->status(1));
  }
  function testGetCycle(){
    $nest = $this->build();
    $cyc = $nest->getCycle(1);
    $arr = $cyc->toArray();
    $this->assertArrayHasKey("duration", $arr);
  }
}

