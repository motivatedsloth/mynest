<?php

/*
 * This file is part of the constellation\mynest package.
 *
 * (c) Constellation Web Services, LLC <http://www.constellationwebservices.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace constellation\mynest\Heat\Controller\Pi;
use PhpGpio\Gpio as PiGpio;
use InvalidArgumentException;
use RuntimeException;
/**
 * Gpio on Raspberry Pi
 *
 * @author Alan Buss <al@constellationwebservices.com>
 */
class Gpio extends PiGpio {

  /**
   * get status for pin
   * @param int $pinNo
   * @return int 0 or 1 as current state of pin
   * @throws InvalidArgumentException on bad pin no
   * @throws RuntimeException if pin is used as input
   * @throws RuntimeException if pin is not exported
   */
  public function status($pinNo){
    if (!$this->isValidPin($pinNo)) {
      throw new InvalidArgumentException("$pinNo is not a valid pin. Unable to get status");
      return false;
    }
    if ($this->isExported($pinNo)) {
      if ($this->currentDirection($pinNo) != "in") {
        return file_get_contents('/sys/class/gpio/gpio'.$pinNo.'/value');
      } else {
        throw new RuntimeException('Can only read status of pins with out direction.');
      }
    }
    throw new RuntimeException('$pinNo is not exported, cannot read status');
  }//status
}//class

