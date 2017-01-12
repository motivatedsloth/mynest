<?php
/*
 * This file is part of the constellation\mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Heat\Zones;
use noaa\util\Cache;
use noaa\NOAA;
use constellation\mynest\Heat\Zones\Zone;

/**
 * cycle creator for heat zones
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Process {

  /**
   * our noaa object to fetch conditions
   */
  static protected $noaa;

  static public function create(Zone $zone){
    
  }

  static public function noaa(){
    if(!isset(self::$noaa)){
      self::$noaa = new NOAA;
    }
  }
}

