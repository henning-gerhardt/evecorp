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

use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Core\Utility\ExtensionManagementUtility;
use TYPO3\CMS\Extensionmanager\Utility\InstallUtility;
use TYPO3\CMS\Install\Service\SqlSchemaMigrationService;

/**
 * Class for updating Evecorp data
 *
 */
class ext_update {

    /**
     * @var string Name of the extension this controller belongs to
     */
    protected $extensionName = 'evecorp';

    /**
     * @var \TYPO3\CMS\Extbase\Object\ObjectManager Extbase Object Manager
     */
    protected $objectManager;

    /**
     * @var \TYPO3\CMS\Extensionmanager\Utility\InstallUtility Extension Manager Install Tool
     */
    protected $installTool;

    /**
     * Imports a static tables SQL File (ext_tables_static+adt)
     *
     * @param string $extensionSitePath
     * @return void
     */
    protected function importStaticSqlFile($extensionSitePath) {
        $extTablesStaticSqlFile = $extensionSitePath . 'ext_tables_static+adt.sql';
        $extTablesStaticSqlContent = '';
        if (file_exists($extTablesStaticSqlFile)) {
            $extTablesStaticSqlContent .= GeneralUtility::getUrl($extTablesStaticSqlFile);
        }
        if ($extTablesStaticSqlContent !== '') {
            $this->installTool->importStaticSql($extTablesStaticSqlContent);
        }
    }

    /**
     * Stub function for the extension manager
     *
     * @return \boolean true to allow access
     */
    public function access() {
        return \TRUE;
    }

    /**
     * Update table structure and import static data
     *
     * @return \string
     */
    public function main() {

        $content = '';
        $this->objectManager = GeneralUtility::makeInstance(ObjectManager::class);
        $this->installTool = $this->objectManager->get(InstallUtility::class);
        $installToolSqlParser = GeneralUtility::makeInstance(SqlSchemaMigrationService::class);
        $this->installTool->injectInstallToolSqlParser($installToolSqlParser);

        // Process the database updates of this base extension (we want to re-process these updates every time the update script is invoked)
        $extensionSitePath = ExtensionManagementUtility::extPath(GeneralUtility::camelCaseToLowerCaseUnderscored($this->extensionName));
        $content .= '<p>Updating tables for evecorp extension</p>';

        $this->importStaticSqlFile($extensionSitePath);

        return $content;
    }

}
