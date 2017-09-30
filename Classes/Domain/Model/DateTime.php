<?php

/*
 * Copyright notice
 *
 * (c) 2017 Henning Gerhardt
 *
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 3
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace Gerh\Evecorp\Domain\Model;

use DateTimeZone;

/**
 * A Decorator for the PHP DateTime object
 *
 * class must extends as \DateTime (no use statement!) or
 * class must be renamed to a better name
 */
class DateTime extends \DateTime {

    public function __construct($time = 'now', DateTimeZone $timezone = \NULL) {
        // We need to override the constructor, because Extbase tries to apply the reflection API
        // on it, which will result in a "Cannot determine default value for internal functions"
        // exception.

        parent::__construct($time, $timezone);
    }

}
