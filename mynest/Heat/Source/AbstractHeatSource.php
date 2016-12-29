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

/**
 * abstract heat sources
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
abstract class AbstractHeatSource{
		/**
		 * heat source qualities
		 */
		protected $qualities;

		/**
		 * @param mixed $qualities passed from config when instantiating
		 */
		public function __construct($qualities){
				$this->qualities = $qualities;
		}

		/**
		 * how much temp rise for this time
		 */
		abstract public function tempRise(\DateTime $date);
}

