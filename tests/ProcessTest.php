<?php
use PHPUnit\Framework\TestCase;
use constellation\mynest\Config;
use constellation\mynest\Heat\Zones\Process;
use constellation\mynest\Heat\Zones\Zone;

class ProcessTest extends TestCase{
  function testCycle(){
    $z = array("zone"=> 1,
      "source"=> array( "startup="> 1, "cycle"=> 60, "rise"=> 40, "offset"=> 180 ),
      "schedule"=> array( "all"=> array( 8=> 65, 22=> 60 ) )
    );                        
    $zone = new Zone($z);
    $cyc = Process::cycle($zone);
    $this->assertEquals(60, $cyc->length());
  }
}

