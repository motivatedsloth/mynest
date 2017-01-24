<?php
use PHPUnit\Framework\TestCase;
use constellation\mynest\Heat\Controller;

class ControllerTest extends TestCase{
		function testController(){
          $con = new Controller("constellation\mynest\Heat\Controller\Mock");
          $con->run(1);
          $this->assertEquals(1, $con->status(1));
          $con->stop(1);
          $this->assertEquals(0, $con->status(1));
		}
}

