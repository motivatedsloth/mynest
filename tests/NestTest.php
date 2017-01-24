<?php
use PHPUnit\Framework\TestCase;
use constellation\mynest\Nest;

class NestTest extends TestCase{
  function build(){
          $config = new Config('tests/config/config.yml');
          $nest = new Nest($config);
          return $nest;
  }
		function testSet(){
          $nest = $this->build();
          
		}
}

