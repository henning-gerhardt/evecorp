<?php
namespace Gerh\Evecorp\Service;

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
	 * @var \string
	 */
	protected $phealCacheDirectory;

	/**
	 * @var \integer
	 */
	protected $phealConnectionTimeout;

	/**
	 * @var \boolean
	 */
	protected $phealVerifyHttpsConnecton;

	/**
	 * @var \Pheal\Pheal
	 */
	protected $pheal;

	/**
	 * class constructor
	 * @return void
	 */
	public function __construct() {
		$extconf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp']);
		$this->setPhealCacheDirectory($extconf['phealCacheDirectory']);
		$this->setHttpsConnectionVerified($extconf['phealVerifyingHttpsConnection']);
		$this->setConnectionTimeout($extconf['phealConnectionTimeout']);

		Config::getInstance()->http_ssl_verifypeer = $this->isHttpsConnectionVerified();
		Config::getInstance()->http_timeout = $this->getConnectionTimeout();
		Config::getInstance()->cache = new \Pheal\Cache\FileStorage($this->getPhealCacheDirectory() . DIRECTORY_SEPARATOR);
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

	/**
	 * Get used PhealNG cache directory
	 *
	 * @return \string
	 */
	public function getPhealCacheDirectory() {
		return $this->phealCacheDirectory;
	}

	/**
	 *
	 * @param \string $phealCacheDirectory
	 */
	protected function setPhealCacheDirectory($phealCacheDirectory) {
		if ((! \file_exists($phealCacheDirectory)) || (!\is_dir($phealCacheDirectory)) || (! \is_writable($phealCacheDirectory))) {
			$this->phealCacheDirectory = \realpath(PATH_site . 'typo3temp');
		} else {
			$this->phealCacheDirectory = \realpath($phealCacheDirectory);
		}
	}

	/**
	 * Get current connection timeout in seconds used in HTTPS connections
	 *
	 * @return \integer
	 */
	public function getConnectionTimeout() {
		return $this->phealConnectionTimeout;
	}

	/**
	 * Set connection timeout in seconds
	 *
	 * @param \integer $timeout
	 */
	protected function setConnectionTimeout($timeout) {
		if (\is_int($timeout) && ($timeout > 0)) {
			$this->phealConnectionTimeout = (int) $timeout;
		} else {
			$this->phealConnectionTimeout = 120;
		}
	}

	/**
	 * Is HTTPS connection verified?
	 *
	 * @return \boolean
	 */
	public function isHttpsConnectionVerified() {
		return $this->phealVerifyHttpsConnecton;
	}

	/**
	 * Set if HTTPS connection should be verified. Host must be able to verify certificates!
	 *
	 * @param \boolean $verified
	 */
	protected function setHttpsConnectionVerified($verified) {
		if (\is_bool($verified) && $verified) {
			$this->phealVerifyHttpsConnecton = true;
		} else {
			$this->phealVerifyHttpsConnecton = false;
		}
	}
}
