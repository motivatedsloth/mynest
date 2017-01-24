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
use constellation\mynest\Heat\Zones\Zone;

/**
 * mock controller for testing
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Mock implements Controller {
  protected $zones = array();

  public function run(Zone $zone){
    $this->zones[$zone->getZone()] = 1;
  }
  public function stop(Zone $zone){
    $this->zones[$zone->getZone()] = 0;
  }
  public function status(Zone $zone){
    return $this->zones[$zone->getZone()];
  }
}

