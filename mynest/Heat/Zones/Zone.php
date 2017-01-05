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
use constellation\mynest\Heat\Source\Controllable;
use DateTime;

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
         * @var Controllable heat source
         */
        protected $heatSource;

		/**
		 * @param int $number zone number 1 or 2
		 */
		public function __construct($number){
				$this->number = $number;
		}

        /**
         * @return int zone number
         */
        public function getZone(){
          return $this->number;
        }

        /**
         * set the schedule
         * @param Schedule $schedule
         * @return Zone $this
         */
        public function setSchedule(Schedule $schedule){
          $this->schedule = $schedule;
          return $this;
        }
        
        /**
         * get scheduled value for time
         * @param DateTime $date
         */
        public function val(DateTime $date){
          return $this->schedule->val($date);
        }

        /**
         * set heat source
         * @param Controllable $src
         * @return Zone $this
         */
        public function setHeatSource(Controllable $src){
          $this->heatSource = $src;
          return $this;
        }

        /**
         * @return Controllable 
         */
        public function getHeatSource(){
          return $this->heatSource;
        }
}

