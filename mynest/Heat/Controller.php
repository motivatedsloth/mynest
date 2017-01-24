<?php
/*
 * This file is part of the constellation\mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Heat;
use constellation\mynest\Heat\Controller\Controller as HardwareController;

/**
 * Controller master
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Controller {

  /**
   * our hardware controller
   * @var HardwareController $controller; 
   */
  protected $controller;

  /**
   * @param string full class name of hardware controller
   */
  public function __construct($class){
    $this->setController(new $class);
  }

  /**
   * set our controller
   * @param HardwareController $controller
   */
  protected function setController(HardwareController $controller){
    $this->controller = $controller;
  }

  /**
   * run zone
   * @param int $zone
   * 
   * @return HardwareController
   */
  public function run(int $zone){
    return $this->controller->run($zone);
  }

  /**
   * stop zone
   * @param int $zone
   * @return HardwareController
   */
  public function stop(int $zone){
    return $this->controller->stop($zone);
  }

  /**
   * this zones status
   * @param int $zone
   * @return int 0 or 1
   */
  public function status(int $zone){
    return $this->controller->status($zone);
  }
}
