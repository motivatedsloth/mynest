<?php

/*
 * This file is part of the constellation\mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Weather;
use noaa\NOAA;
use noaa\util\Cache;
use noaa\Point;
use noaa\ForecastPeriod;
use noaa\Observation;

use constellation\mynest\Config;

use DateTime;

/**
 * Weather
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Weather {
  /**
   * @var NOAA
   */
  static protected $noaa;

  /**
   * get noaa object
   * @return NOAA
   */
  static protected function noaa(){
    if(!isset(self::$noaa)){
      self::$noaa = new NOAA(self::cache());
      $point = Config::get("point");
      self::$noaa->setPoint(new Point($point['lat'], $point['lon']));
    }
    return self::$noaa;
  }

  /**
   * set up NOAA Cache object
   * @return Cache
   */
  static protected function cache(){
    $dir = Config::get("cache");
    if(substr($dir, 0 , 1) != "/"){
      $dir = dirname(dirname(__DIR__)) . "/" . $dir;
    }
    return new Cache($dir);
  }

  /**
   * get weather for specified interval, if no interval is provided get current
   * @return ForecastPeriod|Observation
   */
  static public function weather(DateTime $date = null){
    if(is_null($date)){
      return self::noaa()->getObservations()[0];
    }else{
      $forecasts = self::noaa()->getHourlyForecast();
      foreach($forecasts as $forecast){
        if($forecast->getStart() <= $date && $forecast->getEnd() > $date){
          return $forecast;
        }
      }
    }
  }
}

