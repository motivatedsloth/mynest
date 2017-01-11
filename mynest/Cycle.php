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
use DateTime;
use DateInterval;
use constellation\mynest\Heat\Zone\Zone;
/**
 * a heat cycle
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Cycle {
  /**
   * start time
   * @var DateTime $start;
   */
  protected $start;
  /**
   * cycle duration, calculated duration
   * @var DateInterval $duration
   */
  protected $duration;
  /**
   * what zone?
   * @var Zone $zone
   */
  protected $zone;

  /**
   * set/get start time
   */
  public function start(DateTime $start = null){
    if($start){
      $this->start = $start;
      return $this;
    }else{
      return $this->start;
    }
  }
}

