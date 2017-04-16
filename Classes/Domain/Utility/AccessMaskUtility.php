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

namespace Gerh\Evecorp\Domain\Utility;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class AccessMaskUtility {

    /**
     * Returns access mask for valid API keys
     *
     * @return \integer
     */
    public static function getAccessMask() {
        $extconf = \unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp']);
        $result = (\strlen($extconf['accessMask']) > 0) ?
                \trim($extconf['accessMask']) : 0;
        return \intval($result);
    }

}
