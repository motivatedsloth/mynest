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
use constellation\mynest\Heat\Controller\Controller;

/**
 * test class for Config object
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class ConfigTest extends TestCase {
  public function testConfig(){
    $config = new Config;
    $this->assertTrue(true);
    $zones = $config->zones();
    $this->assertEquals(1, $zones[1]->getZone());
  }
}

