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
/**
 * interface controller
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
interface Controller {
  /**
   * system on
   * @param Zone $zone
   */
  public function run(Zone $zone);
  /**
   * system off
   * @param Zone $zone
   */
  public function stop(Zone $zone);
}

