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
use constellation\mynest\Heat\Zone\Zone;
use constellation\mynest\Schedules\Schedule;

/**
 * read and save config files
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
  public function controller(){
  }

}

