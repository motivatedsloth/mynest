<?php
/*
 * This file is part of the constellation\mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Heat;
use constellation\mynest\Cache;
use constellation\mynest\Heat\Cycles\Cycle;
use ArrayObject;
use ArrayIterator;

/**
 * manage cycles for all zones
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Cycles extends ArrayObject{

  /**
   * our cycle objects
   * @var array
   */
  protected $cycles = array();

  /**
   * our cache
   * @var Cache $cache
   */
  protected $cache;

  /**
   * updated flag
   * @var bool
   */
  protected $updated = false;

  /**
   * @param Cache $cache
   */
  public function __construct(Cache $cache){
    $this->cache = $cache;
    @$cycles = $cache->open("cycles");
    if($cycles){
      foreach($cycles as $zone=>$cycle){
        $this->cycles[$zone] = new Cycle($cycle);
      }
    }
  }

  /**
   * set cycle for given zone
   * @param int $zone
   * @param Cycle $cycle
   * @return Cycles
   */
  public function set(int $zone, Cycle $cycle){
    $this->cycles[$zone] = $cycle;
    $this->updated = true;
    return $this;
  }

  /**
   * get cycle for provided zone
   * @param int $zone
   * @return Cycle|bool false if Cycle is done
   */
  public function get(int $zone){
    if(isset($this->cycles[$zone])){
      if($this->cycles[$zone]->status() == "done"){
        unset($this->cycles[$zone]);
        return false;
      }
      return $this->cycles[$zone];
    }
    return false;
  }

  /**
   * save current cycles if updated
   */
  public function save(){
    if($this->updated){
      $this->cache->save("cycles", $this->toArray());
      $this->updated = false;
    }
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

  public function getIterator(){
    return new ArrayIterator($this->cycles);
  }
}

