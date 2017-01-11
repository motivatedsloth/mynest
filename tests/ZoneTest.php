<?php
/*
 * This file is part of the constellation\mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
use PHPUnit\Framework\TestCase;
use constellation\mynest\Config;
use constellation\mynest\Zones\Zone;

/**
 * test class for Zone object
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class ZoneTest extends TestCase {
  public function testZones(){
    $config = new Config;
    $zone = $config->zones()[1];
    $this->assertEquals(1, $zone->getZone());
    $this->assertEquals(60, $zone->val(new DateTime("2017-01-02T23:00")) );
  }
}

