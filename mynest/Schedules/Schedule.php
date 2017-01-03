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
use DateTime;

/**
 * set a schedule
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Schedule {
  /**
   * Terms that we accept and understand
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

  /**
   * get valid day terms
   */
  public static function getTerms(){
    return self::$day_terms;
  }

  /**
   * add a time and value to a day
   * @param string $day day term we are adding to
   * @param string|number $time time term or time
   * @param mixed $value optional value
   */
  public function add($day, $time, $value = null){
    $this->day($day)->set($time, $value);
    return $this;
  }

  /**
   * get the value for provided DateTime
   * @param DateTime $date
   * @throws RuntimeException if unable to find val
   */
  public function val(DateTime $date){

    if(isset($this->day["all"])){
      return $this->days["all"]->val($date);
    }

    if(isset($this->days["weekend"]) || isset($this->days["weekday"])){
      if(!(isset($this->days["weekend"]) && isset($this->days["weekday"]))){
        throw new RuntimeException("weekend and weekday must both be set", 199);
      }
      if(array_search($dow, $this->weekend) !== false){
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
        return $this->days[$dow]->val($date);
      }catch(Exception $e){
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
    if(!isset($this->days[$day]) && $term = $this->validTerm($day)){
      $this->days[$term] = new Day;
    }else{
      throw new InvalidArgumentException("$day is not a valid day term");
    }
    return $this->days[$day];
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
