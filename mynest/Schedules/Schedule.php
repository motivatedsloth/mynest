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
use constellation\mynest\Schedules\Day;
use InvalidArgumentException;
use RuntimeException;
use OutOfBoundsException;
use DateTime;

/**
 * set a schedule
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Schedule {
  /**
   * @var array $day_terms Terms that we accept and understand
   */
  protected $day_terms = array(
    "all",
    "weekday",
    "weekend",
  );

  /**
   * aliases for terms
   * @var array $aliases
   */
  protected $aliases = array(
    "tues"=>"tue",
    "thur"=>"thu",
  );

  /**
   * what days are a weekend
   * @var array $weekend
   */
  protected $weekend = array(
    "sat", 
    "sun"
  );
  /**
   * what days are weekdays
   */
  protected $weekdays = array(
    "mon",
    "tue",
    "wed",
    "thu",
    "fri"
  );

  /**
   * Our schedule, an array of mynest\Schedules\Day objects
   * @var array $days 
   */
  protected $days;

  public function __construct($schedule = null){
    if(is_array($schedule)){
      reset($schedule);
      if($this->validTerm(key($schedule))){
        foreach($schedule as $term=>$val){
          $this->set($term, $val);
        }
      }else{
        $this->set("all", $schedule);
      }
    }
  }
  
  /**
   * get valid day terms
   * @return array of day terms 
   */
  public static function getTerms(){
    return self::$day_terms;
  }

  /**
   * add a time and value to a day
   * @param string $day day term we are adding to
   * @param string|number|array $time time term or time or array(time->value, ...)
   * @param mixed $value optional value
   */
  public function set($day, $time, $value = null){
    $this->day($day)->set($time, $value);
    return $this;
  }

  /**
   * get the value for provided DateTime
   * @param DateTime $date
   * @throws RuntimeException if unable to find val
   */
  public function val(DateTime $date){

    if(isset($this->days["all"])){
      return $this->days["all"]->val($date);
    }

    if(isset($this->days["weekend"]) || isset($this->days["weekday"])){
      if(!(isset($this->days["weekend"]) && isset($this->days["weekday"]))){
        throw new RuntimeException("weekend and weekday must both be set", 199);
      }
      if(array_search(strtolower($date->format("D")), $this->weekend) !== false){
        return $this->days["weekend"]->val($date);
      }else{
        return $this->days["weekday"]->val($date);
      }
    }

    return $this->dayValue($date);
    
    throw new RuntimeException("No value set for this Schedule");
  }

  /**
   * find days value
   * @param DateTime $date
   * @throws RuntimeException on failure
   * @return mixed value
   */
  public function dayValue(DateTime $date){
    $dow = strtolower($date->format("D"));
    $days = array_reverse(array_merge($this->weekend, $this->weekdays));
    $days = array_merge(array_splice($days, array_search($dow, $days)), $days);
    foreach($days as $dow){
      try{
        $val = $this->days[$dow]->val($date);
        return $val;
      }catch(OutOfBoundsException $e){
      }
    }
    throw new RuntimeException("No Value Found for $date");
  }

  /**
   * get a day
   * @param string $day
   * @throws InvalidArgumentException on an invalid day
   * @return Day $day
   */
  protected function day($day){
    if(!$term = $this->validTerm($day)){
      throw new InvalidArgumentException("$day is not a valid day term");
    }
    if(!isset($this->days[$term])){
      $this->days[$term] = new Day;
      if($term == "all"){
        $this->days["all"]->continuous(true);
      }
    }

    return $this->days[$term];
  }

  /**
   * is this a valid term
   * @param string $term
   */
  public function validTerm($term){
    $allTerms = array_merge($this->day_terms, $this->weekend, $this->weekdays);
    if(array_search($term, $allTerms) !== false){
      return $term;
    }
    if(isset($this->aliases[$term])){
      return $this->aliases[$term];
    }
    return false;
  }
}//class
