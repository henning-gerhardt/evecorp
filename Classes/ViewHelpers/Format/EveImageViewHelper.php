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
class EveImageViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper {

	/**
	 * @var string
	 */
	protected $tagName = 'img';

	/**
	 * initialize arguments
	 */
	public function initializeArguments() {
		parent::initializeArguments();
		$this->registerUniversalTagAttributes();
		$this->registerArgument('characterId', 'integer', 'character id for image', true);
		$this->registerArgument('characterName', 'string', 'name of character', false, '');
		$this->registerArgument('size', 'integer', 'size of image', false, 64);
		$this->registerTagAttribute('alt', 'string', 'Alternative text for the image');
		$this->registerTagAttribute('width', 'string', 'with of image');
		$this->registerTagAttribute('height', 'string', 'height of image');
	}

	/**
	 * Render img tag for given character id, optional character name and size
	 *
	 * @return type
	 */
	public function render() {
		// use protocol less uri as of http://www.ietf.org/rfc/rfc3986.txt
		$imageUri = '//imageserver.eveonline.com/Character/' . $this->arguments['characterId'] . '_' . $this->arguments['size'] . '.jpg';
		$this->tag->addAttribute('src', $imageUri);
		$this->tag->addAttribute('alt', $this->arguments['characterName']);
		$this->tag->addAttribute('title', $this->arguments['characterName']);
		$this->tag->addAttribute('width', $this->arguments['size']);
		$this->tag->addAttribute('height', $this->arguments['size']);
		return $this->tag->render();
	}

}
