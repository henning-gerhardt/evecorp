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
namespace Gerh\Evecorp\Domain\Constants\AccessMask;

/**
 *
 */
class Corporation
{

    /**
     * Current balance of all corporation accounts.
     */
    const ACCOUNTBALANCE = 1;

    /**
     * List of all corporation assets.
     */
    const ASSETLIST = 2;

    /**
     * List of medals awarded to corporation members.
     */
    const MEMBERMEDALS = 4;

    /**
     * Exposes basic'Show Info'information as well as Member Limit and
     * basic division and wallet info.
     */
    const CORPORATIONSHEET = 8;

    /**
     * Corporate contact list and relationships.
     */
    const CONTACTLIST = 16;

    /**
     * Corporate secure container acess log.
     */
    const CONTAINERLOG = 32;

    /**
     * Corporations Factional Warfare Statistics.
     */
    const FACWARSTATS = 64;

    /**
     * Corporation jobs, completed and active.
     */
    const INDUSTRYJOBS = 128;

    /**
     * Corporation kill log.
     */
    const KILLLOG = 256;

    /**
     * Member roles and titles.
     */
    const MEMBERSECURITY = 512;

    /**
     * Member role and title change log.
     */
    const MEMBERSECURITYLOG = 1024;

    /**
     * Limited Member information.
     */
    const MEMBERTRACKINGLIMITED = 2048;

    /**
     * List of all corporate market orders.
     */
    const MARKETORDERS = 4096;

    /**
     * List of all medals created by the corporation.
     */
    const MEDALS = 8192;

    /**
     * List of all outposts controlled by the corporation.
     */
    const OUTPOSTLIST = 16384;

    /**
     * List of all service settings of corporate outposts.
     */
    const OUTPOSTSERVICEDETAIL = 32768;

    /**
     * Shareholders of the corporation.
     */
    const SHAREHOLDERS = 65536;

    /**
     * List of all settings of corporate starbases.
     */
    const STARBASEDETAIL = 131072;

    /**
     * NPC Standings towards corporation.
     */
    const STANDINGS = 262144;

    /**
     * List of all corporate starbases.
     */
    const STARBASELIST = 524288;

    /**
     * Wallet journal for all corporate accounts.
     */
    const WALLETJOURNAL = 1048576;

    /**
     * Market transactions of all corporate accounts.
     */
    const WALLETTRANSACTIONS = 2097152;

    /**
     * Titles of corporation and the roles they grant.
     */
    const TITLES = 4194304;

    /**
     * List of recent Contracts the corporation is involved in.
     */
    const CONTRACTS = 8388608;

    /**
     * Allows the fetching of coordinate and name data for items owned by
     * the corporation.
     */
    const LOCATIONS = 16777216;

    /**
     * Extensive Member information. Time of last logoff, last known location
     * and ship.
     */
    const MEMBERTRACKINGEXTENDED = 33554432;

    /**
     * List of all corporate bookmarks.
     */
    const BOOKMARKS = 67108864;

}
