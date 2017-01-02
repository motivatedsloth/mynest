<?php
/*
 * This file is part of the constellation/mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Schedules;
/**
 * The schedule for a day
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Day {
  /**
   * time terms we understand
   */
  protected $hour_terms = array(
    "day",
    "night",
    "single"
  );

  /**
   * current schedule
   */
  protected $schedule = array();

  /**
   * add a time and value, if value is omitted then $time is used as a "single" value 
   * @param mixed $time time term, hour, or value
   * @param mixed $value optional value
   */
  public function set($time, $value = null){
    if(is_null($value)){
      $this->set("single", $value);
    }
    if($this->validTerm($time)){
      $this->schedule[$time] = $value;
    }else{
      throw new InvalidArgumentException("$time is not a valid time term");
    }
    return $this;
  }

  /**
   * get value for given time, or array of all values
   * @param DateTime $date optional time to find
   * @return array for given day
   */
  public function get(){
    return $this->schedule;
  }

  /**
   * get valid hour terms
   */
  static public function getTerms(){
    return $this->hour_terms;
  }

  /**
   * is this a valid term
   * @param string $term
   */
  public function validTerm($term){
    if(array_search($term, $this->hour_terms) !== false || array_search($term, range(1,24)) !== false){
      return $term;
    }
    return false;
  }
}

