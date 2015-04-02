<?php
$extPath =  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('evecorp');
$srcPath = $extPath . 'vendor/3rdpartyeve/phealng/lib/Pheal/';
$prefix  = 'Pheal\\';
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
		$newkey = $prefix . $parentDirname .'\\' . $pureBasename;
		$newvalue = $parentDirname . DIRECTORY_SEPARATOR . $basename;
	}

	$default[$newkey] = realpath($srcPath . DIRECTORY_SEPARATOR . $newvalue);
}

return $default;
