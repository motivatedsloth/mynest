<?php
/*
 * This file is part of the constellation\mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Heat\Controller;
use constellation\mynest\Heat\Controller\Controller;

/**
 * mock controller for testing
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Mock implements Controller {
  protected $zones = array();

  public function run(int $zone){
    $this->zones[$zone] = 1;
  }
  public function stop(int $zone){
    $this->zones[$zone] = 0;
  }
  public function status(int $zone){
    return $this->zones[$zone];
  }
}

