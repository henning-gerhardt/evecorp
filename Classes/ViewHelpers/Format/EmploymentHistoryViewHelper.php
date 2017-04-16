<?php

/* * *************************************************************
 *  Copyright notice
 *
 *  (c) 2016 Henning Gerhardt
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

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
