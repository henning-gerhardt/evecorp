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

namespace Gerh\Evecorp\Domain\Model\Internal;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ApiKeyInfo {

    /**
     * @var string
     */
    protected $accessMask;

    /**
     *
     * @var array
     */
    protected $characters = [];

    /**
     * @var string
     */
    protected $expires;

    /**
     * @var string
     */
    protected $type;

    /**
     *
     * @return string
     */
    public function getAccessMask() {
        return $this->accessMask;
    }

    /**
     * Add a character
     *
     * @param Character $character
     */
    public function addCharacter(Character $character) {
        $this->characters[] = $character;
    }

    /**
     *
     * @return array
     */
    public function getCharacters() {
        return $this->characters;
    }

    /**
     *
     * @return string
     */
    public function getExpires() {
        return $this->expires;
    }

    /**
     *
     * @return string
     */
    public function getType() {
        return $this->type;
    }

    /**
     *
     * @param string $accessMask
     */
    public function setAccessMask($accessMask) {
        $this->accessMask = $accessMask;
    }

    /**
     *
     * @param array $characters
     */
    public function setCharacters(array $characters) {
        $this->characters = $characters;
    }

    /**
     *
     * @param string $expires
     */
    public function setExpires($expires) {
        $this->expires = $expires;
    }

    /**
     *
     * @param string $type
     */
    public function setType($type) {
        $this->type = $type;
    }

}
