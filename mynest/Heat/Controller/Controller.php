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
/**
 * interface controller
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
interface Controller {

  /**
   * turn this zone on
   *
   * @param int $zone
   */
  public function run(int $zone);

  /**
   * turn this zone off
   * 
   * @param int $zone
   */
  public function stop(int $zone);

  /**
   * get zone status
   *
   * @param int $zone
   * @return int 0 or 1
   */
  public function status(int $zone);
}

