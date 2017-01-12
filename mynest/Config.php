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
 * manage configuration
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Config {
  /**
   * default config file
   * @var string filename
   */
  static protected $file = __DIR__ . "/../config/config.yml";

  /**
   * parsed config
   * @var array
   */
  static protected $config;

  public static function load($file = null){
    if($file){
      self::$file = $file;
    }
    self::$config = Yaml::parse(file_get_contents(self::$file));
  }

  public static function save($file = null){
    if(!isset(self::$config)){
      throw new Exception("Config not loaded, cannot save");
    }
    if($file){
      self::$file = $file;
    }
    file_put_contents( self::$file, Yaml::dump(self::$config));
  }

  public static function set($key, $value){
    if(!isset(self::$config)){
      self::load();
    }
    self::$config[$key] = $value;
    self::save();
  }

  public static function get($key){
    if(!isset(self::$config)){
      self::load();
    }
    return self::$config[$key];
  }
}

