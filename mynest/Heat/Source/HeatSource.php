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
use constellation\mynest\Schedules\Schedule;
use DateTime;

/**
 * base heat source class
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class HeatSource{
  /**
   * schedule for this source
   * @var mixed 
   */
  protected $schedule;

  /**
   * runs in away mode?
   * @var bool 
   */
  protected $away = true;

  public function __construct($schedule = null){
    if(is_array($schedule)){
      $this->schedule = new Schedule($schedule);
    }elseif(!is_null($schedule)){
      $this->schedule = $schedule;
    }
  }

  /**
   * set the schedule
   * @param Schedule $schedule 
   * @return HeatSource
   */
  public function setSchedule($schedule){
    $this->schedule = $schedule;
    return $this;
  }

  /**
   * temp rise capacity at given time
   * @param DateTime $date
   * @return int|float value
   */
  public function rise(DateTime $date){
    if($this->schedule instanceof Schedule){
      return $this->schedule->val($date);
    }else{
      return $this->schedule;
    }
  }

  /**
   * runs when away?
   * @return bool
   */
  public function inAway(){
    return $this->away;
  }
}

