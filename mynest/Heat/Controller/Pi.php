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
use constellation\mynest\Heat\Zone\Zone;
use constellation\mynest\Heat\Controller\Pi\Gpio;

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
   * @var Gpio 
   */
  protected $gpio;

  /**
   * @param Gpio $gpio
   */
  public function __construct(){
    $this->gpio = new Gpio;
  }
  /**
   * make sure zone is exported
   * @param int $pin
   * @return Gpio 
   */
  protected function init($pin){
    if(!$this->gpio->isExported($pin)){
      $this->gpio->setup($pin, "out");
    }
    return $this->gpio;
  }

  /**
   * @param Zone $zone
   * @return Pi $this
   */
  public function stop(Zone $zone){
    $pin = $this->mapping[$zone->getZone()];
    $this->init($pin)->output($pin, 0);
    return $this;
  }

  /**
   * @param Zone $zone
   * @return Pi $this
   */
  public function run(Zone $zone){
    $pin = $this->mapping[$zone->getZone()];
   $this->init($pin)->output($pin, 1);
    return $this;
  }

  /**
   * current status of this zone
   * @param Zone $zone
   * @return int 0 or 1
   */
  public function status(Zone $zone){
    $pin = $this->mapping[$zone->getZone()];
    return $this->init($pin)->status($pin);
  }
}

