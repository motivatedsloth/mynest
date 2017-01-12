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
use configuration\mynest\Heat\Cycles\Storage;

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

  protected function cycles(){
    $storage = new Storage;
    $cycles = $storage->open();
    $updated = false;
    foreach($config->zones() as $zone){
      if(!$cycles->get($zone)){
        $cycles->set($zone, $this->createCycle($zone));
        $updated = true;
      }
    }
    if($updated){
      $storage->save($cycles);
    }
    return $cycles;
  }
}

