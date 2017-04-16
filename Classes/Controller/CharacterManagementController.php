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

namespace Gerh\Evecorp\Controller;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class CharacterManagementController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController {

    /**
     * Show character information
     *
     * @param \Gerh\Evecorp\Domain\Model\Character $character
     * @return void
     */
    public function showAction(\Gerh\Evecorp\Domain\Model\Character $character) {
        $this->view->assign('character', $character);
    }

}
