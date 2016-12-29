<?php

/*
 * This file is part of the constellation/mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Heat\Source;
use constellation\mynest\Heat\Source\AbstractHeatSource;

/**
 * class describing a wood stove
 * construct with an array(8=>50, 21=>20) or number 50 if rise is constant
 * key is the hour, value is the rise
 * above array means from 8am to 9pm stove raises temp 50, from 9p to 8a raise is 20
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class WoodStove extends AbstractHeatSource {

		/**
		 * find tempRise for given time
		 */
		public function tempRise(\DateTime $date){
				if(!is_array($this->qualities)){
						return $this->qualities;
				}else{
						$hour = $date->format("G");
						$breaks = array_keys($this->qualities);
						sort($breaks);
						for( $cur = reset($breaks); $nxt = next($breaks); ){
								if($hour >= $cur && $hour < $nxt){
										break;
								}else{
										$cur = $nxt;
								}
						}
						return $this->qualities[$cur];
				}
		}
}

