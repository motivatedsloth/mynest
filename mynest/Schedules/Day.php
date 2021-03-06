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
use DateTime;
use Exception;
use OutOfBoundsException;
use RuntimeException;
use InvalidArgumentException;
/**
 * The schedule for a day
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Day {
  /**
   * time terms we understand
   * @var array
   */
  protected $hour_terms = array(
    "day",
    "night",
    "single"
  );

  /**
   * don't throw error if before time
   * @var bool
   */
  protected $continuous = false;

  /**
   * current schedule
   * @var array
   */
  protected $schedule = array();

  /**
   * set continuous
   * @param bool $cont
   */
  public function continuous(bool $cont){
    $this->continuous = $cont;
  }

  /**
   * add a time and value, 
   * if value is omitted and $time is an array then each key=>value pair is added
   * if value is omitted and $time is not an array then $time is used as a "single" value 
   * @param mixed $time time term, hour, array(time=>val,...) or value
   * @param mixed $value optional value
   */
  public function set($time, $value = null){
    if(is_array($time)){
      foreach($time as $tm=>$val){
        $this->set($tm, $val);
      }
      return $this;
    }
    if(is_null($value)){
      return $this->set("single", $time);
    }
    $tm = $this->validTerm($time);
    if(is_string($tm)){
      $this->schedule[$time] = $value;
    }elseif($tm instanceof DateTime){
      $this->schedule[$tm->format("Hi")] = $value;
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
  public function get(DateTime $date = null){
    return $this->schedule;
  }

  /**
   * get value for given time
   * @param DateTime $date 
   * @throws RuntimeException if both day and night are not set
   * @throws OutOfBoundsException if requested time if before first set
   * @return mixed value
   */
  public function val(DateTime $date){
    if(isset($this->schedule["single"])){
      return $this->schedule["single"];
    }

    //get time as a numeric value
    $tm = $date->format("Gi");

    //check day/night if set
    if(isset($this->schedule["day"]) || isset($this->schedule["night"])){
      if(!(isset($this->schedule['day']) && isset($this->schedule['night']))){
        throw new RuntimeException("Both day and night must be set", 200);
      }
      if($tm < 1800 && $tm > 600){
        return $this->schedule['day'];
      }else{
        return $this->schedule['night'];
      }
    }

    //checking times
    //breakpoints for times
    $breaks = array_keys($this->schedule);
    //put them in order
    sort($breaks);
    //find our slot
    for( $cur = reset($breaks); $nxt = next($breaks); ){
      if(!$this->continuous && $tm < $cur){
        throw new OutOfBoundsException("Requested schedule before first schedule, check previous day", 220);
      }
      if($tm >= $cur && $tm < $nxt){
        break;
      }else{
        $cur = $nxt;
      }
    }
    return $this->schedule[$cur];
  }

  /**
   * get valid hour terms
   */
  static public function getTerms(){
    return $this->hour_terms;
  }

  /**
   * is this a valid term
   * @param string|int $term
   * @return mixed false if not valid term
   */
  public function validTerm($term){
    switch (true){
    case (in_array($term, $this->hour_terms, true) !== false): //string term
      return $term;
    case (array_search($term, range(0,23), true) !== false): //hour only
      $term = str_pad($term, 2, "0", STR_PAD_LEFT). "00";
      break;
    case (preg_match("/\d{3,4}/", $term) && $term <= 2400):
      $term = str_pad($term, 4, "0", STR_PAD_LEFT);
      break;
    default:
      return false;
    }
    try{
      $dt = new DateTime($term);
    }catch(Exception $e){
      $dt = false;
    }
    return $dt;
  }

  /**
   * return array to reconstruct
   * @return array
   */
  public function toArray(){
    return $this->schedule;
  }
}

