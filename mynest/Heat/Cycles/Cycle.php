<?php
/*
 * This file is part of the constellation\mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Heat\Cycles;
use DateTime;
use DateInterval;

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
   * cycle duration, calculated runtime
   * @var DateInterval $duration
   */
  protected $duration;

  /**
   * cycle length
   * @var DateInterval $length;
   */
  protected $length;

  /**
   * what created this cycle
   * @var string "process", "manual"
   */
  protected $source;

  /**
   * additional parameters
   * @var array
   */
  protected $params = array();
  /**
   * @param array optional array to set up cycle
   */
  public function __construct(array $cyc = null){
    if($cyc){
      $this->start(new DateTime($cyc['start']));
      $this->duration(new DateInterval($cyc['duration']));
      $this->length(new DateInterval($cyc['length']));
      $this->source = $cyc['source'];
      $this->params = $cyc['params'];
    }else{
      $this->start = new DateTime();
    }
  }

  /**
   * cycle status
   * @return string "done", "on", or "off"
   */
  public function status(){
    if($this->timesUp($this->length)){
      return "done";
    }elseif($this->timesUp($this->duration)){
      return "off";
    }
    return "on";
  }

  /**
   * @param DateInterval $interval
   * @return bool 
   */
  protected function timesUp(DateInterval $interval){
    $now = new DateTime();
    $now->sub($interval);
    return $now >= $this->start;
  }

  /**
   * set/get start time
   *
   * @param DateTime $start optional start time
   * @return DateTime|Cycle 
   */
  public function start(DateTime $start = null){
    if($start){
      $this->start = $start;
      return $this;
    }else{
      return $this->start;
    }
  }

  /**
   * set/get cycle length
   * this is the length of the entire cycle
   * @param DateInterval $len
   * @return DateInterval|Cycle
   */
  public function length(DateInterval $len = null){
    if($len){
      $this->length = $len;
      return $this;
    }else{
      return $this->length;
    }
  }

  /**
   * set/get cycle duration
   * this is the calculated run time
   * @param DateInterval $len
   * @return DateInterval|Cycle
   */
  public function duration(DateInterval $len = null){
    if($len){
      $this->duration = $len;
      return $this;
    }else{
      return $this->duration;
    }
  }


  /**
   * set/get cycle source
   * @param string $source "process", "manual"
   * @return string|Cycle
   */
  public function source($source = ""){
    if($source){
      $this->source = (string) $source;
      return $this;
    }else{
      return $this->source;
    }
  }

  /**
   * get/set parameters
   * calling without any arguments returns params array
   *
   * @param string $name optional
   * @param mixed $value optional
   * @return array|Cycle
   */
  public function params($name = null, $value = null){
    if($name){
      $this->params[$name] = $value;
      return $this;
    }else{
      return $this->params;
    }
  }

  /**
   * an array to save
   * @return array
   */
  public function toArray(){
    $ret = array(
      "start"=>$this->start->format(DateTime::ISO8601),
      "duration"=>$this->duration->format("PT%iM"),
      "length"=>$this->length->format("PT%iM"),
      "source"=>$this->source,
      "params"=>$this->params
    );
    return $ret;
  }
}

