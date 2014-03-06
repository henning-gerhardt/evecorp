<?php

$EM_CONF[$_EXTKEY] = array(
    'title' => 'Eve Online Corp Tool: EveCentral data fetcher',
    'description' => 'Fetch and display remote data from eve-central.com',
    'category' => 'plugin',
    'author' => 'Henning Gerhardt',
    'author_company' => '',
    'author_email' => 'henning.gerhardt@web.de',
    'dependencies' => 'extbase,fluid',
    'clearCacheOnLoad' => 1,
    'state' => 'alpha',
    'version' => '0.2.0',
    'constraints' => array(
        'depends' => array(
            'php' => '5.4.0',
            'typo3' => '6.0',
            'extbase' => '6.0',
            'fluid' => '6.0',
        ),
    )
);
