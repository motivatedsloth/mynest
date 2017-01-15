<?php
/*
 * This file is part of the constellation\mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest;
use constellation\mynest\Config;
use constellation\mynest\Heat\Cycles\Storage;
use constellation\mynest\Heat\Zones\Zones;
use constellation\mynest\Heat\Zones\Process;
use constellation\mynest\Heat\Controller\Controller;

/**
 * main nest class
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Nest {

  /**
   * current configuration
   * @var Config $config
   */
  protected $config;

  /**
   * our zones
   * @var Zones $zones
   */
  protected $zones;

  /**
   * our cycles
   * @var Cycles $cycles
   */
  protected $cycles;

  /**
   * our controller instance
   * @var Controller $controller
   */
  protected $controller;
  
  /**
   * cycle storage
   * @var Storage $storage
   */
  protected $storage;

  /**
   * @param Config $config
   */
  public function __construct(Config $config){
    $this->config = $config;
    $controller = $config->get("controller");
    $this->controller(new $controller);
    $this->zones = new Zones($config->get("zones"));
    $storage = new Storage;
    $this->cycles = $storage->open();
  }

  public function run(){
    $updated = false;
    foreach($this->zones as $zone){
      $updated = $this->cycle($zone) || $updated;;
    }
    if($updated){
      $this->storage->save($this->cycles);
    }
  }

  /**
   * make sure a cycle is set up for each zone
   * @return bool true if a new cycle was created
   */
  protected function cycle(Zone $zone){
   $cycle = $this->cycles->get($zone); 
      if(!$cycle){
        $cycle = Process::cycle($zone);
        $this->cycles->set($zone, Process::cycle($zone));
        return true;
      }
      return false;
  }

  /**
   * set our controller
   * @param Controller $controller
   * @return Nest
   */
  protected function controller(Controller $controller){
    $this->controller = $controller;
  }
}

