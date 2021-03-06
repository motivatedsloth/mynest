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
use constellation\mynest\Heat\Zones\Zone;
use ArrayObject;
use ArrayIterator;

/**
 * manage multiple zones
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Zones extends ArrayObject{

  /**
   * our zone objects
   * @var array
   */
  protected $zones;

  /**
   * @param array to configure zones
   */
  public function __construct(array $zones = array()){
    foreach($zones as $zone){
      $this->zones[$zone['zone']] = new Zone($zone);
    }
  }

  /**
   * set a zone
   *
   * @param Zone $zone
   * @return Zones
   */
  public function set(Zone $zone){
    $this->zones[$zone->getZone()] = $zone;
    return $this;
  }

  /**
   * get a Zone
   *
   * @param int $num zone number
   * @return Zone
   * @throws Exception if zone does not exist
   */
  public function get(int $num){
    if(!isset($this->zones[$num])){
      throw new Exception("Zone number $num does not exist");
    }
    return $this->zones[$num];
  }

  /**
   * array appropriate for __construct
   * @return array
   */
  public function toArray(){
    $ret = array();
    foreach($this->zones as $num=>$zone){
      $ret[$num] = $zone->toArray();
    }
    return $ret;
  }

  public function getIterator(){
    return new ArrayIterator($this->zones);
  }
}

