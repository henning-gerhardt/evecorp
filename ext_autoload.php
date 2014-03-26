<?php
$extPath =  \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::extPath('evecorp');
$srcPath = $extPath . 'Pheal/';
$prefix  = 'pheal_';
$default = array();

$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($srcPath));
$regex = new RegexIterator($iterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($regex as $key => $value) {
    $file = realpath($key);
    $basename = basename($file);
    $pureBasename = basename($file, '.php');
    $parentDirname = basename(dirname($file));
    if ($parentDirname === 'Pheal') {
        $newkey = $prefix . strtolower($pureBasename);
        $newvalue = $basename;
    } else {
		$newkey = $prefix . strtolower($parentDirname) .'_' . strtolower($pureBasename);
        $newvalue = $parentDirname . DIRECTORY_SEPARATOR . $basename;
	}
    
    $default[$newkey] = realpath($srcPath . DIRECTORY_SEPARATOR . $newvalue);
}

return $default;
