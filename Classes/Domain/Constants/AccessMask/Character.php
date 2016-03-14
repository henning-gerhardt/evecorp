<?php

/* * *************************************************************
 * Copyright notice
 *
 * (c) 2016 Henning Gerhardt
 *
 * All rights reserved
 *
 * This script is part of the TYPO3 project. The TYPO3 project is
 * free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 *
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This copyright notice MUST APPEAR in all copies of the script!
 * ************************************************************* */

namespace Gerh\Evecorp\Domain\Constants\AccessMask;

/**
 *
 */
class Character {

	/**
	 * Current balance of characters wallet.
	 */
	const ACCOUNTBALANCE = 1;

	/**
	 * Entire asset list of character.
	 */
	const ASSETLIST = 2;

	/**
	 * Event attendee responses. Requires UpcomingCalendarEvents to function.
	 */
	const CALENDAREVENTATTENDEES = 4;

	/**
	 * Character Sheet information. Contains basic'Show Info'information along with clones, account balance, implants, attributes, skills, certificates and corporation roles.
	 */
	const CHARACTERSHEET = 8;

	/**
	 * List of character contacts and relationship levels.
	 */
	const CONTACTLIST = 16;

	/**
	 * Most recent contact notifications for the character.
	 */
	const CONTACTNOTIFICATIONS = 32;

	/**
	 * Characters Factional Warfare Statistics.
	 */
	const FACWARSTATS = 64;

	/**
	 * Character jobs, completed and active.
	 */
	const INDUSTRYJOBS = 128;

	/**
	 * "Characters kill log.
	 */
	const KILLLOG = 256;

	/**
	 * EVE Mail bodies. Requires MailMessages as well to function.
	 */
	const MAILBODIES = 512;

	/**
	 * List of all Mailing Lists the character subscribes to.
	 */
	const MAILINGLISTS = 1024;

	/**
	 * List of all messages in the characters EVE Mail Inbox.
	 */
	const MAILMESSAGES = 2048;

	/**
	 * List of all Market Orders the character has made.
	 */
	const MARKETORDERS = 4096;

	/**
	 * Medals awarded to the character.
	 */
	const MEDALS = 8192;

	/**
	 * List of recent notifications sent to the character.
	 */
	const NOTIFICATIONS = 16384;

	/**
	 * Actual body of notifications sent to the character. Requires Notification access to function.
	 */
	const NOTIFICATIONTEXTS = 32768;

	/**
	 * List of all Research agents working for the character and the progress of the research.
	 */
	const RESEARCH = 65536;

	/**
	 * Skill currently in training on the character. Subset of entire Skill Queue.
	 */
	const SKILLINTRAINING = 131072;

	/**
	 * Entire skill queue of character.
	 */
	const SKILLQUEUE = 262144;

	/**
	 * NPC Standings towards the character.
	 */
	const STANDINGS = 524288;

	/**
	 * Upcoming events on characters calendar.
	 */
	const UPCOMINGCALENDAREVENTS = 1048576;

	/**
	 * Wallet journal of character.
	 */
	const WALLETJOURNAL = 2097152;

	/**
	 * Market transaction journal of character.
	 */
	const WALLETTRANSACTIONS = 4194304;

	/**
	 * Character information, exposes skill points and current ship information on top of'Show Info'information.
	 */
	const CHARACTERINFOPUBLIC = 8388608;

	/**
	 * Sensitive Character Information, exposes account balance and last known location on top of the other Character Information call.
	 */
	const CHARACTERINFOPRIVATE = 16777216;

	/**
	 * EVE player account status.
	 */
	const ACCOUNTSTATUS = 33554432;

	/**
	 * List of all Contracts the character is involved in.
	 */
	const CONTRACTS = 67108864;

	/**
	 * Allows the fetching of coordinate and name data for items owned by the character.
	 */
	const LOCATIONS = 134217728;

	/**
	 * List of all personal bookmarks.
	 */
	const BOOKMARKS = 268435456;

	/**
	 * List of all chat channels the character owns or is an operator of.
	 */
	const CHATCHANNELS = 536870912;

}
