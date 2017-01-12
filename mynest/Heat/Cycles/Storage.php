<?php
/*
 * This file is part of the constellation\mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Heat\Cycles;
use Symfony\Component\Yaml\Yaml;
use constellation\mynest\Heat\Cycles\Cycles;

/**
 * Cycle Storage
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Storage {
  protected $file = "/tmp/mynest/cycles.yml";

  public function __construct($file = null){
    if($file){
      $this->file = $file;
    }
    $dir = dirname($this->file);
    if(!file_exists($dir)){
      mkdir($dir, null, true);
    }
  }

  public function open(){
    return new Cycles(Yaml::parse(file_get_contents($this->file)));
  }

  public function save(Cycles $cycles){
    file_put_contents($this->file, Yaml::dump($cycles->toArray()));
  }
}

