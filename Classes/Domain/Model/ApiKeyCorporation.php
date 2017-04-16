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

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ApiKeyCorporation extends \Gerh\Evecorp\Domain\Model\ApiKey {

    /**
     * @var \Gerh\Evecorp\Domain\Model\Corporation
     * @lazy
     */
    protected $corporation;

    /**
     * Returns corporation
     *
     * @return \Gerh\Evecorp\Domain\Model\Corporation
     */
    public function getCorporation() {
        if ($this->corporation instanceof \TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy) {
            $this->corporation->_loadRealInstance();
        }

        return $this->corporation;
    }

    /**
     * Set corporation
     *
     * @param \Gerh\Evecorp\Domain\Model\Corporation $corporation
     */
    public function setCorporation(\Gerh\Evecorp\Domain\Model\Corporation $corporation) {
        $this->corporation = $corporation;
    }

}
