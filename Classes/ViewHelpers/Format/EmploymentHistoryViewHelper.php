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

namespace Gerh\Evecorp\ViewHelpers\Format;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EmploymentHistoryViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper {

    /**
     * Render employment history of given character
     *
     * @param \Gerh\Evecorp\Domain\Model\Character $character
     * @return \string
     */
    public function render(\Gerh\Evecorp\Domain\Model\Character $character) {

        $output = '';
        $lastJoinDate = NULL;

        foreach ($character->getEmployments() as $employment) {
            $output .= '<tr>';
            $output .= '<td>' . $employment->getCorporation()->getCorporationName() . '</td>';
            $output .= '<td>' . $employment->getStartDate()->format('d.m.Y H:i') . '</td>';

            if ($lastJoinDate != NULL) {
                $output .= '<td>' . $lastJoinDate->format('d.m.Y H:i') . '</td>';
            } else {
                $output .= '<td>today</td>';
                $lastJoinDate = new \DateTime();
            }

            $output .= '<td>' . $employment->getStartDate()->diff($lastJoinDate)->format('%a days') . '</td>';
            $output .= '</tr>' . PHP_EOL;

            $lastJoinDate = $employment->getStartDate();
        }

        return $output;
    }

}
