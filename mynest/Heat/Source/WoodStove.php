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
use constellation\mynest\Heat\Source\HeatSource;
use constellation\mynest\Schedules\Schedule;
use DateTime;


/**
 * class describing a wood stove
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class WoodStove extends HeatSource {
  protected $away = false;
}

