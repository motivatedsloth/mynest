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
use constellation\mynest\Config;
use constellation\mynest\Weather\Weather;
use constellation\mynest\Heat\Zones\Zone;
use constellation\mynest\Heat\Sources;
use constellation\mynest\Heat\Cycles\Cycle;
use DateTime;
use DateInterval;

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

  /**
   * Create a cycle for supplied Zone
   * @param Zone $zone
   * @return Cycle 
   */
  static public function cycle(Zone $zone){
    $cycle = new Cycle;
    $cycle->source("process");
    $controllable = $zone->getHeatSource();
    $cycle->length(new DateInterval("PT{$controllable->getCycle()}M"));
    $run = self::runtime($zone, $cycle);
    $cycle->duration(new DateInterval("PT{$run}M"));
    return $cycle;
  }
  

  /**
   * calculate runtime
   * @param Zone $zone
   * @param Cycle $cycle
   * @return int runtime in minutes
   */
  static protected function runtime(Zone $zone, Cycle $cycle){
    $remaining = self::load($zone, $cycle) - self::sources($zone, $cycle);
    $cycle->params("remaining", $remaining);
    if($remaining <= 0){
      return 0;
    }
    $controllable = $zone->getHeatSource();
    $percent = $remaining / $controllable->getRise();
    return ceil($percent * $controllable->getCycle()) + $controllable->getStartUp();
  }

  /**
   * temp difference from inside to outside
   * total heat load
   * @param Zone $zone
   * @param Cycle $cycle
   * @return float temp in degrees F
   */
  static protected function load(Zone $zone, Cycle $cycle){
    $time = self::when($zone);
    $inside = $zone->val($time);
    $cycle->params("inside", $inside);
    $outside = self::outside($time);
    $cycle->params("outside", $outside);
    return $inside - $outside;
  }

  /**
   * get outside temp
   * @param DateTime $time
   * @return float temp in degrees F
   */
  static protected function outside(DateTime $time){
      return Weather::weather($time)->getTemperature();
  }

  /**
   * what time to plan for
   * @param Zone $zone
   * @return DateTime time now + offset
   */
  static protected function when(Zone $zone){
    $time = new DateTime;
    $time->add(new DateInterval("PT{$zone->getHeatSource()->getOffset()}M"));
    return $time;
  }

  /**
   * get rise from static sources
   * @param Zone $zone
   * @param Cycle $cycle
   * @return float rise in degrees F
   */
  static protected function sources(Zone $zone){
    $date = self::when($zone);
    $sources = new Sources(Config::get('sources'));
    $rise = 0;
    foreach($sources->get() as $source){
      $rise += $source->rise($date);
    }
    $cycle->params("other_sources", $rise);
    return $rise;
  }
}

