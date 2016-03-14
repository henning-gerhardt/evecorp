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

$extPath = \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('evecorp');
$srcPath = $extPath . 'vendor/3rdpartyeve/phealng/lib/Pheal/';
$prefix = 'Pheal\\';
$default = array();

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($srcPath));
$regex = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($regex as $key => $value) {
	$file = realpath($key);
	$basename = basename($file);
	$pureBasename = basename($file, '.php');
	$parentDirname = basename(dirname($file));
	if ($parentDirname === 'Pheal') {
		$newkey = $prefix . $pureBasename;
		$newvalue = $basename;
	} else {
		$newkey = $prefix . $parentDirname . '\\' . $pureBasename;
		$newvalue = $parentDirname . DIRECTORY_SEPARATOR . $basename;
	}

	$default[$newkey] = realpath($srcPath . DIRECTORY_SEPARATOR . $newvalue);
}

return $default;
