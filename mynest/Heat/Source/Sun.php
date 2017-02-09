<?php

/*
 * This file is part of the constellation/mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Heat\Source;
use constellation\mynest\Heat\Source\HeatSource;
use constellation\mynest\Weather\Weather;
use DateTime;

/**
 * class describing Sun
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Sun extends HeatSource {
  public function rise(DateTime $time){
    switch(Weather::weather($time)->getShortForecast()){
    case "Mostly Sunny":
    case "Sunny":
      $mult = 1;
      break;
    case "Partly Sunny":
      $mult = 0.5;
      break;
    default:
      $mult = 0;
    }
    return parent::rise($time) * $mult;
  }
}

