<?php
/*
 * This file is part of the constellation\mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Heat;
use constellation\mynest\Heat\Source\HeatSource;
use ArrayObject;
use ArrayIterator;

/**
 * manage multiple sources
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Sources extends ArrayObject{

  /**
   * our source objects
   * @var array
   */
  protected $sources;

  /**
   * heat sources
   * @var array of heat source class names
   */
  protected $heatSources = array(
    "woodstove"=>"constellation\mynest\Heat\Source\WoodStove",
  );

  /**
   * @param array to configure sources
   */
  public function __construct(array $sources = array()){
    foreach($sources as $type=>$source){
      $cls = $this->heatSources[$type];
      $this->set(new $cls($source));
    }
  }

  /**
   * set a source
   * @param HeatSource $source
   * @return Sources
   */
  public function set(HeatSource $source){
    $this->sources[] = $source;
    return $this;
  }

  /**
   * get array of HeatSource objects
   * @return array of HeatSource objects
   */
  public function get(){
      return $this->sources;
  }

  /**
   * array appropriate for __construct
   * @return array
   */
  public function toArray(){
    $ret = array();
    foreach($this->sources as $source){
      $ret[] = $source->toArray();
    }
    return $ret;
  }

  public function getIterator(){
    return new ArrayIterator($this->sources);
  }
}

