<?php
use PHPUnit\Framework\TestCase;
use constellation\mynest\Cache;

class CacheTest extends TestCase{
  public function __construct(){
    @unlink("cache/test.yml");
  }
  function testSave(){
    $cache = new Cache;
    $data = array("hello"=>"world");
    $cache->save("test", $data);
    $this->assertFileExists("cache/test.yml");
    return $cache;
  }

  /**
   * @depends testSave
   */
  function testOpen($cache){
    $data = $cache->open("test");
    $this->assertEquals($data['hello'], 'world');
  }

  public function __destruct(){
    @unlink("cache/test.yml");
  }
}

