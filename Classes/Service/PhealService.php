<?php
namespace gerh\Evecorp\Service;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2014 Henning Gerhardt 
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
 ***************************************************************/

use Pheal\Pheal;
use Pheal\Core\Config;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PhealService implements \TYPO3\CMS\Core\SingletonInterface {

	/**
	 * @var Pheal\Pheal 
	 */
	protected $pheal;
	
	public function __construct() {
		$tempPath = PATH_site . 'typo3temp' . DIRECTORY_SEPARATOR . 'phealng' . DIRECTORY_SEPARATOR;
		Config::getInstance()->http_ssl_verifypeer = false;
		Config::getInstance()->http_timeout = 120;
		Config::getInstance()->cache = new \Pheal\Cache\FileStorage($tempPath);
		Config::getInstance()->access = new \Pheal\Access\StaticCheck();
		$this->pheal = new Pheal();
	}
	
	/**
	 * Return fully configured Pheal object.
	 * @return Pheal\Pheal
	 */
	public function getPhealInstance() {
		return $this->pheal;
	}
}
