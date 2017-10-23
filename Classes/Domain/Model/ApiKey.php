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

use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;

/**
 *
 *
 * @package evecorp
 * @license http://www.gnu.org/licenses/gpl.html GNU General Public License, version 3 or later
 *
 */
class ApiKey extends AbstractEntity
{

    /**
     * @var \integer
     * @validate Number
     */
    protected $accessMask;

    /**
     * @var \Gerh\Evecorp\Domain\Model\DateTime
     */
    protected $expires;

    /**
     * @var \integer
     * @validate NotEmpty
     * @validate Number
     * @validate NumberRange(minimum=1, maximum=2147483647)
     */
    protected $keyId;

    /**
     * @var \string
     * @validate NotEmpty
     * @validate StringLength(minimum=64, maximum=64)
     */
    protected $vCode;

    /**
     * Returns access mask of API key
     *
     * @return \integer
     */
    public function getAccessMask()
    {
        return $this->accessMask;
    }

    /**
     * Set acces mask for API key
     *
     * @param \integer $accessMask
     */
    public function setAccessMask($accessMask)
    {
        $this->accessMask = \intval($accessMask);
    }

    /**
     * Returns date of API key expire
     *
     * @return DateTime | NULL if no expire date
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * Set date when an API key get expired
     *
     * @param DateTime $expires
     */
    public function setExpires(DateTime $expires = \NULL)
    {
        $this->expires = $expires;
    }

    /**
     * Returns key id of this API key
     *
     * @return \integer
     */
    public function getKeyId()
    {
        return $this->keyId;
    }

    /**
     * Set key id for this API key
     *
     * @param \integer $keyId
     */
    public function setKeyId($keyId)
    {
        $this->keyId = \intval($keyId);
    }

    /**
     * Returns verification code (vCode) of API key
     *
     * @return \string
     */
    public function getVCode()
    {
        return $this->vCode;
    }

    /**
     * Set verification code (vCode) for this API key
     *
     * @param \string $vCode
     */
    public function setVCode($vCode)
    {
        $this->vCode = $vCode;
    }

    /**
     * Check if access mask provides right to restricted information group.
     *
     * @param \integer $toProveAgainst
     * @return \boolean
     */
    public function hasAccessTo($toProveAgainst)
    {
        return (($this->accessMask & $toProveAgainst) > 0) ? \TRUE : \FALSE;
    }
}
