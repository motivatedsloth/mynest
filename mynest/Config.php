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
use constellation\mynest\Heat\Controller\Controller;
use constellation\mynest\Heat\Zones\Zone;
use constellation\mynest\Heat\Source\HeatSource;

/**
 * manage configuration
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Config {
  /**
   * default config file
   * @var string filename
   */
  protected $file = __DIR__ . "/../config/config.yml";

  /**
   * our controller instance
   */
  protected $controller;

  /**
   * our zone instances
   */
  protected $zones;

  /**
   * our uncontrolled heat sources
   */
  protected $sources;

  /**
   * parsed config
   * @var array
   */
  protected $config;

  /**
   * controllers
   * @var array of controller class names
   */
  protected $controllers = array(
    "pi"=>"constellation\mynest\Heat\Controller\Pi"
  );

  /**
   * heat sources
   * @var array of heat source class names
   */
  protected $heatSources = array(
    "controllable"=>"constellation\mynest\Heat\Source\Controllable",
    "woodstove"=>"constellation\mynest\Heat\Source\WoodStove",
  );

  public function __construct($file = null){
    if($file){
      $this->file = $file;
    }
    $this->config = Yaml::parse(file_get_contents($this->file));
  }

  /**
   * get or set controller
   * @param Controller $controller optional controller
   * @return Controller|Config Controller when getting Config when setting
   */
  public function controller(Controller $controller = null){
    if($controller){
      $this->controller = $controller;
      return $this;
    }
    if(!isset($this->controller)){
      $ct = $this->controllers[$this->config['controller']];
      $this->controller(new $ct);
    }
    return $this->controller;
  }

  /**
   * get/set/remove zones
   * @param Zone $zone optional zone
   * @param bool $remove true to remove supplied Zone
   * @return array|Config array of Zone objects when getting, Config when setting
   */
  public function zones(Zone $zone = null, $remove = false){
    if(!isset($this->zones)){
      $this->zones = array();
      foreach($this->config['zones'] as $cz){
        $this->zones(new Zone($cz));
      }
    }
    if($zone){
      if($remove){
        unset($this->zones[$zone->getZone()]);
      }else{
        $this->zones[$zone->getZone()] = $zone;
      }
      return $this;
    }
    return $this->zones;
  }

  /**
   * get/set sources
   * @param HeatSource $source optional source
   * @param bool $remove true to remove supplied HeatSource
   * @return array|Config array of HeatSource objects when getting, Config when setting
   */
  public function sources(HeatSource $source = null, $remove = false){
    if(!isset($this->sources)){
      $this->sources = array();
      foreach($this->config['sources'] as $cls=>$cfg){
        $cls = $this->heatSources[$cls];
        $this->sources(new $cls($cfg));
      }
    }
    if($source){
      if($remove){
        foreach($this->sources as $idx=>$src){
          if($src == $source){
            unset($this->sources[$idx]);
            break;
          }
        }
      }else{
        $this->sources[] = $source;
      }
      return $this;
    }
    return $this->sources;
  }

  /**
   * @return array for saving config
   */
  public function toArray(){
    $ret = array();
    $ret['controller'] = $this->controller->type;
    foreach($this->zones as $zone){
      $ret['zones'][] = $zone->toArray();
    }
    foreach($this->sources as $source){
      $ret['sources'][] = $source->toArray();
    }
    return $ret;
  }

}

