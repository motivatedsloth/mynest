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
use constellation\mynest\Cache;
use constellation\mynest\Heat\Zones;
use constellation\mynest\Heat\Zones\Zone;
use constellation\mynest\Heat\Cycles;
use constellation\mynest\Heat\Cycles\Cycle;
use constellation\mynest\Heat\Zones\Process;
use constellation\mynest\Heat\Controller;

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
   * @param Config $config optional configuration
   */
  public function __construct(Config $config = null){
    if(is_null($config)){
      $config = new Config;
    }
    $this->config = $config;
    $this->controller(new Controller($config->get("controller")));
    $this->zones = new Zones($config->get("zones"));
    $this->cycles = new Cycles(new Cache($config->get("cache")));
  }

  /**
   * run all zones
   *
   * @return Nest $this
   */
  public function run(){
    foreach($this->zones as $zone){
      $this->cycle($zone);
    }
    $this->apply();
    return $this;
  }

  /**
   * apply current cycles status
   *
   * @return Nest $this
   */
  public function apply(){
    foreach($this->cycles as $zone=>$cycle){
      $action = $cycle->status() == "on" ? "run" : "stop";
      $this->controller->$action($zone);
    }
    return $this;
  }

  /**
   * set supplied zone
   *
   * @param Zone $zone
   * @return Nest $this
   */
  public function setZone(Zone $zone){
    $this->zones->set($zone);
    return $this;
  }

  /**
   * get zone object for the requested zone number.
   *
   * @param int $zone zone number 
   * @return Zone 
   */
  public function getZone(int $zone){
    return $this->zones->get($zone);
  }

  /**
   * set Cycle for provided Zone
   * @param int $zone
   * @param Cycle $cycle
   * @return Nest $this
   */
  public function setCycle(int $zone, Cycle $cycle){
    $this->cycles->set($zone, $cycle);
    $this->cycles->save();
    return $this;
  }

  /**
   * get current cycle for this zone
   *
   * @param int $zone zone number 
   * @return Cycle
   */
  public function getCycle(int $zone){
    $this->cycles($this->zones->get($zone));
    return $this->cycles->get($zone);
  }

  /**
   * get member objects
   * @param string $what "controller", "zones", "cycles"
   */
  public function get($what){
    switch( $what){
    case "controller":
      return $this->controller;
      break;
    case "zones":
      return $this->zones;
      break;
    case "cycles":
      return $this->cycles;
      break;
    default:
      return false;
    }}

  /**
   * make sure a cycle is set up for zone
   * @param Zone $zone
   * @return bool true if a new cycle was created
   */
  protected function cycle(Zone $zone){
    if(!$this->cycles->get($zone)){
      $this->cycles->set($zone->getZone(), Process::cycle($zone));
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

