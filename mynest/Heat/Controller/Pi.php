<?php

/*
 * This file is part of the constellation/mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\Heat\Controller;
use PhpGpio\Gpio;

/**
 * class to work with a pi controller
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Pi implements Controller {
		/**
		 * mapping pin numbers to zones
		 * @var array $mapping
		 */
		protected $mapping = array(1=>17, 2=>27, 3=>22);
		/**
		 * What pin is this zone using?
		 * @param int $zone 
		 */
		public function getPin($zone){
				return $this->mapping[$zones];
		}
}

