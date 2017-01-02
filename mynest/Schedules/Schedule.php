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
    "sun",
    "mon",
    "tue",
    "wed",
    "thu",
    "fri",
    "sat"
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
    $dow = strtolower($date->format("D"));
    $isWeekend = (array_search($dow, $this->weekend) !== false);
    switch (true){
    case (isset($this->days[$dow])):
      return $this->days[$dow]->val($date);
    case ($isWeekend && isset($this->days["weekend"])):
      return $this->days["weekend"]->val($date);
    case (!$isWeekend && isset($this->days["weekday"])):
      return $this->days["weekday"]->val($date);
    case (isset($this->day["all"])):
      return $this->days["all"]->val($date);
    }
    throw new RuntimeException("No value set for this Schedule");
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
    if(array_search($term, $this->day_terms) !== false){
      return $term;
    }
    if(isset($this->aliases[$term])){
      return $this->aliases[$term];
    }
    return false;
  }
}//class
