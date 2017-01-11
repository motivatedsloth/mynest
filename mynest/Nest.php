<?php

/*
 * This file is part of the constellation\mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest;
use constellation\mynest\Config;

/**
 * main nest class
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Nest {

  /**
   * current configuration
   * @var Config $config
   */
  protected $config;

  /**
   * @param Config $config
   */
  public function __construct(Config $config){
    $this->config = $config;
  }

  public function run(){
  }
}

