<?php
/*
 * This file is part of the constellation\mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Heat\Cycles;
use constellation\mynest\Heat\Zones\Zone;
use constellation\mynest\Heat\Cycles\Cycle;

/**
 * manage cycles for all zones
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Cycles {

  /**
   * our cycle objects
   * @var array
   */
  protected $cycles;

  /**
   * @param array to configure cycles
   */
  public function __construct(array $cycles = array()){
    foreach($cycles as $zone=>$cycle){
      $this->cycles[$zone] = new Cycle($cycle);
    }
  }

  /**
   * set cycle for given zone
   * @param Zone $zone
   * @param Cycle $cycle
   * @return Cycles
   */
  public function set(Zone $zone, Cycle $cycle){
    $this->cycles[$zone->getZone()] = $cycle;
    return $this;
  }

  /**
   * get cycle for provided zone
   * @param Zone $zone
   * @return Cycle|bool false is Cycle is done
   */
  public function get(Zone $zone){
    $num = $zone->getZone();
    if(isset($this->cycles[$num])){
      if($this->cycles[$num]->status() == "done"){
        unset($this->cycles[$num]);
        return false;
      }
      return $this->cycles[$num];
    }
    return false;
  }

  /**
   * array appropriate for __construct
   * @return array
   */
  public function toArray(){
    $ret = array();
    foreach($this->cycles as $zone=>$cycle){
      $ret[$zone] = $cycle->toArray();
    }
    return $ret;
  }
}

