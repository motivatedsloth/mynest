<?php

/*
 * This file is part of the constellation\mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Heat\Source;

/**
 * a controllable heat source
 * construct with array('startup'=>30, 'cycle'=>60, 'rise'=>50)
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Controllable{

  /**
   * @var int startup time in minutes
   */
  protected $startup;

  /**
   * @var int cycle time in minutes
   */
  protected $cycle;

  /**
   * @var int degrees rise
   */
  protected $rise;

  /**
   * @var int offset in minutes
   */
  protected $offset = 0;

  /**
   * @param array array('startup'=>1, 'cycle'=>60, 'rise'=>50)
   */
  public function __construct(array $props){
    $this->setStartUp($props['startup']);
    $this->setCycle($props['cycle']);
    $this->setRise($props['rise']);
    if(isset($props['offset'])){
      $this->offset = $props['offset'];
    }
  }

  /**
   * set startup time in seconds
   * @param int seconds to start up unit
   * @return Controllable $this
   */
  public function setStartUp($startup){
    $this->startup = $startup;
    return $this;
  }

  /**
   * startup time in seconds
   * @return int seconds to start up unit
   */
  public function getStartUp(){
    return $this->startup;
  }

  /**
   * set cycle time in minutes
   * @param int cycle time
   * @return Controllable $this
   */
  public function setCycle($cycle){
    $this->cycle = $cycle;
    return $this;
  }

  /**
   * cycle time in minutes
   * @return int cycle time
   */
  public function getCycle(){
    return $this->cycle;
  }

  /**
   * set degrees rise unit is capable of
   * @param int degrees
   * @return Controllable $this
   */
  public function setRise($rise){
    $this->rise = $rise;
    return $this;
  }

  /**
   * degrees rise unit is capable of
   * @return int degrees
   */
  public function getRise(){
    return $this->rise;
  }

  /**
   * set offset
   * @param int minutes
   * @return Controllable $this
   */
  public function setOffset($offset){
    $this->offset = $offset;
    return $this;
  }

  /**
   * minutes of offset
   * @return int minutes
   */
  public function getOffset(){
    return $this->offset;
  }

  /**
   * array to save and recreate
   */
  public function toArray(){
    return array(
      "rise"=>$this->rise,
      "cycle"=>$this->cycle,
      "offset"=>$this->offset,
      "startup"=>$this->startup
    );
  }
}

