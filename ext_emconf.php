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

$EM_CONF[$_EXTKEY] = array(
    'title' => 'EVE Online Corp Tool',
    'description' => 'Using different EVE services: direct from CCP through PhealNG or third party sites like eve-central.com',
    'category' => 'plugin',
    'author' => 'Henning Gerhardt',
    'author_company' => '',
    'author_email' => 'henning.gerhardt@web.de',
    'dependencies' => 'extbase,fluid',
    'clearCacheOnLoad' => 1,
    'state' => 'alpha',
    'version' => '0.6.0',
    'constraints' => array(
        'depends' => array(
            'php' => '5.6.0',
            'typo3' => '7.6.0-7.9.99',
            'extbase' => '7.6.0-7.9.99',
            'fluid' => '7.6.0-7.9.99',
        ),
    ),
    'autoload' => array(
        'psr-4' => array(
            'Gerh\\Evecorp\\' => 'Classes',
        )
    )
);
