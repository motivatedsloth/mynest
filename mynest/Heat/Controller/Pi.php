<?php

/*
 * This file is part of the constellation/mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Heat\Controller;
use Calcinai\PHPi\Factory;
use Calcinai\PHPi\Pin;
use Calcinai\PHPi\Board;
use Calcinai\PHPi\Pin\PinFunction;

/**
 * class to work with a pi controller
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Pi implements Controller {

  /**
   * mapping pin numbers to zones
   * @var array $mapping
   */
  protected $mapping = array(1=>17, 2=>27, 3=>22);

  /**
   * @var array of pins
   */
  protected $pins = array();

  /**
   * @var Board $board;
   */
  protected $board;

  /**
   *
   */
  public function __construct(){
    $this->board = Factory::Create();
  }

  /**
   * get pin for zone
   * @param int $zone
   * @return Pin 
   */
  protected function pin(int $zone){
    if(!$this->validZone($zone)){
      throw new RuntimeException("Zone number $zone is not a valid zone");
    }elseif(!isset($pins[$zone])){
      $pins[$zone] = $this->board->getPin($this->mapping[$zone]);
      $pins[$zone]->setFunction(PinFunction::OUTPUT);
    }
    return $pins[$zone];
  }

  /**
   * check zone
   * @param int $zone
   * @return bool
   */
  protected function validZone($zone){
    return isset($this->mapping[$zone]);
  }

  /**
   * @param int $zone
   * @return Pi $this
   */
  public function stop(int $zone){
    $this->pin($zone)->low();
    return $this;
  }

  /**
   * @param int $zone
   * @return Pi $this
   */
  public function run(int $zone){
    $this->pin($zone)->high();
    return $this;
  }

  /**
   * current status of this zone
   * @param int $zone
   * @return int 0 or 1
   */
  public function status(int $zone){
    return $this->pin($zone)->getLevel();
  }
}

