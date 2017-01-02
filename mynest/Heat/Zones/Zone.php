<?php

/*
 * This file is part of the constellation/mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Heat\Zones;
use constellation\mynest\Schedules\Schedule;

/**
 * class to describe a zone
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Zone {
		/**
		 * this zone number
		 * @var int $number
		 */
		protected $number;
		/**
		 * heating schedule for this zone
		 * @var Schedule $schedule
		 */
		protected $schedule;
		/**
		 * @param int $number zone number 1 or 2
		 */
		public function __construct($number){
				$this->number = $number;
		}
}

