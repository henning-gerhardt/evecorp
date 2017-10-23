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
namespace Gerh\Evecorp\Service;

use Pheal\Pheal;
use Pheal\Core\Config;
use TYPO3\CMS\Core\SingletonInterface;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class PhealService implements SingletonInterface
{

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
     * @var \string
     */
    protected $phealFileMask;

    /**
     * @var \string
     */
    protected $phealFolderMask;

    /**
     * class constructor
     *
     * @param \integer $keyId   optional userID / keyID for Pheal instance
     * @param \string $vCode    optional apikey / vCode for Pheal instance
     * @param \string $scope    optional scope to use, default account, could be change while runtime
     * @return void
     */
    public function __construct($keyId = \NULL, $vCode = \NULL, $scope = 'account')
    {
        $extconf = \unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['evecorp']);
        $this->setPhealCacheDirectory($extconf['phealCacheDirectory']);
        $this->setHttpsConnectionVerified($extconf['phealVerifyingHttpsConnection']);
        $this->setConnectionTimeout($extconf['phealConnectionTimeout']);
        $this->setFileMask($extconf['phealFileCreateMask']);
        $this->setFolderMask($extconf['phealFolderCreateMask']);

        Config::getInstance()->http_ssl_verifypeer = $this->isHttpsConnectionVerified();
        Config::getInstance()->http_timeout = $this->getConnectionTimeout();
        Config::getInstance()->cache = new \Pheal\Cache\FileStorage($this->getPhealCacheDirectory() . \DIRECTORY_SEPARATOR, $this->getUmaskOptions());
        Config::getInstance()->access = new \Pheal\Access\StaticCheck();
        $this->pheal = new Pheal($keyId, $vCode, $scope);
    }

    /**
     * Return fully configured Pheal object.
     *
     * @return Pheal\Pheal
     */
    public function getPhealInstance()
    {
        return $this->pheal;
    }

    /**
     * Get used PhealNG cache directory
     *
     * @return \string
     */
    public function getPhealCacheDirectory()
    {
        return $this->phealCacheDirectory;
    }

    /**
     * Set pheal cache directory
     *
     * @param \string $phealCacheDirectory
     */
    protected function setPhealCacheDirectory($phealCacheDirectory)
    {
        $this->phealCacheDirectory = \realpath(PATH_site . 'typo3temp');
        if ((\file_exists($phealCacheDirectory)) && (\is_dir($phealCacheDirectory)) && (\is_writable($phealCacheDirectory))) {
            $this->phealCacheDirectory = \realpath($phealCacheDirectory);
        }
    }

    /**
     * Get current connection timeout in seconds used in HTTPS connections
     *
     * @return \integer
     */
    public function getConnectionTimeout()
    {
        return $this->phealConnectionTimeout;
    }

    /**
     * Set connection timeout in seconds
     *
     * @param \integer $timeout
     */
    protected function setConnectionTimeout($timeout)
    {
        $this->phealConnectionTimeout = 120;
        if (\is_int($timeout) && ($timeout > 0)) {
            $this->phealConnectionTimeout = (int) $timeout;
        }
    }

    /**
     * Is HTTPS connection verified?
     *
     * @return \boolean
     */
    public function isHttpsConnectionVerified()
    {
        return $this->phealVerifyHttpsConnecton;
    }

    /**
     * Set if HTTPS connection should be verified. Host must be able to verify certificates!
     *
     * @param \boolean $verified
     */
    protected function setHttpsConnectionVerified($verified)
    {
        $this->phealVerifyHttpsConnecton = \FALSE;
        if (\is_bool($verified) && $verified) {
            $this->phealVerifyHttpsConnecton = \TRUE;
        }
    }

    /**
     * Get current used file mask
     *
     * @return \string
     */
    public function getFileMask()
    {
        return $this->phealFileMask;
    }

    /**
     * Set file mask
     *
     * @param \string $fileMask
     */
    protected function setFileMask($fileMask)
    {
        $this->phealFileMask = 0666;
        if (!empty($fileMask)) {
            $this->phealFileMask = \octdec($fileMask);
        }
    }

    /**
     * Get current used folder mask
     *
     * @return \string
     */
    public function getFolderMask()
    {
        return $this->phealFolderMask;
    }

    /**
     * Set folder mask
     *
     * @param \string $folderMask
     */
    protected function setFolderMask($folderMask)
    {
        $this->phealFolderMask = 0777;
        if (!empty($folderMask)) {
            $this->phealFolderMask = \octdec($folderMask);
        }
    }

    /**
     * Return file and folder mask as Pheal Filestorage its expects
     *
     * @return array
     */
    public function getUmaskOptions()
    {
        return [
            'umask' => $this->getFileMask(),
            'umask_directory' => $this->getFolderMask(),
        ];
    }
}
