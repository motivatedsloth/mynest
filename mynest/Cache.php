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
use Symfony\Component\Yaml\Yaml;

/**
 * Cache Storage
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Cache {
  /**
   * our cache directory
   * @var string $dir dirctory
   */
  protected $dir;
  
  public function __construct($dir = "cache"){
    $this->dir = $dir;
    //we are dealing with local dir
    if(substr($this->dir, 0, 1) != "/"){
      $this->dir = dirname(__DIR__) . "/" . $this->dir;

    }
    if(!file_exists($this->dir)){
      mkdir($this->dir, null, true);
    }
  }

  public function open($key){
    return Yaml::parse(file_get_contents($this->filename($key)));
  }

  public function save($key, $data){
    if(!is_array($data)){
      $vals = $data->toArray();
    }else{
      $vals = $data;
    }
    file_put_contents($this->filename($key), Yaml::dump($vals));
  }

  /**
   * turn key to filename
   */
  protected function filename($key){
    return $this->dir . "/" . $key . ".yml";
  }
}

