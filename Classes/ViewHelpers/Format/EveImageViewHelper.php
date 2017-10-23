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

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class EveImageViewHelper extends AbstractTagBasedViewHelper
{

    /**
     * @var string
     */
    protected $tagName = 'img';

    /**
     * initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerUniversalTagAttributes();
        $this->registerArgument('characterId', 'integer', 'character id for image', \TRUE);
        $this->registerArgument('characterName', 'string', 'name of character', \FALSE, '');
        $this->registerArgument('size', 'integer', 'size of image', \FALSE, 64);
        $this->registerTagAttribute('alt', 'string', 'Alternative text for the image');
        $this->registerTagAttribute('width', 'string', 'with of image');
        $this->registerTagAttribute('height', 'string', 'height of image');
    }

    /**
     * Render img tag for given character id, optional character name and size
     *
     * @return type
     */
    public function render()
    {
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
